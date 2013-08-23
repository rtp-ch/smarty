<?php

class Tx_Smarty_SysPlugins_DotNotationFilter
{
    /**
     * Creates a unique string from the id smarty has assigned
     * to the template.
     *
     * @param Smarty_Internal_Template $template
     * @return string
     */
    private static function getTemplateId(Smarty_Internal_Template $template)
    {
        reset($template->properties['file_dependency']);
        return '___' . sha1(key($template->properties['file_dependency'])) . '___';
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

        // Regex pattern matches dot notations inside delimiters
        $tsPattern = '%(\s+\b(?<!$)([\w]+[.]{1}[\w]+)+\s*?=)(?=[^' . $rDel . '|' . $lDel . ']*?' . $rDel . ')%';
        if (preg_match_all($tsPattern, $tplSource, $tsParams)) {

            // Gets the string which will be used to replace the dots in typoscript notations
            $templateId = self::getTemplateId($template);

            // Replaces all the dots in the typoscript notation with a unique id.
            $tsParamsModified = str_replace('.', $templateId, $tsParams[1]);

            // Replaces the typoscript notations in the template with their
            // modified versions which have dots replaced.
            $tplSource = str_replace($tsParams[1], $tsParamsModified, $tplSource);
        }

        // Return the source to the compiler
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
