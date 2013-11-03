<?php
/*
   Copyright 2013: Kaspar Bach Pedersen

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

     http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.
*/
namespace App\Views\Examples;

use \Phoriz\Annotations\Route;

/**
 * @Route("examples/counters")
 * @Route("examples/counters/")
 */
class Counters extends BaseExample
{
    public function __construct()
    {
        parent::__construct('Counters', 6);
    }

    /**
     * @param array $context
     * @return string|null
     */
    public function onRender($context)
    {
        echo $this->renderTemplate('Examples/Counters.twig', $context);
    }
}