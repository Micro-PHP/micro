.DEFAULT_GOAL = help
.PHONY        : help

help:
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

venv: venv/touchfile

venv/touchfile: requirements.txt
	test -d venv || virtualenv venv
	. venv/bin/activate; pip install -Ur requirements.txt
	touch venv/touchfile

init:
	. venv/bin/activate; python ./scripts/init.py

release:
	. venv/bin/activate; python ./scripts/release.py $(RELEASE_NAME)

clean:
	rm -rf venv
	find -iname "*.pyc" -delete
