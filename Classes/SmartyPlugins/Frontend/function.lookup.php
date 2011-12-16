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
     *
     * Smarty plugin "lookup"
     * -------------------------------------------------------------
     * File:    function.lookup.php
     * Type:    function
     * Name:    Data
     * Version: 2.0
     * Author:  Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
     * Purpose: Returns DB result for a given table and value, usually from a get or post var
     * Example: {lookup GPvar="email" field="email" table="fe_users" alias="name"} Returns the name corresponding to
     *             the email address supplied in Post/Get
     * Example: {lookup data="GPvar:tx_myext|uid" field="uid" table="ty_mext" alias="title"} Returns the title corresponding to
     *             the uid supplied in Post/Get. For details on the "data" function check "getText" at:
     *             http://typo3.org/documentation/document-library/references/doc_core_tsref/current/view/2/2/
     * Example: {lookup data="GPvar:tx_myext|uid" field="uid" table="ty_mext" list="field1, field2, field3" delim=","} Returns the result
     *          as a list of fields seperated by delim
     * -------------------------------------------------------------
     *
     * @param $params
     * @param Smarty_Internal_Template $template
     * @return bool|string
     * @throws Tx_Smarty_Exception_InvalidArgumentException
     */
    function smarty_function_lookup($params, Smarty_Internal_Template $template)
    {
        // Make sure params are lowercase
        $params = array_change_key_case($params,CASE_LOWER);

        // Default table is pages
        if(!$params['table']) $params['table'] = 'pages';

        // Get the lookup field, exit if unknown field
        if(!$params['field']) {
            $params['field'] = 'uid';
        } elseif (!array_key_exists($params['field'], $GLOBALS['TYPO3_DB']->admin_get_fields($params['table']))) {
            throw new Tx_Smarty_Exception_InvalidArgumentException('Unknown field "' . $params['field'] . '" in table "' . $params['table'] . '"!', 1323967959);
        }

        // Get the field value to return, exit if unknown field
        if(!$params['alias'] && !$params['list']) {
            t3lib_div::loadTCA($params['table']);
            $params['alias'] = $GLOBALS['TCA'][$params['table']]['ctrl']['label']; // Default alias is the record label
        } elseif ($params['alias'] && !array_key_exists($params['alias'], $GLOBALS['TYPO3_DB']->admin_get_fields($params['table']))) {
            throw new Tx_Smarty_Exception_InvalidArgumentException('Unknown alias "'.$params['alias'].'" in table "'.$params['table'].'"!', 1323968081);
        }

        // Get an instance of tslib_cObj
        $cObj = t3lib_div::makeInstance('Tx_Smarty_Core_CobjectProxy');

        // Get the value to lookup
        if($params['gpvar']) {
            $lookupValue = $cObj->getData('GPVar:'.$params['gpvar']);
        } elseif($params['data']) {
            $lookupValue = $cObj->getData($params['data']);
        } elseif($params['value']) {
            $lookupValue = $params['value'];
        }

        //
        $returnValue = null;

        // Find and return the matching value
        if(is_scalar($lookupValue) && strlen(trim($lookupValue))) {
            $lookupValue = (!is_numeric($lookupValue)) ? '\'' . mysql_real_escape_string($lookupValue) . '\'' :  mysql_real_escape_string($lookupValue);
            $where  = mysql_real_escape_string($params['field']) . ' = ' . $lookupValue;
            $where .= (t3lib_div::loadTCA($params['table'])) ? $GLOBALS['TSFE']->sys_page->enableFields($params['table']) : '';
            $result = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', $params['table'], $where);
            if(is_array($result) && count($result) === 1) {
                if($params['alias'] && $result[0][$params['alias']]) {
                    $returnValue = $result[0][$params['alias']];
                } else {
                    $items = array_unique(t3lib_div::trimExplode(',', $params['list'], 1));
                    foreach($items as $item) if(trim($result[0][$item])) $list[$item] = trim($result[0][$item]);
                    $delim = $params['delim'] ? $params['delim'] : ',';
                    $returnValue = !empty($list) ? implode($delim, $list) : false;
                }
            }
        }

        //
        return $returnValue;
    }