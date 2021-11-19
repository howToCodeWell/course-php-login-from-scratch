test-stan:
	./vendor/bin/phpstan
test-unit:
	./vendor/bin/phpunit tests

test-unit-coverage:
	export XDEBUG_MODE=coverage && ./vendor/bin/phpunit --coverage-html reports tests

test-lint:
	./vendor/bin/phpcs --standard=coding_standard.xml common.php tests public config

clean:
	./vendor/bin/phpcbf --standard=coding_standard.xml common.php tests public config

test: test-lint test-stan test-unit
