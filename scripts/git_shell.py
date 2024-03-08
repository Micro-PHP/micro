from shell import execute_shell_command


def get_current_git_branch(cwd=None):
    current_branch = execute_shell_command('git branch --show-current', cwd=cwd, capture_output=True)
    return current_branch

def create_new_branch(cwd, new_branch: str):
    execute_shell_command(f'git checkout -b {new_branch}', cwd)

def commit_changes(cwd, message='Release changes'):
    execute_shell_command('git add .', cwd)
    execute_shell_command(f'git commit -m "{message}"', cwd)

def push_changes(cwd, new_branch: str):
    execute_shell_command(f'git push origin {new_branch}', cwd)
