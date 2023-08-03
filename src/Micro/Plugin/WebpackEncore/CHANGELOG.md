# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## Added

- Explicit dependency on TwigPlugin, from now on it will be loaded automatically by `micro/kernel-boot-plugin-depended` package;
- Added documentation for twig functions in php annotations;

## Changed

- Dropped support for php 8.1;

## [1.1] - 2022-12-20

### Updated

- Renamed vendor name;
- Updated README.md;
- Minor refactor;

## [1.0] - 2022-12-14

### Updated
- Updated dependencies;
- Updated README.md;

## [0.1] - 2022-12-14

### Added
- Plugin created;
- Created five twig functions:
  - encore_entry_js_files - returns script files;
  - encore_entry_css_files - returns link files;
  - encore_entry_script_tags - renders script tags to a template;
  - encore_entry_link_tags - renders link tags to a template;
  - encore_entry_exists - checks if such entry exists;
