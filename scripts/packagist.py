#!/usr/bin/env python3

import requests

def get_repository_link(package):
    vendor, package_name = package.split('/')
    response = requests.get(f'https://repo.packagist.org/p2/{vendor}/{package_name}.json')
    return response.json()['packages'][f'{vendor}/{package_name}'][0]['source']['url']

