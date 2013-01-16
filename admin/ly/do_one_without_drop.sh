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

current_dir=`pwd`
cd ${the_dir}
for j in `ls`
do
    bash ${j} ${HOST} ${KEYSPACE}
done
cd ${current_dir}
