<?php
$client = new RiakClient('localhost', 8087);
$bucket = new RiakBucket($client, "index_bucket");

// Make sure we dont have siblings enabled
$props = new RiakBucketProperties(3, false);
$bucket->applyProperties($props);

try {
	// Create 10 objects with indexes
    for ($i=0; $i<10; $i++) {
        $obj = new RiakObject("obj$i");
        $obj->data = 'dummy data';
        // Set a integer index num_int and a binary index text_bin
        // remember secondary index should always end on _int or _bin
        $obj->indexes = array('num_int' => $i, 'text_bin' => "text$i");
        // Store object
        $bucket->putObject($obj);
    }

    // Query for all objects where num_int = 1
    $result = $bucket->indexQuery("num_int", 1);
    // Result should is an array of keys, in this case obj1 should be the only entry
    echo "First query returned key: ".$result[0].PHP_EOL;

    // Now make a ranged query on the text_bin index
    $result = $bucket->indexQuery("text_bin", "text4", "text6");
    // This query will match objects which index is text4, text5 and text6
    echo "Second query returned: ";
    print_r($result);
    echo PHP_EOL;
} catch (RiakException $e) {
    var_dump($e);
}
