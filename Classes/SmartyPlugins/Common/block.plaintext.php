<?php

/***************************************************************
 *  Copyright notice
 *
 *
 *    Created by Simon Tuck <stu@rtpartner.ch>
 *    Copyright (c) 2006-2007, Rueegg Tuck Partner GmbH (wwww.rtpartner.ch)
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
 *    @copyright     2006, 2007 Rueegg Tuck Partner GmbH
 *    @author     Simon Tuck <stu@rtpartner.ch>
 *    @link         http://www.rtpartner.ch/
 *    @package     Smarty (smarty)
 *
 ***************************************************************/

/**
 *
 * Smarty plugin "plaintext"
 * -------------------------------------------------------------
 * File:    block.plaintext.php
 * Type:    block
 * Name:    Plaintext
 * Version: 1.0
 * Author:  Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Turns HTML into plaintext using the html2text class
 * Example: {plaintext}
 *                This is a line of text
 *                This is another line of text
 *                But this will all end up on 1 line...
 *            {/plaintext}
 * Note:    By default multiple linebreaks are collapsed. To preserve linebreaks
 *             set the parameter 'newlines' to 'keep' (newlines="keep")
 * Note:    By default links are printed in plaintext. To append a list of links
 *             in the text to the end of the text block set the paramter 'links' to 'append' (links="append").
 *             To remove links from the text entirely set the parameter 'links' to 'strip' (links="strip")
 * -------------------------------------------------------------
 *
 **/

/**
 *
 * Smarty plugin "plaintext"
 * -------------------------------------------------------------
 * File:    block.plaintext.php
 * Type:    block
 * Name:    Plaintext
 * Version: 1.0
 * Author:  Simon Tuck <stu@rtp.ch>, Rueegg Tuck Partner GmbH
 * Purpose: Turns HTML into plaintext using the html2text class
 * Example: {plaintext}
 *                This is a line of text
 *                This is another line of text
 *                But this will all end up on 1 line...
 *            {/plaintext}
 * Note:    By default multiple linebreaks are collapsed. To preserve linebreaks
 *             set the parameter 'newlines' to 'keep' (newlines="keep")
 * Note:    By default links are printed in plaintext. To append a list of links
 *             in the text to the end of the text block set the paramter 'links' to 'append' (links="append").
 *             To remove links from the text entirely set the parameter 'links' to 'strip' (links="strip")
 * -------------------------------------------------------------
 *
 * @param $params
 * @param $content
 * @param Smarty_Internal_Template $template
 * @param $repeat
 * @return string
 */
    function smarty_block_plaintext($params, $content, Smarty_Internal_Template $template, &$repeat)
    {
        if (!$repeat) {
            // An instance of the modified html2text class by Jon Abernathy <jon@chuggnutt.com>
            $textConversion = new ux_html2text($content);

            // Set the absolute site path
            $textConversion->set_base_url(t3lib_div::getIndpEnv('TYPO3_SITE_URL'));

            // Sets behaviour regarding link collection and line stripping from plugin params
            $params = array_change_key_case($params, CASE_LOWER);
            $textConversion->setLinkBehaviour($params['links'])->setLineBehaviour($params['newlines']);

            // Performs plaintext conversion and returns result
            return $textConversion->get_text();
        }
    }
