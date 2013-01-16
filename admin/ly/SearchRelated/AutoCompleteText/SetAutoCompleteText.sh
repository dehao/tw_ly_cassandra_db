#!/bin/bash

source ../../../../dev/Generate.conf

PATH="${NOSQLROOT_DIR}/src/admin:${PATH}"
if [ "${BASH_ARGC}" != "2" ]
    then
    echo "usage: ${BASH_SOURCE} host keyspace"
    exit 0
fi
host=${BASH_ARGV[1]}
keyspace=${BASH_ARGV[0]}
host_keyspace="${host} ${keyspace}"
echo "${BASH_SOURCE}: host_keyspace: ${host_keyspace}"
#DropColumnFamily.py ${host_keyspace} auto_complete_text
CreateColumnFamily.py ${host_keyspace} auto_complete_text
