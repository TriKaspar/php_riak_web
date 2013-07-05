<?php
$connection = new \Riak\Connection('localhost', 8087);
$bucket = new \Riak\Bucket($connection, "index_bucket");

// Make sure we dont have siblings enabled
$props = new \Riak\BucketPropertyList(3, false);
$bucket->setPropertyList($props);

try {
	// Create 10 objects with indexes
    for ($i=0; $i<10; $i++) {
        $obj = new \Riak\Object("obj$i");
        $obj->setContent('dummy data');
        // Set a integer index num_int and a binary index text_bin
        // remember secondary index should always end on _int or _bin
        $obj->addIndex('num_int', $i);
        $obj->addIndex('text_bin', "text$i");
        // Store object
        $bucket->put($obj);
    }

    // Query for all objects where num_int = 1
    $result = $bucket->index("num_int", 1);
    // Result should is an array of keys, in this case obj1 should be the only entry
    echo "First query returned key: ".$result[0].PHP_EOL;

    // Now make a ranged query on the text_bin index
    $result = $bucket->index("text_bin", "text4", "text6");
    // This query will match objects which index is text4, text5 and text6
    echo "Second query returned: ";
    print_r($result);
    echo PHP_EOL;
} catch (\Riak\Exception\RiakException $e) {
    var_dump($e);
}
