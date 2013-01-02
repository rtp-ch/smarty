<?php

class Tx_Smarty_Utility_Scalar
{

    /**
     * Casts strings like "off" or "yes" which represent boolean values
     * to their equivalent boolean values
     *
     * @param $string
     * @return mixed
     */
    public static function booleanize($string)
    {
        if (is_string($string)) {
            if (preg_match("/^(on|true|yes)$/i", trim($string))) {
                $string = true;

            } elseif (preg_match("/^(off|false|no)$/i", trim($string))) {
                $string = false;
            }
        }

        return $string;
    }
}