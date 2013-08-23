<?php

/**
 * Smarty plugin "markdown2html"
 * -------------------------------------------------------------
 * File:    modifier.markdown2html.php
 * Type:    modifier
 * Name:    Markdown
 * Version: 1.0
 * Author:  Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Uses PHP Markdown (http://michelf.ca/projects/php-markdown/) to convert markdown to HTML
 * Example: {$var|markdown2html}
 * -------------------------------------------------------------
 *
 * @param $content
 * @return mixed
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
//@codingStandardsIgnoreStart
function smarty_modifier_markdown2html($content)
{
//@codingStandardsIgnoreEnd
    return \Michelf\Markdown::defaultTransform($content);
}
