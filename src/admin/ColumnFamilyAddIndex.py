#!/usr/bin/python

import sys
import cql
import time

#setup command-line args
len_sys_argv = len(sys.argv)
if len_sys_argv != 6:
  print "usage: " + sys.argv[0] + " host keyspace column_family column_name index_desc"
  quit()

host = sys.argv[1]
keyspace = sys.argv[2]
column_family = sys.argv[3]
column_name = sys.argv[4]
index_desc = sys.argv[5]

print sys.argv[0] + ":" + " host: " + host + " keyspace: " + keyspace + " column_family: " + column_family + " column_name: " + column_name + " index_desc: " + index_desc

#setup variables
#port = '9160'
port = 9160

cmd = "CREATE INDEX " + index_desc + " ON " + column_family + " ( " + column_name + " );"

#exec
con = cql.connect(host, port, keyspace)
cursor = con.cursor()

result = cursor.execute(cmd)
print sys.argv[0] + ":" + " result: " + str(result)

cursor.close()
con.close()

time.sleep(2)
