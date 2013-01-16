#!/usr/bin/python

import sys
import cql
import time
import re

#setup command-line args
if len(sys.argv) != 4:
  print "usage: " + sys.argv[0] + " host keyspace column_family"
  quit()

host = sys.argv[1]
keyspace = sys.argv[2]
column_family = sys.argv[3]

print sys.argv[0] + ":" + " host: " + host + " keyspace: " + keyspace + " column_family: " + column_family

#setup variables
#host = '192.168.0.62'
#port = '9160'
port = 9160

cmd = "DROP COLUMNFAMILY " + column_family + ";"

#exec
con = cql.connect(host, port, keyspace)
cursor = con.cursor()

is_end = False
for i in range(10):
  if is_end:
    break;
  try:
    result = cursor.execute(cmd)
    print sys.argv[0] + ":" + " result: " + str(result) + "\n"
    is_end = True
  except Exception as e: 
    print sys.argv[0] + ": ", e.args
    m = re.search('Schema versions disagree', e.args[0])
    if m is None:
      is_end = True
    else:
      time.sleep(i)

#result = cursor.execute(cmd)
#print sys.argv[0] + ":" + " result: " + str(result)

cursor.close()
con.close()

time.sleep(1)
