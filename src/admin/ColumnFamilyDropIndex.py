#!/usr/bin/python

import sys
import cql

#setup command-line args
len_sys_argv = len(sys.argv)
if len_sys_argv != 4:
  print "usage: " + sys.argv[0] + " host keyspace index_desc"
  quit()

host = sys.argv[1]
keyspace = sys.argv[2]
index_desc = sys.argv[3]

print sys.argv[0] + ":" + " host: " + host + " keyspace: " + keyspace + " index_desc: " + index_desc

#setup variables
port = '9160'

cmd = "DROP INDEX " + index_desc + ";"

#exec
con = cql.connect(host, port, keyspace)
cursor = con.cursor()

result = cursor.execute(cmd)
print sys.argv[0] + ":" + " result: " + str(result)

cursor.close()
con.close()

