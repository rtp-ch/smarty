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


class Tx_Smarty_Utility_ExtConf
{
    /**
     * 
     * System wide extension configuration
     * 
     * @var array
     */
    private static $extConf;

    /**
     * Gets the system wide extension configuration
     * 
     * @return array
     */
    public static function getExtConf()
    {
        if (is_null(self::$extConf)) {
            self::$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['smarty']);
        }

        return self::$extConf;
    }

    /**
     * Retrieves a setting for a given key from the system wide extension configuration.
     *
     * @param string $key The configuration setting to retrieve
     * @return string
     */
    public static function getExtConfValue($key)
    {
        $extConf = self::getExtConf();

        return isset($extConf[$key]) ? $extConf[$key] : null;
    }
}