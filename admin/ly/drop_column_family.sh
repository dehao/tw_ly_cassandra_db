#!/bin/bash

source ../../dev/Generate.conf

PATH="${NOSQLROOT_DIR}/src/admin:${PATH}"
if [ "${BASH_ARGC}" != "1" ]
    then
    echo "usage: ${BASH_SOURCE} [filename]"
    exit 0
fi

filename=${BASH_ARGV[0]}
host_keyspace="${HOST} ${KEYSPACE}"
echo "${BASH_SOURCE}: host_keyspace: ${host_keyspace}"

column_family=`grep "^CreateColumnFamily" ${filename}|sed 's/.* //g'`
echo "column_family: ${column_family}"
DropColumnFamily.py ${host_keyspace} ${column_family}
