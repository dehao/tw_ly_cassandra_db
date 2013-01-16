#!/bin/bash

source "../../dev/Generate.conf"

echo "#!/bin/bash"
echo ""

current_dir=`pwd`
for j in `ls */*/*`
do
	the_dir=`echo "<?php echo dirname(\"${j}\"); ?>"|php`
	the_filename=`echo "<?php echo basename(\"${j}\"); ?>"|php`
	echo "#####"
	echo "cd ${the_dir}"
	echo "bash ./${the_filename} ${HOST} ${KEYSPACE}"
	echo "cd ${current_dir}"
	echo ""
done
