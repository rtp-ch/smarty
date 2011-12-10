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
 * @copyright     2007 Rueegg Tuck Partner GmbH
 * @author         Simon Tuck <stu@rtpartner.ch>
 * @link         http://www.rtpartner.ch/
 * @package     Smarty (smarty)
 **/



class Tx_Smarty_Utility_Scalar
{
    /**
     * Converts strings like "off" or "yes" to equivalent boolean values
     *
     * @param $string 
     * @return mixed
     */
    public function booleanize($string)
    {
        $bool = $string;
        if (is_scalar($string)) {
            if (preg_match("/^(on|true|yes)$/i", trim($string))) {
                $bool = true;
            } elseif (preg_match("/^(off|false|no)$/i", trim($string))) {
                $bool = false;
            }
        }
        return $bool;
    }
}