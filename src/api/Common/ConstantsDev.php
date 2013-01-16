<?php
use cassandra\ConsistencyLevel;
$NoSQL['SERVERS'] = array("localhost:9160");
$NoSQL['KEYSPACE_NAME'] = "ly";
$NoSQL['READ_CONSISTENCY_LEVEL'] = ConsistencyLevel::ONE;
$NoSQL['WRITE_CONSISTENCY_LEVEL'] = ConsistencyLevel::ONE;
?>
