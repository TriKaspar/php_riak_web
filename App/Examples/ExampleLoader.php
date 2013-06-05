<?php
 /******************************************************************************
 * Copyright (c) 05/06/13 Kaspar Bach Pedersen.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.eclipse.org/legal/epl-v10.html
 *
 * Contributors:
 *    Kaspar Bach Pedersen - initial API and implementation and/or initial 
 *                           documentation
 ******************************************************************************/
namespace App\Examples;

class ExampleLoader extends \Twig_Extension {

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return "example_loader";
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('example', function($name) {
                $path = dirname(__FILE__).DS.'Files'.DS.$name;
                return file_get_contents($path);
            })
        );
    }
}