<?php
try {
	$client = new RiakClient('localhost', 8087);
} catch (RiakConnectionException $ex) {
	echo "Connection failed: ". $ex->getMessage().PHP_EOL;
}