#!/bin/bash

current_dir=`pwd`
IMPORT_DIR="${current_dir}/src/import/Text/ImportTextToTextBasic"

#for j in `ls data/101*.txt`
for j in data/101-01-01-00002.txt
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
