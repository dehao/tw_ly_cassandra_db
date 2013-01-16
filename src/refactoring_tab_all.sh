#!/bin/bash

current_dir=`pwd`
function visit_dir {
  for j in `ls`
  do
    local the_file=${j}
    if [ "${j}" == "api-core" ]
    then
      continue
    fi

    if [ "${j}" == "api" ]
    then
      continue
    fi

    if [ "${j}" == "admin" ]
    then
      continue
    fi

    if [ -d ${j} ]
    then
      cd ${j}
      visit_dir
      cd ..
    else
      k=`echo "${j}"|sed 's/.*php$/php/g'`
      if [ "${k}" != "php" ]
      then
        continue;
      fi

      echo "the_file: ${the_file}"

      /Applications/Emacs.app/Contents/MacOS/Emacs -l ~/.emacs --batch ${the_file} --eval "(progn (indent-region (point-min) (point-max) nil) (save-buffer))"
      php ${current_dir}/refactoring_tab.php < ${the_file} > ${the_file}.tmp
      mv ${the_file}.tmp ${the_file}
    fi
  done
}

visit_dir
