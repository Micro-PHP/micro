#!/usr/bin/env python3

import requests, os, git, logging, json

logging.basicConfig(level=logging.INFO)

current_branch = "2.x"

class MissingBranchError(Exception):
    pass

def read_packages(filename):
    with open(filename) as f:
        data = f.read()
        return json.loads(data)["packages"]

def get_repo_link(package):
    vendor, package = package.split("/")
    url = f"https://repo.packagist.org/p2/{vendor}/{package}.json"
    response = requests.get(url)
    return response.json()["packages"][f"{vendor}/{package}"][0]["source"]["url"]

def init_repo(folder, repo):
    if not os.path.exists(folder):
        os.makedirs(folder)
    os.chdir(folder)
    try:
        repo_obj = git.Repo(".")
    except git.exc.InvalidGitRepositoryError:
        logging.info(f"Initializing git repository in {folder}")
        repo_obj = git.Repo.init(".")
    if "origin" not in repo_obj.remotes:
        logging.info(f"Adding remote origin {repo} to {folder}")
        repo_obj.create_remote("origin", repo)
    return repo_obj

def fetch_and_checkout(repo_obj, branch):
    package = repo_obj.remotes.origin.url.split("/")[-1].split(".")[0]
    if repo_obj.active_branch.name == branch:
        logging.info(f"Repository is already on {branch} branch for {package}")
        return
    logging.info(f"Fetching from remote origin {repo_obj.remotes.origin.url} to {package}")
    repo_obj.git.fetch()
    try:
        logging.info(f"Checking out branch {branch} in {package}")
        repo_obj.git.checkout("-f", branch)
    except git.exc.GitCommandError:
        logging.info(f"Branch {branch} does not exist in {package}")
        raise MissingBranchError(f"Branch {branch} does not exist in {package}")

missing_branch = []

packages = read_packages("packages.json")

for package, folder in packages.items():
    repo = get_repo_link(package)
    repo_obj = init_repo(folder, repo)
    try:
        fetch_and_checkout(repo_obj, current_branch)
    except MissingBranchError as e:
        missing_branch.append(package)

print(f"The following packages do not have the {current_branch} branch: {missing_branch}")
