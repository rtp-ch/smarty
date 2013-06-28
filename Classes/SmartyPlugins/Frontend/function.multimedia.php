<?php

/**
 * Smarty plugin "multimedia"
 * -------------------------------------------------------------
 * File:    function.multimedia.php
 * Type:    function
 * Name:    Multimedia
 * Version: 1.0
 * Author:  R. Alessandri <ral@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Displays any object from global TS (such as IMAGE, COA, TEXT, etc.)
 * Example:    {multimedia file="fileadmin/anim.swf" params.width="150" }
 * Example:    {multimedia setup="lib.myMultimedia" params.width="150" params.height="180c"}
 *
 * Note:    You can add any property valid for the TypoScript MULTIMEDIA object,
 * For example, file="fileadmin/anim.swf" or params.width="150" etc.
 *
 * For details of available parameters check the MULTIMEDIA documentation at:
 * http://typo3.org/documentation/document-library/core-documentation/doc_core_tsref/4.2.0/view/1/8/#id4302297
 *
 * Note:The parameter "setup" will reference the global template scope, so you can pass a typoscript object
 * which defines your link configuratiopn. For example, if your TypoScript setup contains an element lib.myMultimedia,
 * adding setup="lib.myMultimedia" will use the TypoScript configuration from lib.myMultimeda to create the multimedia
 * object.
 *
 * Note: Any parameters inside the multimedia tag will override the corresponding parameters in the TypoScript object
 * from setup. For example, {multimedia setup="lib.myMultimedia" params.width="150"} will use the TypoScript
 * configuration from lib.myMultimedia, but set the property 'params.width' to 150
 * -------------------------------------------------------------
 *
 * @param $params
 * @param Smarty_Internal_Template $template
 * @return mixed
 */
function smarty_function_multimedia($params, Smarty_Internal_Template $template)
{
    list($setup) = Tx_Smarty_Utility_TypoScript::getSetupFromParameters($params);
    $cObj = t3lib_div::makeInstance('Tx_Smarty_Core_CobjectProxy');

    return $cObj->cObjGetSingle('MULTIMEDIA', $setup);
}