<?php

/***************************************************************
 *  Copyright notice
 *
 *
 *	Created by Peter Klein <peter@umloud.dk>
 *	Copyright (c) 2009 Peter Klein
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
 *	@copyright 	2009 Peter Klein
 *	@author 	Peter Klein <peter@umloud.dk>
 *	@package 	Smarty (smarty)
 *
 ***************************************************************/

/**
 *
 * Smarty plugin "date2cal"
 * -------------------------------------------------------------
 * File:    function.date2cal.php
 * Type:    function
 * Name:    date2cal
 * Version: 1.0
 * Author:  Peter Klein <peter@umloud.dk>
 * Purpose: Enable use of the Javascript popup Calendar (extension "date2cal" required)
 * Example: {date2cal id="birthday" name="tx_rjkfieldtest_pi1[birthday]" calendarCSS="aqua" natLangParser="0" value="$birthday"}
 * Note:	For more details on jscalendar & date2cal in general see:
 * http://www.dynarch.com/static/jscalendar-1.0/doc/html/reference.html
 * http://typo3.org/documentation/document-library/extension-manuals/date2cal/current/
 * -------------------------------------------------------------
 *
 **/

	include_once(t3lib_extMgm::siteRelPath('date2cal') . '/src/class.jscalendar.php');
	
	function smarty_function_date2cal($params, &$smarty) {
	
	    static $allowed = array(
			'date'				=> 'date',
			'eventName'			=> 'string',
			'cache'				=> 'boolean',
			'multiple'			=> 'boolean',
			'singleClick'		=> 'boolean',
			'electric'			=> 'boolean',
			'position'			=> 'array',
			'align'				=> 'string',
			'firstDay'			=> 'integer',
			'weekNumbers'		=> 'boolean',
			'range'				=> 'array',
			'showOthers'		=> 'boolean',
			'showsTime'			=> 'boolean',
			'timeFormat'		=> 'string',
			'time24'			=> 'boolean',
			'ifFormat'			=> 'string',
			'daFormat'			=> 'string',
			'flatCallback'		=> 'function',
			'dateStatusFunc'	=> 'function',
			'dateText'			=> 'function',
			'onSelect'			=> 'function',
			'onClose'			=> 'function',
			'onUpdate'			=> 'function'
	    );

		// id and name are required, rest is optional
		if (!$params['name'] && !$params['id']) return '';

		$JSCalendar = JSCalendar::getInstance();
		
		// Add calendar JavaScript to page header
		if (($jsCode = $JSCalendar->getMainJS()) != '') {
			$GLOBALS['TSFE']->additionalHeaderData['smarty_date2cal'] = $jsCode;
		}
		
		// Special config options
		$JSCalendar->setInputField($params['id']);
		
		if (isset($params['calendarCSS'])) 
			$JSCalendar->setCSS($params['calendarCSS']);
		
		if (isset($params['natLangParser'])) 
			$JSCalendar->setNLP($params['natLangParser']);
		
		// Standard config options
		foreach ($params as $k => $v) {
			if ($type=$allowed[$k]) {
				switch ($type) {
					case 'integer':
						$JSCalendar->setConfigOption($k, intval($v), true);
					break;
					case 'boolean':
						$JSCalendar->setConfigOption($k, ($v?'true':'false'), true);
					break;
					default:
						$JSCalendar->setConfigOption($k, $v);
					break;
				}
			}
		}
		
		return $JSCalendar->render(
			(isset($params['value']) ? $params['value'] : ''),
			$params['name'],
			(isset($params['calImg']) ? $params['calImg'] : ''),
			(isset($params['helpImg']) ? $params['helpImg'] : '')
		);
	}

?>


