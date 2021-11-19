test-stan:
	./vendor/bin/phpstan
test-unit:
	./vendor/bin/phpunit tests

test-unit-coverage:
	export XDEBUG_MODE=coverage && ./vendor/bin/phpunit --coverage-html reports tests

test: test-stan test-unit
