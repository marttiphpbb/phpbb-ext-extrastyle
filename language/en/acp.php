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

	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_CREATE'
		=> 'Create sheet',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_DELETE'
		=> 'Delete',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_DELETE_NAME'
		=> 'Delete %s',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_SIZE'
		=> 'Size',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_NAME'
		=> 'Name',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_NAME_RULES'			=>
		'The name must begin with a lowercase alphabetical character and can contain only
		lowercase alphanumerical characters and enclosed dashes.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET'
		=> 'Sheet',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SAVE_CONFIRM'
		=> 'Do you want to save the sheet %s?',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SAVE'
		=> 'Save',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_SAVED'
		=> 'The sheet %s has been saved successfully!',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_NAME_EMPTY'
		=> 'The sheet name was empty.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_NAME_ALREADY_EXISTS'
		=> 'The sheet name %s already exists.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_NAME_INVALID_FORMAT'
		=> 'The sheet name %s is an invalid format.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_DELETE_CONFIRM'
		=> 'Delete sheet %s ?',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_DELETED'
		=> 'The sheet %s has been deleted.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_DOES_NOT_EXIST'
		=> 'The sheet %s does not exist.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_NO_SHEETS'
		=> 'There are no extra style sheets to edit yet. You can create one in the page <a href="%s">"sheets"</a>.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SCRIPT_NAMES'
		=> 'Script names',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SCRIPT_NAMES_EXPLAIN'
		=> 'A comma separated list of script names (without the .php extension)
		to define when this style sheet should be loaded. i.e. viewforum, viewtopic, index.',
]);
