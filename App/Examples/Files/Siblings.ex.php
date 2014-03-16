<?php
// Make sure allowMult = true on your bucket
// Create a conflict resolver
class SimpleMergeResolver implements \Riak\Output\ConflictResolver
{

    /**
     * Resolve or merge the conflicting objects and return one that should be store back into riak.
     * @param \Riak\ObjectList $objects
     * @return Object|null
     */
    public function resolve(\Riak\ObjectList $objects)
    {
        $result = null;
        $mergedContent = "";
        foreach ($objects as $object) {
            if (!$object->isDeleted()) {
                if (is_null($result)) {
// We just take the first object that is not deleted and use as base for our result
// that way we don't need to create a new object and copy the vclock, metadata and indexes etc.
                    $result = $object;
                }
                $mergedContent .= '-'.$object->getContent();
            }
        }
// If we actually found a result, set the content to the merged value.
        if (isset($result)) {
            $result->setContent($mergedContent);
        }
        return $result;
    }
}
$connection = new \Riak\Connection('localhost', 8087);
$bucket = new \Riak\Bucket($connection, 'siblings');
// Set our resolver on the bucket, to have it invoked automatically on conflicts
$bucket->setConflictResolver(new SimpleMergeResolver());

// Create an object with some data
$obj = new \Riak\Object('conflicting');
$obj->setContent('some data');
$bucket->put($obj);
// Now create a new object on same key, without reading the value first
$obj = new \Riak\Object('conflicting');
$obj->setContent('some other data');
$bucket->put($obj);


$getOutput = $bucket->get('conflicting');
// To make sure the resolver is called you should use the getObject on the output
$resolvedObject = $getOutput->getObject();
// Save back the object
$bucket->put($resolvedObject);

// Read back and ensure the sibling is now gone.
$getOutput = $bucket->get('conflicting');
echo var_export($getOutput->hasSiblings(), true) . PHP_EOL;
echo var_export($getOutput->getObject()->getContent(), true) . PHP_EOL;