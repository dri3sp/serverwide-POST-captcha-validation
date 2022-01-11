#/bin/bash

rm -f /var/www/html/__captcha_validation/ip/*

touch /var/www/html/__captcha_validation/ip/2001:db8::1.dat
touch /var/www/html/__captcha_validation/ip/192.0.2.1.dat

