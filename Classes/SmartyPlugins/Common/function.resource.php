<?php

/**
 * Smarty plugin "resource"
 * -------------------------------------------------------------
 * File:    function.resource.php
 * Type:    function
 * Name:    File resource
 * Version: 1.0
 * Author:    Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: returns a FAL resource object or a property of the resource object
 * Example:    {resource reference="12" property="publicUrl" assign="url"}
 * Example2:   {resource reference="12" table="pages" field="media" assign="url"}
 * -------------------------------------------------------------
 *
 * @param $params
 * @param Smarty_Internal_Template $template
 * @throws Tx_Smarty_Exception_PluginException
 * @return mixed
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
//@codingStandardsIgnoreStart
function smarty_function_resource($params, Smarty_Internal_Template $template)
{
//@codingStandardsIgnoreEnd

    $params = array_change_key_case($params, CASE_LOWER);

    $fileReference = isset($params['reference']) ? $params['reference'] : false;
    $requestedProperty = isset($params['property']) ? $params['property'] : false;

    // If the params table and field set, use the new way to get the fal data
    $isSysFileReference = isset($params['table']) && isset($params['field']);

    if ($isSysFileReference) {
        $referencesForeignTable = $params['table'];
        $referencesFieldName = $params['field'];
        $forceArray = isset($params['forcearray']);

        // Get db record
        /** @var \TYPO3\CMS\Frontend\Page\PageRepository $pageRepository */
        $pageRepository = $GLOBALS['TSFE']->sys_page;
        $element = $pageRepository->getRawRecord(
                $referencesForeignTable,
                $fileReference
        );

        // When the element is not valid
        if ($element) {

            // Get file reference
            /** @var TYPO3\CMS\Core\Resource\FileReference[] $resourceObjects */
            $resourceObjects = $pageRepository->getFileReferences(
                $referencesForeignTable,
                $referencesFieldName,
                $element
            );

            // If there is only one picture remove the array arround the image
            if (count($resourceObjects) === 1 && !$forceArray) {
                $resourceObjects = reset($resourceObjects);
            }

            // Returns or assigns the result
            if (isset($params['assign'])) {
                $template->assign($params['assign'], $resourceObjects);
            } else {
                return $resourceObjects;
            }
        }
        else {
            return null;
        }
    } else {

        $resourceObject = null;
        $resourceProperty = null;

        if ($fileReference !== false) {
            try {
                if (\TYPO3\CMS\Core\Utility\MathUtility::canBeInterpretedAsInteger($fileReference)) {
                    /** @var TYPO3\CMS\Core\Resource\FileReference $resourceObject */
                    $resourceObject = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance()->getFileReferenceObject(
                        $fileReference
                    );

                } else {
                    // We have a combined identifier or legacy (storage 0) path
                    /** @var \TYPO3\CMS\Core\Resource\FileInterface|\TYPO3\CMS\Core\Resource\Folder $fileObject */
                    $resourceObject = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance()->retrieveFileOrFolderObject(
                        $fileReference
                    );
                }

                if ($resourceObject instanceof \TYPO3\CMS\Core\Resource\ResourceInterface) {
                    if ($requestedProperty !== false) {
                        // All properties of the \TYPO3\CMS\Core\Resource\FileInterface are available here:
                        switch ($requestedProperty) {
                            case 'name':
                                $resourceProperty = $resourceObject->getName();
                                break;

                            case 'uid':
                                $resourceProperty = $resourceObject->getUid();
                                break;

                            case 'originalUid':
                                if ($resourceObject instanceof \TYPO3\CMS\Core\Resource\FileReference) {
                                    /** @var \TYPO3\CMS\Core\Resource\File $originalFile */
                                    $originalFile = $resourceObject->getOriginalFile();
                                    $resourceProperty = $originalFile->getUid();
                                } else {
                                    $resourceProperty = null;
                                }
                                break;

                            case 'size':
                                $resourceProperty = $resourceObject->getSize();
                                break;

                            case 'sha1':
                                $resourceProperty = $resourceObject->getSha1();
                                break;

                            case 'extension':
                                $resourceProperty = $resourceObject->getExtension();
                                break;

                            case 'mimetype':
                                $resourceProperty = $resourceObject->getMimeType();
                                break;

                            case 'contents':
                                $resourceProperty = $resourceObject->getContents();
                                break;

                            case 'publicUrl':
                                $resourceProperty = $resourceObject->getPublicUrl();
                                break;

                            case 'localPath':
                                $resourceProperty = $resourceObject->getForLocalProcessing();
                                break;

                            default:
                                // Generic alternative here
                                $resourceProperty = $resourceObject->getProperty($requestedProperty);
                        }

                    }

                } else {
                    $resourceObject = null;
                }

            } catch (\Exception $e) {
                $resourceObject = null;
            }
        }

        // Returns or assigns the result
        if (isset($params['assign'])) {
            $template->assign($params['assign'], ($requestedProperty !== false ? $resourceProperty : $resourceObject));

        } else {
            return $requestedProperty !== false ? $resourceProperty : $resourceObject;
        }

    }

}
