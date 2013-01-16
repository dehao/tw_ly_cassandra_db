#!/bin/bash

current_dir=`pwd`

CMD_REFACTORING_RELATIVE_DIR=${current_dir}/refactoring_relative_dir.sh

function visit_dir {
  for j in `ls`
  do
    local the_file=${j}
    if [ -d "${j}" ]
    then
      cd ${j}
      visit_dir
      cd ..
    fi

    k=`echo "${the_file}"|sed 's/.*\.php$/php/g'`
    if [ "${k}" != "php" ]
      then
      continue
    fi

    ${CMD_REFACTORING_RELATIVE_DIR} ${the_file} ${current_dir}
    
  done
}

visit_dir