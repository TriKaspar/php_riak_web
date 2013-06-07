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
use Phoriz\SiteMap\MenuItem;

class GetTopMenu extends Operation
{

    public function __construct()
    {
        parent::__construct('GetTopMenu');
    }

    public function execute()
    {
        $menus = $this->siteMap->buildMenuFrom(null, 2);
        var_dump($menus);
        $navigation = array();
        /** @var $menus \Phoriz\SiteMap\MenuItem[] */
        foreach ($menus as $menu) {
            $navigation[] = $this->contextForMenuItem($menu);
        }
        $context = array('navigation'=>$navigation);
        var_dump($context);
        $this->fireContextEvent($context);
    }

    /**
     * @param MenuItem $menu
     */
    private function contextForMenuItem($menu)
    {
        $current['active'] = $menu->isActive();
        $current['caption'] = $menu->getCaption();
        $href = $menu->getUrl(null, null);
        if (isset($href) && strlen($href) > 0) {
            $current['href'] = $href;
        }
        $childs = $menu->getChildNodes();
        if (is_array($childs) && count($childs) > 0 ) {
            foreach ($childs as $child) {
                $current['children'][] = $this->contextForMenuItem($child);
            }
        }
        return $current;
    }
}
