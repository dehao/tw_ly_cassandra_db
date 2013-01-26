tw_ly_cassandra_db
==================

## Purpose

這個系統希望能夠提供關於臺灣立法院的議事記錄的簡單而且 extensible 的 query system.

透過這個系統. 希望能夠知道以下資訊:
1. 我們可以 query 哪些文字.
2. 對於每個文字. 知道總共出現多少次.
3. 對於每個文字. 知道在哪些公報的哪些地方出現.

有著這些資訊. 將可以對所有文字做跨時間的統計. 
透過計算 tf-idf. 或是其他的 index.
希望能夠知道立法院(或是每個委員)在不同的時間所關心的不同議題.

這些資訊可能可以透過 grep 得知.
這個系統是希望能夠快速提供 grep 完的結果. 讓大家不用每次在 access 這些資訊時. 都需要花時間重新 grep.

目前的官方 query 系統 (http://lci.ly.gov.tw)
有著以下的限制:
1. 最多只能查到 300 筆.
2. context 只有很短的幾句.
3. 似乎沒有容易的方式可以提供給大家做更進一步的使用 (分析或是統計或是其他用途).

Cassandra 是個 distributed DB system.
建立 DB 方式可以是讓大家各自花 15 min - 20 min 對於某一個 doc 建立那部分的 db 
(每份 doc 大約會是 300-400 M 的 db). 然後丟到 dropbox 上.
然後運作時把所有的 db 抓下來 sync. 

這個系統的目的是希望能夠提供 DB 的 data.
除了讓大家各自 build up 運作以外.
在找到適當的運作方式以後. 將會提供 unified DB 讓大家容易 access 完整的 DB.

## Quick Start:

1. git submodule update --init --recursive

2. Download the latest version of cassandra 1.1 or 1.2. (http://cassandra.apache.org)
3. Configure the basic setting of cassandra, and initiate cassandra (It should be ok to directly use the default setting from cassandra.)
4. cassandra-cli -f init_ly.txt

5. cd dev. cp Generate.conf.template Generate.conf. Modify corresponding parameters in Generate.conf

6. cd admin/ly
7. ./all_gen_do_all.sh
8. ./do_all_admin.sh

9. get sample doc from http://lci.ly.gov.tw/LyLCEW/communique1/work/101/01/LCIDC01_1010101_00002.doc as data/101-01-01-00002.doc
10. use ./get_txt.sh to generate .txt file (or your own method to generate data/101-01-01-00002.txt)

11. use ./get_cassandra.sh to put the data into cassandra. (takes about 2 mins (11-gram Chinese characters), around 300 M)

12. php GetSearchText.php "院會" "" and you will get the count and the corresponding file/line/context

    [101-01-01-00002.txt_00518] => Array
        (

            [0] => 農田水利會經費之保管、運用、財產處分及其他財務處理之辦法，由主管機關定之。

            [1] => 主席：請問院會，對第三十四條有無異議？（有）既有異議，交付表決。

            [2] => 現在進行表決。贊成第三十四條照審查條文通過者請按「贊成」，反對者請按「反對」，棄權者請按「棄權」，計時1分鐘，現在進行記名表決。
        )

means "院會" appears at row 519 (0 as row 1) in the file "101-01-01-00002.txt".

13. cd doc-gen. ./do_dynamic_all.sh to gen sdk docs by doxygen

## To get sample output:

#### sample.GetSearchIndex.txt
php GetSearchIndex.php "" ""

#### sample.GetSearchIndex.by_speaker.txt
php GetSearchIndex.php "" "主席"

#### sample.GetSearchText.txt
php GetSearchIndex.php "乩" ""

#### sample.GetSearchText.by_speaker.txt
php GetSearchIndex.php "馬" "主席"
