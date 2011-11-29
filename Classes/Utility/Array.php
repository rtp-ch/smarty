<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2007 Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * @copyright 	2007 Rueegg Tuck Partner GmbH
 * @author 		Simon Tuck <stu@rtpartner.ch>
 * @link 		http://www.rtpartner.ch/
 * @package 	Smarty (smarty)
 **/



class Tx_Smarty_Utility_Array
{

    /**
     *
     * Explodes a string and trims all values for whitespace in the ends.
     * If $onlyNonEmptyValues is set, then all blank ('') values are removed.
     *
     * @static
     * @param	string  $delimiter  Delimiter string to explode with
     * @param	string  $str    The string to explode
     * @param	boolean $onlyNonEmptyValues If set, all empty values (='') will NOT be set in output
     * @param	int	    $limit  If positive, the result will contain a maximum of $limit
     *                  elements, if negative, all components except the last
     *                  -$limit are returned, if zero (default), the result
     *                  is not limited at all.
     *
     * @return array
     */
    public static function trimExplode($delimiter, $str, $onlyNonEmptyValues = true, $limit = 0)
    {
        $arr = array();
        if(is_string($str)) {

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
     *
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
        return $onlyNonEmptyValues
                    ? array_filter(array_map('trim', $arr), 'strlen')
                    : array_map('trim', $arr);
    }
}