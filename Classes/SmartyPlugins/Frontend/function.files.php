<?php

/**
 * Smarty plugin "files"
 * -------------------------------------------------------------
 * File:    function.files.php
 * Type:    function
 * Name:    Files
 * Version: 1.0
 * Author:  Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Gets a TYPO3 content object type "FILES"
 * Example: {files files=10 renderObj=TEXT stdWrap.data="file:current:title"}
 *          Gets the title of the file with id 10 in sys_file
 * Example: {files references=1 renderObj=TEXT stdWrap.data="file:current:title"}
 *          Gets the title of the file referenced by id in sys_file_reference
 * Note:    You can add any property valid for the TypoScript FILES object,
 *          For details of available parameters check the FILES and FAL documentation at:
 *          http://docs.typo3.org/typo3cms/TyposcriptReference/ContentObjects/Files/Index.html
 *          http://wiki.typo3.org/File_Abstraction_Layer
 * -------------------------------------------------------------
 *
 * @param array $params The TypoScript settings passed to the files function
 * @param Smarty_Internal_Template $template Current instance of smarty
 * @return string
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
//@codingStandardsIgnoreStart
function smarty_function_files($params, Smarty_Internal_Template $template)
{
//@codingStandardsIgnoreEnd
    list($setup) = Tx_Smarty_Utility_TypoScript::getSetupFromParameters($params);
    $cObj = Tx_Smarty_Service_Compatibility::makeInstance('Tx_Smarty_Core_CobjectProxy');

    $files = $cObj->cObjGetSingle('FILES', $setup);

    // Returns or assigns the result
    if (isset($params['assign'])) {
        $template->assign($params['assign'], $files);

    } else {
        return $files;
    }
}
