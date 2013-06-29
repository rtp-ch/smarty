<?php

/**
 * Smarty plugin "markdown2html"
 * -------------------------------------------------------------
 * File:    block.markdown2html.php
 * Type:    block
 * Name:    Markdown
 * Version: 1.0
 * Author:  Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Uses PHP Markdown (http://michelf.ca/projects/php-markdown/) to convert markdown to HTML
 * Example: {markdown2html}
 *              Praesent commodo cursus magna, vel scelerisque nisl consectetur et.
 *              Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis,
 *              est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.
 *          {/markdown2html}
 * -------------------------------------------------------------
 *
 * @param $params
 * @param $content
 * @param Smarty_Internal_Template $template
 * @param $repeat
 * @return string
 */
function smarty_block_markdown2html($params, $content, Smarty_Internal_Template $template, &$repeat)
{
    if (!$repeat) {
        return \Michelf\Markdown::defaultTransform($content);
    }
}