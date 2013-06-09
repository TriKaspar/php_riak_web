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
use Phoriz\NamedNode;
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
        $navigation = array();
        /** @var $menus \Phoriz\SiteMap\MenuItem[] */
        foreach ($menus as $menu) {
            $ref = array();
            $navigation[] = $this->contextForMenuItem($menu, $ref);
        }
        $context = array('navigation'=>$navigation);
        $this->fireContextEvent($context);
    }

    /**
     * @param MenuItem $menu
     * @param array $parent
     * @return
     */
    private function contextForMenuItem($menu, &$parent)
    {
        if ($menu->isActive()) {
            $current['active'] = true;

            // If we have parent make that active aswell example is active
            if (is_array($parent) && count($parent) > 0) {
                $parent['active'] = true;
            }
        }
        $current['caption'] = $menu->getCaption();
        $href = $menu->getUrl(null, null);
        $childs = $menu->getChildNodes();
        $hasChildren = is_array($childs) && count($childs) > 0;
        if (isset($href) && strlen($href) > 0) {
            $current['href'] = $href;
        } else if ($hasChildren) {
            $current['dropdown'] = true;
        }

        if ($hasChildren) {
            foreach ($childs as $child) {
                $current['children'][] = $this->contextForMenuItem($child, $current);
            }
        }
        return $current;
    }
}
