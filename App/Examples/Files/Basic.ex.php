<?php
try {
	$connection = new \Riak\Connection('localhost', 8087);
} catch (\Riak\Exception\ConnectionException $ex) {
	echo 'Connection failed: '. $ex->getMessage().PHP_EOL;
}
