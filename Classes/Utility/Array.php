<?php

class Tx_Smarty_Utility_Array
{


    /**
     * Explodes a string and trims all values for whitespace in the ends.
     * If $onlyNonEmptyValues is set, then all blank ('') values are removed.
     * @see \t3lib_div::trimExplode
     * @see \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode
     *
     * @param string $str The string to explode
     * @param string $delimiter Delimiter string to explode with
     * @param boolean $onlyNonEmptyValues If set (default), all empty values (='') will NOT be set in output
     * @param int $limit If positive, the result will contain a maximum of $limit elements, if negative,
     *        all components except the last -$limit are returned, if zero (default), the result is not limited at all.
     *
     * @return array
     */
    public static function trimExplode($str, $delimiter = ',', $onlyNonEmptyValues = true, $limit = 0)
    {
        $arr = array();

        if (is_string($str)) {

            // Explodes and trims the array
            $arr = (array) self::trimList(explode($delimiter, $str), $onlyNonEmptyValues);

            // $limit cannot be larger than the number of array members
            $limit = (is_int($limit) && abs($limit) < count($arr)) ? $limit : 0;

            // Apply $limit to the array
            if ($limit > 0) {
                $arr =  array_slice($arr, 0, $limit);

            } elseif ($limit < 0) {
                $arr = array_slice($arr, $limit);
            }
        }

        return $arr;
    }

    /**
     * Trims members of and optionally strips empty members from an array. An empty member is defined as
     * a zero length string, null or an empty array.
     *
     * @param array $arr
     * @param boolean $onlyNonEmptyValues
     *
     * @return array
     */
    public static function trimList($arr, $onlyNonEmptyValues = true)
    {
        $trimList = array_map(function ($item) {
            return is_string($item) ? trim($item) : $item;
        }, $arr);

        if ($onlyNonEmptyValues) {
            $trimList = array_filter($trimList, function ($item) {
                if (is_string($item)) {
                    return strlen($item) > 0;

                } elseif (is_null($item)) {
                    return false;

                } elseif (is_array($item)) {
                    return !empty($item);
                }

                // All other items (including booleans, e.g. "false") are not removed.
                return true;
            });
        }

        return $trimList;
    }

    /**
     * Checks if the given value is an array with members
     *
     * @param $arr
     * @return bool
     */
    public static function notEmpty($arr)
    {
        return is_array($arr) && !empty($arr);
    }


    /**
     * Explodes the given members of an array into arrays by a given delimiter (the default delimiter is a comma).
     * For example given the following array and the fields array('field_1', 'field_2')
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
     * @param $array
     * @param array $fields
     * @param string $delimiter
     * @throws BadMethodCallException
     * @return mixed
     */
    public static function optionExplode($array, $fields = array(), $delimiter = ',')
    {
        if (!is_scalar($delimiter)) {
            $msg = 'Invalid delimiter!';
            throw new BadMethodCallException($msg, 1372579305);
        }

        if (self::notEmpty($array) && self::notEmpty($fields)) {
            foreach ($array as $key => $option) {
                if (in_array($key, $fields) && !is_array($option)) {
                    $array[$key] = self::trimExplode($option, $delimiter, true);
                }
            }
        }

        return $array;
    }
}