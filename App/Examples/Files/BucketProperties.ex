<?php
$client = new RiakClient('localhost', 8087);
$bucket = new RiakBucket($client, "bucket_props");

// Create new bucket properties with n-value of 1 and no siblings allowed
$newProps = new RiakBucketProperties(1, false);
// Apply the properties
$bucket->applyProperties($newProps);

// Read back current bucket properties
$currentProps = $bucket->fetchProperties();
if ($currentProps->nVal === 1 && $currentProps->allowMult === false) {
	echo "Got it right!";
}