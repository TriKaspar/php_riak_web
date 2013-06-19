<?php
try {
    $client = new RiakClient('localhost', 8087);

    // Create a new bucket
    $bucket = new RiakBucket($client, 'bucket_name');

    // Create a new object
    $obj = new RiakObject('object_name');
    // Set the object data that will be saved to Riak
    $obj->data = "test-get plap";
    // Store the object in the bucket
    $bucket->put($obj);

    // Read back the object from Riak
    $readdenObj = $bucket->get('object_name');

} catch (RiakException $e) {
    echo 'Something riak related failed: '. $ex->getMessage().PHP_EOL;
}
