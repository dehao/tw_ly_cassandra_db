tw_ly_cassandra_db
==================

## Quick Start:

1. git submodule update --init --recursive

2. Download the latest version of cassandra 1.1 or 1.2. (http://cassandra.apache.org)
3. Configure the basic setting of cassandra, and initiate cassandra (It should be ok to directly use the default setting from cassandra.)
4. init a keyspace called ly in cassandra.

5. cd dev. cp Generate.conf.template Generate.conf. Modify corresponding parameters in Generate.conf

6. cd admin/ly
7. ./all_gen_do_all.sh
8. ./do_all_admin.sh

9. get sample doc from http://lci.ly.gov.tw/LyLCEW/communique1/work/101/74/LCIDC01_1017401_00002.doc as 101-74-01-00002.doc
10. use ./get_txt.sh to generate .txt file

11. use ./get_cassandra.sh to put the data into cassandra. (takes about 30 mins (11-gram Chinese characters))

12. php GetSearchText.php "院會" "" and you will get some debug info.

["0101-0074-0001-0002-0685","101-74-01-00002.txt","0000685",""] => ["0101-0074-0001-0002-0685_101-74-01-00002.txt_0000685_","","","0101-0074-0001-0002-0685","101-74-01-00002.txt","0000685","",""]

means "院會" appears at row 686 (0 as row 1) in the file "101-74-01-00002.txt".

13. cd doc-gen. ./do_dynamic_all.sh to gen sdk docs by doxygen


