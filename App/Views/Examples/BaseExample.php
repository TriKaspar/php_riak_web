<?php
 /******************************************************************************
 * Copyright (c) 08/06/13 Kaspar Bach Pedersen.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.eclipse.org/legal/epl-v10.html
 *
 * Contributors:
 *    Kaspar Bach Pedersen - initial API and implementation and/or initial 
 *                           documentation
 ******************************************************************************/

namespace App\Views\Examples;

use App\Operations\GetExampleMenu;
use App\Views\Base;

abstract class BaseExample extends Base
{
    /**
     * @param \Phoriz\Routing\Method $method
     * @return mixed
     */
    public function onRequest($method)
    {
        parent::onRequest($method);
        $this->operationQueue->addOperation(new GetExampleMenu());
    }

    /**
     * @param array $context
     * @return string|null

    public function onRender($context)
    {
    }*/
}
