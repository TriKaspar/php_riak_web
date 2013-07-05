<?php

$connection = new \Riak\Connection('localhost', 8087);
$bucket = new \Riak\Bucket($connection, 'siblings');

// Make sure we have siblings enabled
$newProps = new \Riak\BucketPropertyList(3, true);
$bucket->setPropertyList($newProps);

// Create an object with some data
$obj = new \Riak\Object('conflicting');
$obj->setContent('some data');
$bucket->put($obj);

// Now create a new object on same key, without reading the value first
$obj = new \Riak\Object('conflicting');
$obj->setContent('some other data');
$bucket->put($obj);
// Now Riak has created a sibling since we have written 2 different values
// to the same key.
try {
    // We now get the object
    $response = $bucket->get('conflicting');
    if ($response->hasSiblings()) {
        echo "We have conflicting writes".PHP_EOL;

        // We should resolve the conflict by merging the siblings
        $objects = $response->getObjectList();
        $response->getVClock();
        $mergedContent = "";
        foreach ($objects as $object) {
            // Simple resolve by appending all content together
            $mergedContent .= '-'.$object->getContent();
        }
        // Create a new object that will hold our merged content
        $mergedObject = new \Riak\Object('conflicting');
        $mergedObject->setContent($mergedContent);

        // Create a PutInput.
        $putInput = new \Riak\Input\PutInput();
        // By setting the vclock to the one we got from the get() operation
        // riak will know that we resolved the conflict.
        $putInput->setVClock($response->getVClock());
        // We now pass the PutInput to the put function.
        $bucket->put($mergedObject, $putInput);
    }
} catch (\Riak\Exception\RiakException $ex) {
    echo $ex->getMessage().PHP_EOL;
}

$response = $bucket->get('conflicting');
if ($response->hasObject() && !$response->hasSiblings()) {
    echo "Conflict resolved!".PHP_EOL;
    $obj = $response->getFirstObject();
    echo "Merged object data: " . $obj->getContent() . PHP_EOL;
}
