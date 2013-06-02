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
namespace App;
if (!defined('DS')) {
    define("DS", DIRECTORY_SEPARATOR);
    define("ROOT",dirname(dirname(dirname(__FILE__))));
    define("APP",ROOT.DS."App");
}
require ROOT.DS.'vendor'.DS.'autoload.php';
