<?php

/**
 * Smarty plugin "img_resource"
 * -------------------------------------------------------------
 * File:    function.img_resource.php
 * Type:    function
 * Name:    Image Resource
 * Version: 2.0
 * Author:  Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Renders IMG_RESOURCE cObjects
 * Example: {img_resource file="fileadmin/pic.jpg" file.width="150" }
 * Note:    You can add any property valid for the TypoScript IMG_RESOURCE object,
 *          For example, file="fileadmin/pic.jpg" or width="150" or file.height="180c" etc.
 *          For details of available parameters check the IMAGE, imgResource and GIFBUILDER documentation at:
 *          http://typo3.org/documentation/document-library/references/doc_core_tsref/4.1.0/view/8/6/
 *          http://typo3.org/documentation/document-library/references/doc_core_tsref/4.1.0/view/5/2/
 *          http://typo3.org/documentation/document-library/references/doc_core_tsref/4.1.0/view/8/6/
 * Note:    The parameter "setup" will reference the global template scope, so you can pass a typoscript
 *          object which defines your link configuratiopn.
 *          For example, if your TypoScript setup contains an element lib.myImage, adding
 *          setup="lib.myImage" will use the TypoScript configuration from lib.myImage to create the image
 * Note:    Any parameters inside the image tag will override the corresponding parameters in the TypoScript
 *          object from setup. For example, {image setup="lib.myImage" file.width="150c"}
 *          will use the TypoScript configuration from lib.myImage, but set the property 'file.width' to 150c
 * -------------------------------------------------------------
 *
 * @param $params
 * @param Smarty_Internal_Template $template
 * @return mixed
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
//@codingStandardsIgnoreStart
function smarty_function_img_resource($params, Smarty_Internal_Template $template)
{
//@codingStandardsIgnoreEnd
    list($setup) = Tx_Smarty_Utility_TypoScript::getSetupFromParameters($params);
    $frontend = Tx_Smarty_Service_Compatibility::makeInstance('Tx_Smarty_Core_FrontendProxy');

    $imgResource = $frontend->cObj->cObjGetSingle('IMG_RESOURCE', $setup);

    // Returns or assigns the result
    if (isset($params['assign'])) {
        $template->assign($params['assign'], $imgResource);

    } else {
        return $imgResource;
    }
}
