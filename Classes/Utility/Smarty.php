<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2007 Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
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
***************************************************************/

/**
 * @copyright 	2007 Rueegg Tuck Partner GmbH
 * @author 		Simon Tuck <stu@rtpartner.ch>
 * @link 		http://www.rtpartner.ch/
 * @package 	Smarty (smarty)
 **/


class Tx_Smarty_Utility_Smarty
{
    /**
     * @static
     * @throws Tx_Smarty_Exception_InvalidArgumentException
     * @param Smarty_Internal_Template $template
     * @param $pluginName
     * @return void
     */
    public static function loadPlugin(Smarty_Internal_Template $template, $pluginName)
    {
        // Requires a valid instance of Smarty_Internal_Template
        if(!($template instanceof Smarty_Internal_Template)) {
            $message = 'Method "loadPlugin" requires a valid instance of Smarty_Internal_Template!';
            throw new Tx_Smarty_Exception_InvalidArgumentException($message);
        }

        // Load the plugin
        if(!function_exists($pluginName)) {
            $pluginPath = $template->loadPlugin('smarty_modifier_format');
            if($pluginPath) {
                include_once($pluginPath);
            } else {
                $message = 'Unable to load view helper "' . $pluginName . '"!';
                throw new Tx_Smarty_Exception_ViewHelperException($message);
            }
        }
    }
}