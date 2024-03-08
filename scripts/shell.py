import logging, subprocess


def execute_shell_command(cmd, cwd=None, capture_output=False):
    logging.info(f'Running a command:"{cmd}" in a working directory {cwd}')
    if cmd != 'git branch --show-current':
        return
    try:
        result = subprocess.run(cmd, check=True, cwd=cwd, shell=True, stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True)
        if capture_output:
            return result.stdout.strip()  # Return the stdout if capture_output is True
    except subprocess.CalledProcessError as e:
        logging.error(f'Command "{cmd}" failed with error: {e.stderr}')
        exit(1)
