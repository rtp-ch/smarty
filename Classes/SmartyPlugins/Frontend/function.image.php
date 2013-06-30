<?php

/**
 *
 * Smarty plugin "image"
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
 */
function smarty_function_image($params, Smarty_Internal_Template $template)
{
    list($setup) = Tx_Smarty_Utility_TypoScript::getSetupFromParameters($params);
    $cObj = t3lib_div::makeInstance('Tx_Smarty_Core_CobjectProxy');

    // Apply htmlspecialchars to any altText
    if ($setup['altText'] || $setup['altText.']) {
        $setup['altText'] = $cObj->stdWrap($setup['altText'], $setup['altText.']);
        $setup['title'] = htmlspecialchars(
            trim($setup['altText']),
            ENT_COMPAT | ENT_HTML401,
            SMARTY_RESOURCE_CHAR_SET,
            false
        );
        unset($setup['altText.']);
    }

    // Apply htmlspecialchars to any titleText
    if ($setup['titleText'] || $setup['titleText.']) {
        $setup['titleText'] = $cObj->stdWrap($setup['titleText'], $setup['titleText.']);
        $setup['titleText'] = htmlspecialchars(
            trim($setup['titleText']),
            ENT_COMPAT | ENT_HTML401,
            SMARTY_RESOURCE_CHAR_SET,
            false
        );
        unset($setup['titleText.']);
    }

    return $cObj->cObjGetSingle('IMAGE', $setup);
}