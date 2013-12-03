#!/bin/sh
echo "Open your browser and go to \033[1;32mhttp://localhost:4000\033[0;39m"
cd `dirname $BASH_SOURCE`
LANG=en_US.UTF-8 LC_ALL=en_US.UTF-8 jekyll serve --watch --drafts