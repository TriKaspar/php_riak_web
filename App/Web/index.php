<?php
/******************************************************************************
 * Copyright (c) 05/01/13 Kaspar Bach Pedersen.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.eclipse.org/legal/epl-v10.html
 *
 * Contributors:
 *    Kaspar Bach Pedersen - initial API and implementation and/or initial
 *                           documentation
 ******************************************************************************/

require dirname(__FILE__).DIRECTORY_SEPARATOR."bootstrap.php";

$container = \DI\ContainerSingleton::getInstance();
$container->set('Phoriz\AppConfig')
    ->bindTo('App\Config\PhpRiakWebConfig');

/** @var $app \Phoriz\App */
$app = $container->get('\Phoriz\App');
/** @var $router \Phoriz\Routing\RouterCore */
$router = $container->get('\Phoriz\Routing\RouterCore');
return $router->handleRequest($app);
