<?php

/**
 * Smarty plugin "files"
 * -------------------------------------------------------------
 * File:    function.image.php
 * Type:    function
 * Name:    Image
 * Version: 2.0
 * Author:  Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Gets a TYPO3 content object type "IMAGE"
 * Example: {image file="fileadmin/pic.jpg" file.width="150" }
 * Example: {image setup="lib.myImage" file.width="150c" file.height="180c"}
 * Note:    You can add any property valid for the TypoScript IMAGE object,
 *          For example, file="fileadmin/pic.jpg" or width="150" or file.height="180c" etc.
 *          For details of available parameters check the IMAGE, imgResource and GIFBUILDER documentation at:
 *          http://typo3.org/documentation/document-library/references/doc_core_tsref/current/view/8/6/
 *          http://typo3.org/documentation/document-library/references/doc_core_tsref/current/view/5/2/
 *          http://typo3.org/documentation/document-library/references/doc_core_tsref/current/view/8/6/
 * Note:    The parameter "setup" will reference the global template scope, so you can pass a typoscript
 *          object which defines your link configuratiopn.
 *          For example, if your TypoScript setup contains an element lib.myImage, adding
 *          setup="lib.myImage" will use the TypoScript configuration from lib.myImage to create the image
 * Note:    Any parameters inside the image tag will override the corresponding parameters in the TypoScript
 *          object from setup. For example, {image setup="lib.myImage" file.width="150c"}
 *          will use the TypoScript configuration from lib.myImage, but set the property 'file.width' to 150c
 * -------------------------------------------------------------
 *
 * @param array $params The TypoScript settings passed to the image function
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
