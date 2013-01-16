#!/bin/bash

for j in `ls|grep "\.doc"`
do
    k=`echo "${j}"|sed 's/doc/txt/g'`
    echo "${j} -> ${k}"
    if [ -f "${k}" ]
        then
        continue
    fi

    echo "python /usr/local/bin/unoconv -f txt ${j}"
    /usr/bin/python /usr/local/bin/unoconv -f txt ${j}
done
