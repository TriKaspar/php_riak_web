<?php
try {
    $connection = new \Riak\Connection('localhost', 8087);

    // Create a new bucket
    $bucket = new \Riak\Bucket($connection, 'bucket_name');

    // Create a new object
    $obj = new \Riak\Object('object_name');
    // Set the object data that will be saved to Riak
    $obj->setContent("test-get plap");
    // Store the object in the bucket
    $bucket->put($obj);

    // Read back the object from Riak
    $response = $bucket->get('object_name');
    // Make sure we got an object back
    if ($response->hasObject()) {
        // Get the first returned object
        $readdenObject = $response->getFirstObject();
        echo "Object content: ".$readdenObject->getContent();
    }
} catch (\Riak\Exception\RiakException $e) {
    echo 'Something riak related failed: '. $ex->getMessage().PHP_EOL;
}
