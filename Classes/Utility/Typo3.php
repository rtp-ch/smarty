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
 * @copyright     2007 Rueegg Tuck Partner GmbH
 * @author         Simon Tuck <stu@rtpartner.ch>
 * @link         http://www.rtpartner.ch/
 * @package     Smarty (smarty)
 **/


class Tx_Smarty_Utility_Typo3   
{

    /*public function getContentObject($type, $setup)
    {
        // Gets the content object from the current frontend instance
        if (self::isFeInstance()) {
            $contentObject =  $GLOBALS['TSFE']->cObj->cObjGetSingle($type, $setup);

        // Throws an exception when attempting to access tdlib_cObj from the backend
        // TODO: Simulate a frontend environment (see extBase/Fluid)
        } elseif(self::isBeInstance()) {
            throw new Exception('Not here!');

        // Something went seriously wrong: there's neither a valid backend
        // nor frontend environment available!
        } else {
            throw new Exception('WTF');
        }

        //
        return $contentObject;
    }*/

    /**
     *
     *
     * @return bool
     */
    public static function isFeInstance()
    {
        return (boolean) (TYPO3_MODE === 'FE' && $GLOBALS['TSFE'] instanceof tslib_fe);
    }

    /**
     *
     *
     * @return bool
     */
    public static function isBeInstance()
    {
        return (boolean) (TYPO3_MODE === 'BE' && $GLOBALS['BE_USER'] instanceof t3lib_tsfeBeUserAuth);
    }

    /**
     *
     *
     * @return bool
     */
    public static function isCliMode()
    {
        return (defined('TYPO3_cliMode') && TYPO3_cliMode) ? true : false;
    }
}