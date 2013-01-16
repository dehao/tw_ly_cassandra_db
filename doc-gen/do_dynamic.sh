#!/bin/bash

source ../dev/Generate.conf

rm -rf ${NOSQLROOT_DIR}/doc/dynamic
mkdir -p ${NOSQLROOT_DIR}/doc/dynamic

doxygen Doxyfile-dynamic >& /dev/null&
#doxygen Doxyfile-api >& /dev/null&
