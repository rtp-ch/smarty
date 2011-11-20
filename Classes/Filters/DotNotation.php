<?php

/***************************************************************
 *  Copyright notice
 *
 *
 *	Created by Simon Tuck <stu@rtpartner.ch>
 *	Copyright (c) 2006-2007, Rueegg Tuck Partner GmbH (wwww.rtpartner.ch)
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
 *
 *	@copyright 	2006, 2007 Rueegg Tuck Partner GmbH
 *	@author 	Simon Tuck <stu@rtpartner.ch>
 *	@link 		http://www.rtpartner.ch/
 *	@package 	Smarty (smarty)
 *
 ***************************************************************/


class Tx_Smarty_Filters_DotNotation
{
    /**
     *
     * Creates a unique string from the id smarty has assigned
     * to the template.
     *
     * @static
     * @param Smarty_Internal_Template $template
     * @return string
     */
    private static function getTemplateId(Smarty_Internal_Template $template)
    {
        // TODO: What happens when there is no actual file?
        reset($template->properties[file_dependency]);
        return '___' . sha1(key($template->properties[file_dependency])) . '___';
    }

    /**
     * 
     * Removes all TypoScript styled paramaters in functions, modifiers etc. so that, for example:
     * {function some.setting=$foo.bar another.setting.or.value=$hello[world].1} becomes:
     * {function some.setting=$fooXXXXXXbar anotherXXXXXXsettingXXXXXXorXXXXXXvalue=$hello[world].1}
     * where XXXXXX is a unique string created from the template id.
     * This is a hack! In particular, collisions will occur if the same unique string is used in
     * a template. However, due to the fact that smarty cannot handle dots in parameters, this
     * is a neccesary evil.
     *
     * @param $tplSource
     * @param Smarty_Internal_Template $template
     * @return mixed
     */
    public static function pre($tplSource, Smarty_Internal_Template $template)
    {
        // Gets the template delimiters to use in the regex pattern
        $lDel = preg_quote($template->left_delimiter, '%');
        $rDel = preg_quote($template->right_delimiter, '%');

        // Remove any text from the source which is enclosed in smarty literals, i.e. {literal}...{/literal}.
        // Literal text blocks (if found) are replaced with a placeholder and reinsterted into the text after
        // the prefilter action.
        // TODO: Is this necessary? The effects of regexing literals should always be reversed.
        $literalPattern = '%' . $lDel . 'literal' . $rDel . '.*?' . $lDel . '/literal' . $rDel . '%si';
        if(preg_match_all($literalPattern, $tplSource, $literals, PREG_PATTERN_ORDER)) {
            for( $n = count($literals[0]), $i = 0; $i < $n; $i++ ) {
                $placeHolders[$i] = '<@>' . uniqid('LITERAL_', true) . '<@>';
            }
            $tplSource = str_replace($literals[0], $placeHolders, $tplSource);
        };

        // Regex pattern matches dot notations inside delimiters
        $tsPattern = '%(\b(?<!$)([\w]+[.]{1}[\w]+)+\s*?=)(?=[^' . $rDel . '|' . $lDel . ']*?' . $rDel . ')%';
        if (preg_match_all($tsPattern, $tplSource, $tsParams)) {

            // Gets the string which will be used to replace the dots in typoscript notations
            $templateId = self::getTemplateId($template);

            // Replaces all the dots in the typoscript notation with a unique id.
            $tsParamsModified = str_replace('.', $templateId, $tsParams[1]);

            // Replaces the typoscript notations in the template with their
            // modified versions which have dots replaced.
            $tplSource = str_replace($tsParams[1], $tsParamsModified, $tplSource);
        }

        // Reinserts the literal textblocks
        // TODO: See above...
        if($literals) {
            $tplSource = str_replace($placeHolders, $literals[0], $tplSource);
        }

        // Return the tpl_source to the compiler
        return $tplSource;
    }

    /**
     *
     * Reverses the replacements of the dot notation done in the pre filter.
     *
     * @param $tplSource
     * @param Smarty_Internal_Template $template
     * @return mixed
     */
    public static function post($tplSource, Smarty_Internal_Template $template)
    {
        return str_replace(self::getTemplateId($template), '.', $tplSource);
    }
}