<?php

$connection = new \Riak\Connection('localhost', 8087);
$bucket = new \Riak\Bucket($connection, 'search_ex_bucket');

// Enable riak search on the search_ex_bucket bucket
// Note this requires riak 1.4 or above older versions this
// can only be done using commandline or curl
$bucketProperties = new \Riak\BucketPropertyList();
$bucketProperties->setSearchEnabled(true);
// Apply the search property
$bucket->setPropertyList($bucketProperties);

// Create some test data
$testDataArr[] = '{"name": "apple","price": 2.50, "tags": ["fruit"]}';
$testDataArr[] = '{"name": "potato","price": 1.50, "tags": ["veg", "something"]}';
$testDataArr[] = '{"name": "pineapple","price": 15, "tags": ["fruit"]}';
$testDataArr[] = '{"name": "cheese", "price": 45, "tags": ["cow", "dairy"]}';
$i = 0;
foreach ($testDataArr as $testData) {
    $i++;
    $obj = new \Riak\Object("id$i");
    $obj->setContentType("application/json");
    $obj->setContent($testData);
    $bucket->put($obj);
}

// Finally perform a search :o)

$search = new \Riak\Search\Search($connection);
$searchInput = new \Riak\Search\Input\ParameterBag();
// Search on the name field
$searchInput->setDefaultField('name');
// Now search in our search_ex_bucket after documents with the name apple
$searchResult = $search->search('search_ex_bucket', 'apple', $searchInput);
// Did we find something?

// Number of found documents:
echo 'Search found '.$searchResult->getNumFound().' with the name apple'.PHP_EOL;
$foundDocuments = $searchResult->getDocuments();
foreach ($foundDocuments as $document) {
    var_dump($document);
}


