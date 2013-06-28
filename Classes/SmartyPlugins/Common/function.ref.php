<?php

/**
 * Smarty plugin "ref"
 * -------------------------------------------------------------
 * File:    function.ref.php
 * Type:    function
 * Name:    ref
 * Version: 1.0
 * Author:    Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: REF, or r() is a nicer alternative to PHP's print_r / var_dump functions!
 * link: https://github.com/digitalnature/php-ref
 * Example: {ref}
 * -------------------------------------------------------------
 *
 * @param $params
 * @param Smarty_Internal_Template $template
 * @return string
 */
function smarty_function_ref($params, Smarty_Internal_Template $template)
{
    $params = array_change_key_case($params, CASE_LOWER);
    $format = isset($params['format']) && $params['format'] === 'text' ? 'text' : 'html';
    $expandDepth = isset($params['expanddepth']) && is_int($params['expanddepth']) ? $params['expanddepth'] : 1;
    $ref = new ref($format, $expandDepth);

    $debugVars = Smarty_Internal_Debug::get_debug_vars($template->smarty);

    $tplVars = $debugVars->tpl_vars;
    ksort($tplVars);

    $configVars = $debugVars->config_vars;
    ksort($configVars);

    $configVars['plugins_dir'] = $template->smarty->getPluginsDir();
    $configVars['language_file'] = $template->smarty->getLanguageFile();

    $output = '';
    foreach ($tplVars as $name => $var) {
        $output .= $ref->query($var, $name);
    }
    foreach ($configVars as $name => $var) {
        $output .= $ref->query($var, $name);
    }

    return $output;
}
