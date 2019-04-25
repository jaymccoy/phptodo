#!/usr/bin/env bash

docker build -t <image_tag> . && docker run -p 80:80 -v /Users/jeroenbouman/Documents/php/phptodo:/var/www/html --name apache72 latest