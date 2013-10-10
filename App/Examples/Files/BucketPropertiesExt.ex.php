<?php
use \Riak\Property\ReplicationMode as RM;

$connection = new \Riak\Connection('localhost', 8087);
$bucket = new \Riak\Bucket($connection, 'bucket_props_ext');

// Create new bucket properties
$newProps = new \Riak\BucketPropertyList();
$newProps->setSearchEnabled(true)   // Enable riak search on bucket
    ->setR(1)                  // Set R value
    ->setNValue(1)             // Set N value
    ->setW(1)                  // Set W value
    ->setRW(1)                 // Set RW value
    ->setDW(1)                 // Set DW value
    ->setBigVClock(5000)       // Set big vclock
    ->setReplicationMode(new RM\FullSyncOnly()); // Set replication mode to fullsync only

// Create some post commit hooks we can set on the bucket
$postCommitHooks = new \Riak\Property\CommitHookList();
$postCommitHooks[] = new \Riak\Property\CommitHook('module', 'function');
$postCommitHooks[] = new \Riak\Property\CommitHook('js_function_name');
$newProps->setPostCommitHookList($postCommitHooks);

// Apply the properties
$bucket->setPropertyList($newProps);

// Properties are now applied on the bucket
