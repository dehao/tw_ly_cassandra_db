development structure
=====================

#### admin: shell scripts to create column families. 
#### casssandra: schema definition of column families.
#### dev: specific configuration of each machine.

#### src: main source files
##### src/php-common: common-used php functions/libs. 
##### src/api-core: common entry functions of all column families. 
##### src/api: specific functions for each column family.
##### src/import : common entry functions of all importing processes.
##### src/import-private: specific functions for each importing process.
##### src/admin: python functions to access cassandra (using cql)

#### template: template for dev.