#!/bin/bash

if [ "${BASH_ARGC}" != "2" ]
then
  echo "usage: refactoring_relative_dir.sh [the_file] [current_dir]"
  exit
fi

the_file=${BASH_ARGV[1]}
current_dir=${BASH_ARGV[0]}

dir_ary=( php-common api api-core )

cp ${the_file} ${the_file}.tmp

for each_dir in ${dir_ary[@]}
do
  echo "each_dir: ${each_dir}"
  the_dir=${current_dir}/${each_dir}
  the_dir_regex=`echo "${the_dir}/"|sed 's/\//\\\\\//g'`
  echo "the_file: ${the_file} the_dir: ${the_dir} the_dir_regex: ${the_dir_regex}"

  sed "s/${the_dir_regex}//g" ${the_file}.tmp > ${the_file}.tmp2
  mv ${the_file}.tmp2 ${the_file}.tmp
done

mv ${the_file}.tmp ${the_file}