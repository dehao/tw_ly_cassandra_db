#!/bin/bash

##########
# 把 conf 裡的 vars load 進來 (執行 conf)
##########

source "Generate.conf"

##########
# 處理每個 file
##########

function ProcessFile {
	in_file=$1
	out_dir=$2
	out_file=$3

	echo "[INFO] ProcessFile: in_file: ${in_file} out_dir: ${out_dir} out_file: ${out_file}"
	mkdir -p ${out_dir}
	sed "s/\[HOME_DIR\]/${NOSQLROOT_DIR_REGEX}/g" ${in_file} > temp.HOME_DIR
	sed "s/\[HOME_HTTP\]/${HOME_HTTP_REGEX}/g" temp.HOME_DIR > temp.HOME_HTTP
	sed "s/\[SERVERS\]/${SERVERS}/g" temp.HOME_HTTP > temp.SERVERS
	sed "s/\[KEYSPACE_NAME\]/${KEYSPACE_NAME}/g" temp.SERVERS > temp.KEYSPACE_NAME
	sed "s/\[READ_CONSISTENCY_LEVEL\]/${READ_CONSISTENCY_LEVEL}/g" temp.KEYSPACE_NAME > temp.READ_CONSISTENCY_LEVEL
	sed "s/\[WRITE_CONSISTENCY_LEVEL\]/${WRITE_CONSISTENCY_LEVEL}/g" temp.READ_CONSISTENCY_LEVEL > temp.WRITE_CONSISTENCY_LEVEL
	sed "s/\[LOG_DIR\]/${LOG_DIR_REGEX}/g" temp.WRITE_CONSISTENCY_LEVEL > temp.LOG_DIR
	cp temp.LOG_DIR ${out_file}
}

##########
# api/Constants.php
##########

out_dir=${NOSQLROOT_DIR}/src/api/Common
out_file=${out_dir}/ConstantsDev.php
ProcessFile ${NOSQLROOT_DIR}/template/api/template.Constants.php ${out_dir} ${out_file}

##########
# php-common/PhpCommonConstants.php
##########

out_dir=${NOSQLROOT_DIR}/src/php-common/Common
out_file=${out_dir}/PhpCommonConstants2.php
ProcessFile ${NOSQLROOT_DIR}/template/php-common/template.PhpCommonConstants.php ${out_dir} ${out_file}
