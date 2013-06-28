<?php

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
 * Note:    For more details on jscalendar & date2cal in general see:
 * http://www.dynarch.com/static/jscalendar-1.0/doc/html/reference.html
 * http://typo3.org/documentation/document-library/extension-manuals/date2cal/current/
 * -------------------------------------------------------------
 *
 **/
function smarty_function_date2cal($params, Smarty_Internal_Template $template)
{
    if (!t3lib_extMgm::isLoaded('date2cal')) {
        $msg = 'Extension "date2cal" is required for the smarty templating function {date2cal}!';
        throw new Tx_Smarty_Exception_PluginException($msg, 1356441267);
    }

    require_once(t3lib_extMgm::siteRelPath('date2cal') . '/src/class.jscalendar.php');

    static $allowed = array(
        'date'              => 'date',
        'eventName'         => 'string',
        'cache'             => 'boolean',
        'multiple'          => 'boolean',
        'singleClick'       => 'boolean',
        'electric'          => 'boolean',
        'position'          => 'array',
        'align'             => 'string',
        'firstDay'          => 'integer',
        'weekNumbers'       => 'boolean',
        'range'             => 'array',
        'showOthers'        => 'boolean',
        'showsTime'         => 'boolean',
        'timeFormat'        => 'string',
        'time24'            => 'boolean',
        'ifFormat'          => 'string',
        'daFormat'          => 'string',
        'flatCallback'      => 'function',
        'dateStatusFunc'    => 'function',
        'dateText'          => 'function',
        'onSelect'          => 'function',
        'onClose'           => 'function',
        'onUpdate'          => 'function'
    );

    // id and name are required, rest is optional
    if (!$params['name'] && !$params['id']) {
        return '';
    };

    $JSCalendar = JSCalendar::getInstance();

    // Add calendar JavaScript to page header
    if (($jsCode = $JSCalendar->getMainJS()) !== '') {
        $GLOBALS['TSFE']->additionalHeaderData['smarty_date2cal'] = $jsCode;
    }

    // Special config options
    $JSCalendar->setInputField($params['id']);

    if (isset($params['calendarCSS'])) {
        $JSCalendar->setCSS($params['calendarCSS']);
    }

    if (isset($params['natLangParser'])) {
        $JSCalendar->setNLP($params['natLangParser']);
    }

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


