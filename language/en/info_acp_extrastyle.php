<?php

/**
* phpBB Extension - marttiphpbb Extra Style
* @copyright (c) 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [

	'ACP_MARTTIPHPBB_EXTRASTYLE'					=> 'Extra Style',
	'ACP_MARTTIPHPBB_EXTRASTYLE_EDIT'				=> 'Edit',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEETS'				=> 'Sheets',
]);
