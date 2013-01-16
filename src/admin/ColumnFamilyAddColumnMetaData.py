#!/usr/bin/python

import sys
import cql

#setup command-line args
len_sys_argv = len(sys.argv)
if len_sys_argv != 5 and len_sys_argv != 6:
  print "usage: " + sys.argv[0] + " host keyspace column_family column_name [column_type]";
  quit()

host = sys.argv[1]
keyspace = sys.argv[2]
column_family = sys.argv[3]
column_name = sys.argv[4]
if len_sys_argv == 5:
  column_type = "text"
else:
  column_type = sys.argv[5]

print sys.argv[0] + ":" + " host: " + host + " keyspace: " + keyspace + " column_family: " + column_family + " column_name: " + column_name + " type: " + column_type

#setup variables
#port = '9160'
port = 9160

cmd = "ALTER COLUMNFAMILY " + column_family + " ADD " + column_name + " " + column_type + ";"

#exec
con = cql.connect(host, port, keyspace)
cursor = con.cursor()

result = cursor.execute(cmd)
print sys.argv[0] + ":" + " exec result: " + str(result)

cursor.close()
con.close()

