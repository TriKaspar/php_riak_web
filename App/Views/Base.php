<?php
/******************************************************************************
 * Copyright (c) 03/06/13 Kaspar Bach Pedersen.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.eclipse.org/legal/epl-v10.html
 *
 * Contributors:
 *    Kaspar Bach Pedersen - initial API and implementation and/or initial
 *                           documentation
 ******************************************************************************/

namespace App\Views;


use App\Operations\GetTopMenu;
use Phoriz\ViewBinding\TwigViewBinder;
use Phoriz\ViewBinding\ViewBinder;

abstract class Base extends ViewBinder {
    use TwigViewBinder;

    /**
     * @param \Phoriz\Routing\Method $method
     * @return mixed
     */
    public function onRequest($method)
    {
        $this->operationQueue->addOperation(new GetTopMenu());
    }

    /**
     * @param array $context
     * @return string|null
     */
    public function onRender($context)
    {
    }
}