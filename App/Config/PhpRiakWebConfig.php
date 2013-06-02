<?php
 /******************************************************************************
 * Copyright (c) 02/06/13 Kaspar Bach Pedersen.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.eclipse.org/legal/epl-v10.html
 *
 * Contributors:
 *    Kaspar Bach Pedersen - initial API and implementation and/or initial 
 *                           documentation
 ******************************************************************************/

namespace App\Config;


use DI\Container;
use Phoriz\AppConfig;
use Phoriz\Constants;

class PhpRiakWebConfig extends AppConfig
{

    /**
     * @param Container $container
     */
    public function configureApplication(Container &$container)
    {
        $container->set('session.params', [
            // Session lifetime
            'lifetime_s'   => 60*60,
            // Minimum time between garbage collection
            'time_between_gc_s' => 60*60,
            // Where to store the sessions
            // Default is bad dont write to temp
            'store_path' => dirname(dirname(__FILE__)).DS.'Cache'.DS.'Sessions'
        ]);
        $container->set(Constants::$RUN_MODE_KEY, Constants::$RUN_MODE_0_DEV);
        $container->set(Constants::$TWIG_PARAMS_KEY, [
                'template.path' => dirname(dirname(__FILE__)).DS.'Views',
                'cache.path' => dirname(dirname(__FILE__)).DS.'Cache'.DS.'Twig'
            ]
        );
    }

    public function getBindersLocation()
    {
        return dirname(dirname(__FILE__)).DS.'Views';
    }

    public function getBindersNamespace()
    {
        return 'App\Views';
    }
}