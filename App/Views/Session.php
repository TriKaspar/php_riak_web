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

use \Phoriz\Annotations\Route;

/**
 * @Route("session/")
 * @Route("session")
 */
class Session extends Base {

    public function __construct()
    {
        parent::__construct('Session module', 2);
    }

    /**
     * @param array $context
     * @return string|null
     */
    public function onRender($context)
    {
        echo $this->renderTemplate('Session.twig', $context);
    }
}