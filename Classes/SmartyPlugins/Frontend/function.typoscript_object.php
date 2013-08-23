<?php

/**
 * Smarty plugin "typoscript_object"
 * -------------------------------------------------------------
 * File:    function.typoscript_object.php
 * Type:    function
 * Name:    TypoScript Object
 * Version: 2.0
 * Author:  Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose:    Gets and displays an object from global TyposScript template scope
 * Example:    {object setup="lib.myImage" type="IMAGE"}
 * Example:    {object setup="lib.myMenu" type="HMENU" 1.NO.wrap="<li class='innermenu'>|</li>"}
 * Note:    The parameter "setup" references the typoscript object from the global TypoScript
 *            template scope. For example, if your TypoScript setup contains an element myImage
 *            setup="lib.myImage" will insert the content object defined in lib.myImage.
 * Note:    Any parameters inside the object tag will override the corresponding parameters in the TypoScript
 *            object. For example, {object setup="lib.myMenu" type="HMENU" entryLevel="2"}
 *            will insert the HMENU object defined in lib.myMenu and set the entryLevel of the HMENU to 2
 * Note:    You can manually define the object type with the paramter "type", e.g.
 *             {object setup="lib.myImage" type="IMAGE"}
 * -------------------------------------------------------------
 *
 * @param $params
 * @param Smarty_Internal_Template $template
 * @return mixed
 */
//@codingStandardsIgnoreStart
function smarty_function_typoscript_object($params, Smarty_Internal_Template $template)
{
//@codingStandardsIgnoreEnd
    Tx_Smarty_Service_Smarty::loadPlugin($template, 'smarty_function_object');
    return smarty_function_object($params, $template);
}
