<?php
$connection = new \Riak\Connection('localhost', 8087);
$bucket = new \Riak\Bucket($connection, "bucket_props");

// Create new bucket properties with n-value of 1 and no siblings allowed
$newProps = new \Riak\BucketPropertyList(1, false);
// Apply the properties
$bucket->setPropertyList($newProps);

// Read back current bucket properties
$currentProps = $bucket->getPropertyList();
if ($currentProps->getNValue() === 1 &&
    $currentProps->getAllowMult() === false) {
	echo "Got it right!";
}