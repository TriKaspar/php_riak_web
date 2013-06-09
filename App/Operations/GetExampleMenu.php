<?php
 /******************************************************************************
 * Copyright (c) 07/06/13 Kaspar Bach Pedersen.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.eclipse.org/legal/epl-v10.html
 *
 * Contributors:
 *    Kaspar Bach Pedersen - initial API and implementation and/or initial 
 *                           documentation
 ******************************************************************************/

namespace App\Operations;


use Phoriz\Operation\Operation;
use Phoriz\SiteMap\MenuItem;
use Phoriz\ViewBinding\ViewBinder;

class GetExampleMenu extends Operation
{

    public function __construct()
    {
        parent::__construct('GetExampleMenu');
    }

    public function execute()
    {
        $menus = $this->siteMap->buildMenuFrom(null, 2);
        foreach ($menus as $menu) {
            $exmenu = array();
            $exnode = $menu->findNodeNamed("Examples");
            if (isset($exnode)) {
                foreach ($exnode->getChildNodes() as $ex) {
                    $exmenu[] = $this->contextForMenuItem($ex);
                }
                $context = array('example_menu'=>$exmenu);
                $this->fireContextEvent($context);
                break;
            }
        }
    }

    /**
     * @param MenuItem $menu
     */
    private function contextForMenuItem($menu)
    {
        $current['active'] = $menu->isActive();
        $current['caption'] = $menu->getCaption();
        $current['href'] = $menu->getUrl(null, null);
        return $current;
    }
}