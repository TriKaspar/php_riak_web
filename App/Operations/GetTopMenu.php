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
namespace App\Operations;
use Phoriz\Operation\Operation;

class GetTopMenu extends Operation
{

    public function __construct()
    {
        parent::__construct('GetTopMenu');
    }

    public function execute()
    {
        $menus = $this->siteMap->buildRootMenu();
        $navigation = array();
        /** @var $menus \Phoriz\SiteMap\MenuItem[] */
        foreach ($menus as $menu) {
            $href = $menu->getUrl(null, null);
            $active = $menu->isActive();
            $caption = $menu->getCaption();
            if ($caption !== "Logout" && $caption !== "Login") {
                $navigation[] = array('href' => $href, 'caption' => $caption, 'active' => $active);
            }
        }
        $context = array('navigation'=>$navigation);
        $this->fireContextEvent($context);
    }
}
