#!/bin/bash

current_dir=`pwd`
IMPORT_DIR="${current_dir}/src/import/Text/ImportTextBySpeakerToTextBasic"

for j in `ls data/101*.txt`
do
    if [ -f "${j}.by_speaker.bak" ]
        then
        continue
    fi

    echo "${j}"


    cd ${IMPORT_DIR}

    filename="${current_dir}/${j}"

    /usr/local/bin/php ImportTextBySpeakerToTextBasicUI.php ${filename} ""
    cd ${current_dir}

    touch ${j}.by_speaker.bak
done
