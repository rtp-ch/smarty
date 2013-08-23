<?php

/**
 * Smarty plugin "lookup"
 * -------------------------------------------------------------
 * File:    function.lookup.php
 * Type:    function
 * Name:    Data
 * Version: 2.0
 * Author:  Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Returns DB result for a given table and value, usually from a get or post var
 * Example: {lookup GPvar="email" field="email" table="fe_users" alias="name"} Returns the name corresponding to
 * the email address supplied in Post/Get
 * Example: {lookup data="GPvar:tx_myext|uid" field="uid" table="ty_mext" alias="title"} Returns the title
 * corresponding to the uid supplied in Post/Get. For details on the "data" function check "getText" at:
 * http://typo3.org/documentation/document-library/references/doc_core_tsref/current/view/2/2/
 * Example: {lookup data="GPvar:tx_myext|uid" field="uid" table="ty_mext" list="field1, field2, field3" delim=","}
 * Returns the result as a list of fields seperated by delim
 * Note: This plugin will only work in a frontend context!
 * -------------------------------------------------------------
 *
 * @param $params
 * @param Smarty_Internal_Template $template
 * @throws Tx_Smarty_Exception_PluginException
 * @return bool|string
 * @deprecated Usage of this plugin is discouraged
 */
//@codingStandardsIgnoreStart
function smarty_function_lookup($params, Smarty_Internal_Template $template)
{
//@codingStandardsIgnoreEnd

    Tx_Smarty_Service_Compatibility::logDeprecatedFunction();

    // Make sure params are lowercase
    $params = array_change_key_case($params, CASE_LOWER);

    // Default table is pages
    $table = $params['table'] = getLookupTable($params);

    // Get the lookup field, exit if unknown field
    $lookupField = getLookupField($params);

    // Gets the fields to return, exit if unknown field
    $returnFields = getReturnFields($params);

    // Gets the value to lookup
    $lookupValue = getLookupValue($params);

    //
    $returnValue = null;

    // Perform the lookup
    if (!is_null($lookupValue) && is_scalar($lookupValue) && strlen(trim($lookupValue))) {

        $lookupResult = executeQuery($lookupValue, $lookupField, $returnFields, $table);

        if ($lookupResult && count($lookupResult) > 1 && !$params['as_array']) {
            $delim = $params['delim'] ? $params['delim'] : ',';
            $returnValue = implode($delim, $lookupResult);
        }
    }

    // Returns or assigns the result
    if (isset($params['assign'])) {
        $template->assign($params['assign'], $returnValue);

    } else {
        return $returnValue;
    }
}

/**
 * Gets the values for the return fields which are retrieved from the table where a value matching the lookup
 * value is found in the lookup field.
 *
 * @param $lookupValue
 * @param $lookupField
 * @param $returnFields
 * @param $table
 * @return bool
 */
function executeQuery($lookupValue, $lookupField, $returnFields, $table)
{
    $lookupResult = false;

    $where = mysql_real_escape_string($lookupField) . ' = :lookupValue';
    if (isset($GLOBALS['TCA'][$table]['ctrl'])) {
        $where .= $GLOBALS['TSFE']->sys_page->enableFields($table);
    }

    $statement = $GLOBALS['TYPO3_DB']->prepare_SELECTquery(
        '*',
        $table,
        $where
    );
    $statement->execute(array(':lookupValue' => $lookupValue));

    if ($statement->rowCount() === 1) {
        $record = $statement->fetch();
        while ($returnField = array_shift($returnFields)) {
            $lookupResult[$returnField] = $record[$returnField];
        }
    }
    $statement->free();

    return $lookupResult;
}

/**
 * Gets the table which the lookup refers to. Defaults to pages if undefined.
 *
 * @param $params
 * @return string
 */
function getLookupTable($params)
{
    return !isset($params['table']) ? 'pages' : $params['table'];
}

/**
 * Gets the field which will be looked up. Defaults to uid if undefined.
 *
 * @param $params
 * @return string
 * @throws Tx_Smarty_Exception_PluginException
 */
function getLookupField($params)
{
    $field = !isset($params['field']) ? 'uid' : $params['table'];

    if (!fieldExists($field, $params['table'])) {
        $msg = 'Unknown field "' . $field . '" in table "' . $params['table'] . '"!';
        throw new Tx_Smarty_Exception_PluginException($msg, 1323967959);
    }

    return $field;
}

/**
 * Checks if the given field exists in the table
 *
 * @param $field
 * @param $table
 * @return bool
 */
function fieldExists($field, $table)
{
    return array_key_exists($field, getFieldsOfTable($table));
}

/**
 * Gets the fields of the given table
 *
 * @param $table
 * @return mixed
 */
function getFieldsOfTable($table)
{
    static $fields = array();

    if (!isset($fields[$table])) {
        $fields[$table] = $GLOBALS['TYPO3_DB']->admin_get_fields($table);
    }

    return $fields[$table];
}

/**
 * Gets the lookup value
 *
 * @param $params
 * @return null
 */
function getLookupValue($params)
{
    $lookupValue = null;

    if ($params['gpvar']) {
        // Get the value from Get/Post variables
        $lookupValue = $GLOBALS['TSFE']->cObj->getData('GPVar:' . $params['gpvar']);

    } elseif ($params['data']) {
        // Get the value from TYPO3 getData method
        $lookupValue = $GLOBALS['TSFE']->cObj->getData($params['data']);

    } elseif ($params['value']) {
        // Fixed value has been defined
        $lookupValue = $params['value'];
    }

    return $lookupValue;
}

/**
 * Gets the fields to return. Either from "alias", "list" or the table's label field
 *
 * @param $params
 * @return array
 */
function getReturnFields($params)
{
    $returnFields = null;

    if (isset($params['alias']) || isset($params['list'])) {
        $returnFields = isset($params['alias']) ? $params['alias'] : $params['list'];

    } else {
        // Default to the table's label field if there is no defined alias or list of fields to return
        Tx_Smarty_Service_Compatibility::loadTca($params['table']);
        $returnFields = $GLOBALS['TCA'][$params['table']]['ctrl']['label'];
    }

    // Checks that the fields are available in the table
    $returnFields = Tx_Smarty_Utility_Array::trimExplode($returnFields);
    foreach ($returnFields as $returnField) {
        if (!fieldExists($returnField, $params['table'])) {
            throwFieldException($returnField, $params['table']);
        }
    }

    return $returnFields;
}

/**
 * @param $field
 * @param $table
 * @throws Tx_Smarty_Exception_PluginException
 */
function throwFieldException($field, $table)
{
    $msg = 'Unknown field "' . $field . '" in table "' . $table . '"!';
    throw new Tx_Smarty_Exception_PluginException($msg, 1323967959);
}
