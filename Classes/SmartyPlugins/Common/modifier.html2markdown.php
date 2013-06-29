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
 */
function smarty_modifier_html2markdown($content)
{
    return html2markdown($content);
}
