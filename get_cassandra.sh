#!/bin/bash

current_dir=`pwd`
IMPORT_DIR="${current_dir}/src/import/Text/ImportTextToTextBasic"

for j in `ls 101*.txt`
do
    if [ -f "${j}.bak" ]
        then
        continue
    fi

    echo "${j}"


    cd ${IMPORT_DIR}

    filename="${current_dir}/${j}"

    /usr/local/bin/php ImportTextToTextBasicUI.php ${filename} ""
    cd ${current_dir}

    cp ${j} ${j}.bak
done