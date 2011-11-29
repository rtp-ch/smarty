<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2006 Rueegg Tuck Partner (t3@rtpartner.ch)
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
 *
 * Smarty plugin "krumo"
 * -------------------------------------------------------------
 * File:	function.krumo.php
 * Type:	function
 * Version: 2.0
 * Author:  Manuel Stofer <mst@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Debug with krumo
 * -------------------------------------------------------------
 *
 **/


    if(!class_exists('krumo')) {
	    require_once(t3lib_extMgm::extPath('smarty') . 'lib/krumo/class.krumo.php');
    }

	function smarty_function_krumo($params, &$smarty)
    {
		if(!isset($params['var'])){
			$var = $smarty->_tpl_vars;
		} else{
			$var = $params['var'];
		}

		ob_start();
		krumo($var);
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}