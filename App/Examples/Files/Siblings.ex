<?php

$client = new RiakClient('localhost', 8087);
$bucket = new RiakBucket($client, 'siblings');

// Make sure we have siblings enabled
$newProps = new RiakBucketProperties(3, true);
$bucket->applyProperties($newProps);

// Create an object with some data
$obj = new RiakObject('key');
$obj->data = 'some data';
$bucket->putObject($obj);

// Now create a new object on same key, without reading the value first
$obj = new RiakObject('key');
$obj->data = 'some other data';
$bucket->putObject($obj);

// Now Riak has created a sibling since we have written 2 different values
// to the same key.
try {
    // We now try to get the object, this will trigger an
    // RiakConflictedObjectException
    $obj = $bucket->getObject('key');
} catch (RiakConflictedObjectException $ex) {
    // We should resolve the conflict by merging the siblings

    // Take the first object, and the vclock
    $obj = $ex->objects[0];
    // Remember the vclock so we don't create a new sibling
    $obj->vclock = $ex->vclock;

    // Merge all objects data
    $data = "";
    foreach ($ex->objects as $sibling) {
        // We just add their data together
        $data .= '-'.$sibling->data;
    }
    $obj->data = $data;

    // Store the object, since we used the newest vclock the conflict
    // should be resolved.
    $bucket->putObject($obj);

    // The object could be conflicted state once more if another request has
    // modified it in between the read and put above.
    // But in this example we know no one else is writing to it.
}

$obj = $bucket->getObject('key');
echo "Merged object data: " . $obj->data . PHP_EOL;
