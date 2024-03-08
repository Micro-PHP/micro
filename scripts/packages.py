import json

def read_packages(filename):
    with open(filename) as f:
        data = f.read()
        return json.loads(data)['packages']
