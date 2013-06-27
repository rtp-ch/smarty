<?php

class Tx_Smarty_Utility_Array
{

    /**
     * Explodes a string and trims all values for whitespace in the ends.
     * If $onlyNonEmptyValues is set, then all blank ('') values are removed.
     *
     * @static
     * @param    string  $delimiter  Delimiter string to explode with
     * @param    string  $str    The string to explode
     * @param    boolean $onlyNonEmptyValues If set, all empty values (='') will NOT be set in output
     * @param    int     $limit  If positive, the result will contain a maximum of $limit
     *                   elements, if negative, all components except the last
     *                   -$limit are returned, if zero (default), the result
     *                   is not limited at all.
     *
     * @return array
     */
    public static function trimExplode($delimiter, $str, $onlyNonEmptyValues = true, $limit = 0)
    {
        $arr = array();
        if (is_string($str)) {

            // Explodes and trims
            $arr = self::trimList(explode($delimiter, $str), $onlyNonEmptyValues);

            // $limit cannot be larger than the number of array members
            $limit = (is_int($limit) && abs($limit) < count($arr)) ? $limit : 0;

            // Apply $limit to the array
            if ($limit > 0) {
                $arr =  array_slice($arr, 0, $limit);

            } elseif($limit < 0) {
                $arr = array_slice($arr, $limit);
            }
        }

        return $arr;
    }

    /**
     * Trims members of a list and optionally strips empty
     * members from the list.
     *
     * @static
     * @param array $arr
     * @param boolean $onlyNonEmptyValues
     *
     * @return array
     */
    public static function trimList($arr, $onlyNonEmptyValues = true)
    {
        if ($onlyNonEmptyValues) {
            return array_filter(array_map('trim', $arr), 'strlen');

        } else {
            return array_map('trim', $arr);
        }
    }

    /**
     * Checks if an array is an array with members
     *
     * @param $arr
     * @return bool
     */
    public static function notEmpty($arr)
    {
        return is_array($arr) && !empty($arr);
    }


    /**
     * Ensures that the values for the given fields of an array are themselves arrays. For example given the following
     * array and the fields array('field_1', 'field_2')
     *
     * myArray => array(
     *      'field_1' => 'value_1',
     *      'field_2' => 'value_2,value_3,value_4',
     *      'field_3' => 'value_5,value_6'
     * )
     *
     * Will modify and return myArray as follows:
     *
     * myArray => array(
     *      'field_1' => array(
     *          'value_1'
     *      ),
     *      'field_2' => array(
     *          'value_2',
     *          'value_3',
     *          'value_4'
     *      ),
     *      'field_3' => 'value_5,value_6'
     * )
     *
     * @param $options
     * @param array $fields
     * @return mixed
     */
    public static function optionExplode($options, $fields = array())
    {
        if (!is_array($fields)) {
            $fields = t3lib_div::trimExplode(',', $fields, true);
        }

        if (self::notEmpty($options) && self::notEmpty($fields)) {
            foreach ($options as $key => $option) {
                if (in_array($key, $fields) && !is_array($option)) {
                    $options[$key] = t3lib_div::trimExplode(',', $option, true);
                }
            }
        }

        return $options;
    }
}