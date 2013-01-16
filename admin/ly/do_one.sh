#!/bin/bash

if [ "${BASH_ARGC}" != "1" ]
    then
    echo "usage: do_one [the_dir]"
    exit
fi

if [ "${NOSQLROOT_DIR}" == "" ]
    then
    source ../../dev/Generate.conf
fi

the_dir=${BASH_ARGV[0]}

base_filename=`echo "<?php echo basename(\"${the_dir}\"); ?>"|php`
echo "the_dir: ${the_dir} base_filename: ${base_filename}"

./drop_column_family.sh ${the_dir}/Set${base_filename}.sh

current_dir=`pwd`
cd ${the_dir}
for j in `ls`
do

    bash ${j} ${HOST} ${KEYSPACE}
done
cd ${current_dir}
