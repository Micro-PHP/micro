from shell import execute_shell_command


def create_merge_request(cwd, new_branch: str, release_name: str):
    execute_shell_command(f'gh pr create --base master --head {new_branch} --title "Release {release_name}" --body "Automated release PR for {release_name}"', cwd)

def merge_pr(cwd, release_name: str):
    execute_shell_command(f'gh pr merge --squash --delete-branch --subject "Merge Release {release_name}"', cwd)

def create_release(cwd, new_branch: str, release_name: str):
    execute_shell_command(f'gh release create {release_name} --target {new_branch} --title "{release_name}" --notes "Release notes for {release_name}"', cwd)
