.PHONY: dirs qa cs csf phpstan tests coverage-clover coverage-html

all:
	@awk 'BEGIN {FS = ":.*##"; printf "Usage:\n  make \033[36m<target>\033[0m\n\nTargets:\n"}'
	@grep -h -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-20s\033[0m %s\n", $$1, $$2}'

tmp:
	mkdir -p tmp

# QA

qa: cs phpstan ## Check code quality - coding style and static analysis

cs: tmp ## Check PHP files coding style
	vendor/bin/phpcs --cache=tmp/codesniffer.dat --standard=ruleset.xml --extensions=php --colors -nsp src tests

csf: tmp ## Fix PHP files coding style
	vendor/bin/phpcbf --cache=tmp/codesniffer.dat --standard=ruleset.xml --extensions=php --colors -nsp src tests

phpstan: tmp ## Analyse code with PHPStan
	vendor/bin/phpstan analyse -l max -c phpstan.neon src

# Tests

tests: tmp ## Run all tests
	vendor/bin/phpunit -c phpunit.xml

coverage-clover: tmp ## Generate code coverage in Clover XML format
	php -d pcov.enabled=1 -d pcov.directory=./src vendor/bin/phpunit -c phpunit.xml --coverage-clover tmp/coverage.xml

coverage-html: tmp ## Generate code coverage in HTML format
	php -d pcov.enabled=1 -d pcov.directory=./src vendor/bin/phpunit -c phpunit.xml --coverage-html tmp/coverage-html
