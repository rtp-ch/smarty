<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2006-2007 Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
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


// Create a wrapper class extending Smarty
class Tx_Smarty_Wrapper_Wrapper
    extends Smarty
{

    private $configuration;

    public function __construct()
    {
        //$this->configuration = t3lib_div::makeInstance('Tx_Smarty_Wrapper_Configuration');
    }

    /**
     * @param $method
     * @param $args
     * @return mixed
     */
    public final function __call($method, $args)
    {
        t3lib_div::makeInstance('Tx_Smarty_Wrapper_Configuration', $this);
    	// Reroutes all unknown methods to the configuration class
    	return call_user_func_array(array($this, $method), $args);
    }
}