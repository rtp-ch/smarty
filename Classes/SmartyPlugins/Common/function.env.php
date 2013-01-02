<?php

/***************************************************************
 *  Copyright notice
 *
 *
 *    Created by Simon Tuck <stu@rtpartner.ch>
 *    Copyright (c) 2006-2007, Rueegg Tuck Partner GmbH (wwww.rtpartner.ch)
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 *
 *    @copyright     2006, 2007 Rueegg Tuck Partner GmbH
 *    @author     Simon Tuck <stu@rtpartner.ch>
 *    @link         http://www.rtpartner.ch/
 *    @package     Smarty (smarty)
 *
 ***************************************************************/

/**
 * Smarty plugin "env"
 * -------------------------------------------------------------
 * File:    function.env.php
 * Type:    function
 * Name:    System Environment Variables
 * Version: 1.0
 * Author:  Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Provides access to t3lib_div::getIndpEnv
 * Example: {env name="TYPO3_SITE_URL"}
 * -------------------------------------------------------------
 *
 * @see t3lib_div::getIndpEnv
 * @param $params
 * @param Smarty_Internal_Template $template
 * @return string
 * @throws Tx_Smarty_Exception_PluginException
 */
function smarty_function_env($params, Smarty_Internal_Template $template)
{
    $params = array_change_key_case($params, CASE_LOWER);
    if (!isset($params['name'])) {
        $msg = 'The setting "name" is required smarty templating function {env}!';
        throw new Tx_Smarty_Exception_PluginException($msg, 1331633555);
    }

    //
    return t3lib_div::getIndpEnv(strtoupper($params['name']));
}