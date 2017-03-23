#!/bin/bash

function message()
{
	case "$2" in
	    ("red") echo "\033[1m\033[31m$1\033[0m\033[0m\n" ;;
		("green") echo "\033[1m\033[32m$1\033[0m\033[0m\n" ;;
		("yellow") echo "\033[1m\033[33m$1\033[0m\033[0m\n" ;;
		("blue") echo "\033[1m\033[34m$1\033[0m\033[0m\n" ;;
		(*) echo "$1" ;;
	esac
}

cd ../public

if ! type "composer" > /dev/null; then
 	message "Installing Composer..." "yellow"
 	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
 	php -r "if (hash_file('SHA384', 'composer-setup.php') === '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
 	php composer-setup.php --install-dir=/usr/local/bin
 	php -r "unlink('composer-setup.php');"
fi

composer install

cd ../

if [ -d "./cache" ]; then
	rm -rf cache
fi

mkdir "cache"