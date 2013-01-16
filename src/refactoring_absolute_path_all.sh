#!/bin/bash

PATH="${PATH}:/bin:/usr/local/bin"

current_dir=`pwd`
function visit_dir {
    for j in `ls`
    do
        local the_file="${j}"
        if [ -d "${j}" ]
            then
            cd "${j}"
            visit_dir
            cd ..
        else
            k=`echo "${the_file}"|sed 's/.*\.php$/php/g'`
            if [ "${k}" != "php" ]
                then
                continue
            fi

            the_dir=`pwd`
            the_filename="${the_dir}/${the_file}"
            cd "${current_dir}"
            ./refactoring_absolute_path.sh ${the_filename}&
            cd ${the_dir}
        fi
    done
}

visit_dir