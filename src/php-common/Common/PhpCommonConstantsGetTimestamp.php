<?php
//time
$NoSQL['PRECISION_TIME_SEC'] = 10;
$NoSQL['PRECISION_TIME_USEC'] = 3;
$NoSQL['PRECISION_TIME'] = $NoSQL['PRECISION_TIME_SEC'] + $NoSQL['PRECISION_TIME_USEC'];
$NoSQL['FORMAT_TIME_SEC'] = '%0' . $NoSQL['PRECISION_TIME_SEC'] . 'd';

?>
