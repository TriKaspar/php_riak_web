<?php
try {
  $client = new RiakClient('localhost', 8087);
  $bucket = new RiakBucket($client, 'test_bucket');
  $obj = new RiakObject("key");
  $obj->contentType = "text/plain";
  $obj->data = "Value that will get written";
  $bucket->putObject($obj);
} catch (RiakException $e) {
  echo $e->getMessage();
}