<?php

/**
 * Smarty plugin "truncate_words"
 * -------------------------------------------------------------
 * File:    modifier.truncate_words.php
 * Type:    modifier
 * Name:    Truncate Words
 * Version: 1.0
 * Author:  Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Returns a number of words from a text (as opposed to truncate which returns a fixed number of characters)
 * Example: {$content|truncate_words:10:",":","}
 * 			Returns a comma seperated list of the first 10 words of a comma seperated list of words.
 * 			e.g. useful for truncating a list of keywords.
 * -------------------------------------------------------------
 *
 * @param $string
 * @param int $noOfWords
 * @param string $delimiter
 * @param string $glue
 * @param string $replace
 * @return string
 */
function smarty_modifier_truncate_words($string, $noOfWords = 0, $delimiter = ' ', $glue = ' ', $replace = '') {

    $words = Tx_Smarty_Utility_Array::trimExplode($string, $delimiter);
    if ($words) {

        $limit = intval($noOfWords);
        if ($limit) {
            return implode($glue, array_slice($words, 0, $limit)).$replace;

        } else {
            return implode($glue, $words);
        }
    }

    return $string;
}

