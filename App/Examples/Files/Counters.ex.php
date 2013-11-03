<?php

$connection = new \Riak\Connection('localhost', 8087);
$bucket = new \Riak\Bucket($connection, 'counter_ex_bucket');

// Enable allow mult on the counter_ex_bucket bucket
$bucketProperties = new \Riak\BucketPropertyList();
$bucketProperties->setAllowMult(true);
$bucket->setPropertyList($bucketProperties);

// Counter can be constructed in two ways
// With new:
$counter1 = new \Riak\CRDT\Counter($bucket, "counter1");
// Or with Riak\Bucket's counter function
$counter2 = $bucket->counter("counter2");

// All counters start at 0
// All changes to the counter value is done using increment like this
$counter1->increment(10);
// Use negative values to decrement
$counter2->increment(-10);

// Increment can also return the updated value
echo "Counter1 value: ".$counter1->incrementAndGet(10).PHP_EOL;

// The Riak\Bucket->counter function can save some typing
// the counter function will always return a counter object or throw exception
$c2val = $bucket->counter("counter2")->get();
echo "Counter2 value: ".$c2val.PHP_EOL;
