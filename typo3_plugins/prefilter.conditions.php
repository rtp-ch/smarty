<?php

/***************************************************************
 *  Copyright notice
 *
 *
 *	Created by Simon Tuck <stu@rtpartner.ch>
 *	Copyright (c) 2006-2007, Rueegg Tuck Partner GmbH (wwww.rtpartner.ch)
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
 *	@copyright 	2006, 2007 Rueegg Tuck Partner GmbH
 *	@author 	Simon Tuck <stu@rtpartner.ch>
 *	@link 		http://www.rtpartner.ch/
 *	@package 	Smarty (smarty)
 *
 ***************************************************************/

/**
 *
 * Smarty prefilter "conditions"
 * -------------------------------------------------------------
 * File:	prefilter.conditions.php
 * Type:	prefilter
 * Name:	Typoscript conditions
 * Version:	2.0
 * Author:  Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
 * Purpose:	Evaluates typoscript conditions in smarty templates
 * Example:	{if [tscondition1] && [tscondition2] }...{/if}
 * -------------------------------------------------------------
 *
 **/


	function smarty_prefilter_conditions($tpl_source, &$smarty) {
		if (preg_match_all('/(?ix)\s*(?:elseif|if|&&|\|\|){1}\s*(\[[^\]]*\])/', $tpl_source, $conditions)) {
			$ts_match = t3lib_div::makeInstance('t3lib_matchCondition');
			foreach($conditions[1] as $n => $condition) {
				$matches[$n] = ($ts_match->match($condition))?'TRUE':'FALSE';
			}
			$matches = str_replace($conditions[1], $matches, $conditions[0]);
			$tpl_source = str_replace($conditions[0], $matches, $tpl_source);
		}
		return $tpl_source;
	}

?>