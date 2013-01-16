#!/bin/bash

NOSQLROOT_DIR=/Volumes/chhsiao_movie_analysis/tw_ly_cassandra_db_doc

rm -rf ${NOSQLROOT_DIR}/doc/dynamic
mkdir -p ${NOSQLROOT_DIR}/doc/dynamic

doxygen Doxyfile-dynamic >& /dev/null&
#doxygen Doxyfile-api >& /dev/null&
