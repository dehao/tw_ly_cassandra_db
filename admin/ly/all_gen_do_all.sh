#!/bin/bash

./gen_do_all.sh > do_all_admin.sh

sed 's/^/#/g' do_all_admin.sh > simple_do_all2_admin.sh
chmod 755 *.sh
