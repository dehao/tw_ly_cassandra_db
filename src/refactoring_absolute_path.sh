#!/bin/bash

filename=${BASH_ARGV[0]}

php refactoring_absolute_path.php ${filename} > ${filename}.tmp
mv ${filename}.tmp ${filename}
