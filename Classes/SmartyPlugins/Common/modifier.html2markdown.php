<?php

/**
 * Smarty plugin "html2markdown"
 * -------------------------------------------------------------
 * File:    modifier.html2markdown.php
 * Type:    modifier
 * Name:    HTML to Markdown
 * Version: 1.0
 * Author:  Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Turns HTML into markdown using HTML_Parser::get_markdown by [@nickcernis](http://twitter.com/nickcernis)
 * Example: {$var|html2markdown}
 * -------------------------------------------------------------
 *
 * @param $content
 * @return mixed
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
//@codingStandardsIgnoreStart
function smarty_modifier_html2markdown($content)
{
//@codingStandardsIgnoreEnd
    return new HTML_To_Markdown($content);
}
