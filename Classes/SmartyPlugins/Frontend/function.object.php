<?php

/**
 * Smarty plugin "object"
 * -------------------------------------------------------------
 * File:    function.object.php
 * Type:    function
 * Name:    TypoScript Object
 * Version: 2.0
 * Author:  Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose:    Gets and displays an object from global TyposScript template scope
 * Example:    {object setup="lib.myImage" type="IMAGE"}
 * Example:    {object setup="lib.myMenu" type="HMENU" 1.NO.wrap="<li class='innermenu'>|</li>"}
 *
 * Note: The parameter "setup" references the typoscript object from the global TypoScript template scope. For example,
 * if your TypoScript setup contains an element myImage setup="lib.myImage" will insert the content object defined in
 * lib.myImage.
 *
 * Note: Any parameters inside the object tag will override the corresponding parameters in the TypoScript object.
 * For example, {object setup="lib.myMenu" type="HMENU" entryLevel="2"} will insert the HMENU object defined in
 * lib.myMenu and set the entryLevel of the HMENU to 2
 *
 * Note: You can manually define the object type with the paramter "type",
 * e.g. {object setup="lib.myImage" type="IMAGE"}
 * -------------------------------------------------------------
 *
 * @param $params
 * @param Smarty_Internal_Template $template
 * @return mixed
 */
function smarty_function_object($params, Smarty_Internal_Template $template)
{

    // cObject Type is explicitly defined
    if (isset($params['type'])) {
        $type = $params['type'];
        unset($params['type']);

        list($setup) = Tx_Smarty_Utility_TypoScript::getSetupFromParameters($params);

    // Otherwise get it from params
    } else {
        list($setup, $type) = Tx_Smarty_Utility_TypoScript::getSetupFromParameters($params);
    }

    $cObj = t3lib_div::makeInstance('Tx_Smarty_Core_CobjectProxy');
    return $cObj->cObjGetSingle($type, $setup);
}