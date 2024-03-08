#!/usr/bin/env python3

import os, git, logging

from exceptions import MissingBranchError
from packages import read_packages
from packagist import get_repository_link
from git_shell import get_current_git_branch  

logging.basicConfig(level=logging.INFO)

def ensure_folder_exists(func):
    def wrapper(package_folder, *args, **kwargs):
        if not os.path.exists(package_folder):
            os.makedirs(package_folder)
        return func(package_folder, *args, **kwargs)
    return wrapper

def change_directory(func):
    def wrapper(package_folder, *args, **kwargs):
        os.chdir(package_folder)
        return func(package_folder, *args, **kwargs)
    return wrapper

@ensure_folder_exists
@change_directory
def init_repository(package_folder, package_repo):
    try:
        repository = git.Repo('.')
    except git.exc.InvalidGitRepositoryError:
        logging.info(f'Initializing git repository in {package_folder}')
        repository = git.Repo.init('.')
    if 'origin' not in repository.remotes:
        logging.info(f'Adding remote origin {package_repo} to {package_folder}')
        repository.create_remote('origin', package_repo)
    return repository

def fetch(func):
    def wrapper(repository, *args, **kwargs):
        package_name = repository.remotes.origin.url.split('/')[-1].split('.')[0]
        logging.info(f'Fetching from remote origin {repository.remotes.origin.url} to {package_name}')
        repository.git.fetch()
        return func(repository, *args, **kwargs)
    return wrapper

def ensure_already_branch(func):
    def wrapper(repository, branch):
        if repository.active_branch.name == branch:
            package_name = repository.remotes.origin.url.split('/')[-1].split('.')[0]
            logging.info(f'Repository is already on {branch} branch for {package_name}')
            return
        return func(repository, branch)
    return wrapper

@fetch
@ensure_already_branch
def checkout(repository, branch):
    package_name = repository.remotes.origin.url.split('/')[-1].split('.')[0]
    try:
        logging.info(f'Checking out branch {branch} in {package_name}')
        repository.git.checkout('-f', branch)
    except git.exc.GitCommandError:
        logging.info(f'Branch {branch} does not exist in {package_name}')
        raise MissingBranchError(f'Branch {branch} does not exist in {package_name}')

def main(branch):
    missing_branch = []
    packages = read_packages('packages.json')

    for package, folder in packages.items():
        repository = init_repository(folder, get_repository_link(package))
        try:
            checkout(repository, branch)
        except MissingBranchError:
            missing_branch.append(package)
        except Exception as e:
            logging.error(e)

    if 0 < len(missing_branch):
        print(f'The following packages do not have the {branch} branch: {missing_branch}')

if __name__ == '__main__':
    main(get_current_git_branch())
