default:
	@echo 'Targets:'
	@echo '  view-docs  -- View generated documentation'
	@echo '  gen-docs   -- Generate API documentation'
	@echo '  get-slim   -- Get SLIM dependencies'

view-docs: gen-docs
	firefox public/apidoc/index.html

gen-docs:
	apidoc -i public/ -o public/apidoc/

get-slim:
	composer require slim/slim:"4.*"
	composer require slim/psr7
	-rm -rf public/vendor/
	mv vendor/ public/vendor/
	-rm -f composer.json
	-rm -f composer.lock

