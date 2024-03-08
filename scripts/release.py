#!/usr/bin/env python3

import argparse, logging, sys

from github import create_merge_request, merge_pr, create_release
from git_shell import create_new_branch, commit_changes, push_changes, get_current_git_branch
from packages import read_packages

logging.basicConfig(level=logging.INFO)

def main(release_name, branch):
    logging.info(f'Current branch is {branch}')
    packages = read_packages('packages.json')
    for package, folder in packages.items():
        logging.info(f"Processing package {package} in folder {folder}")
        create_new_branch(folder, branch)
        break
        # commit_changes(folder)
        # push_changes(folder, branch)
        # create_merge_request(folder, branch, release_name)
        # merge_pr(folder, release_name)
        # create_release(folder, branch, release_name)

if __name__ == '__main__':
    parser = argparse.ArgumentParser(description='Release script to handle package versions.')
    parser.add_argument('release_name', type=str, help='Name of the release')
    args = parser.parse_args()

    branch = get_current_git_branch()
    main(args.release_name, branch)
