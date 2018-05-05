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

	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_CREATE'				=> 'Create sheet',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_DELETE'				=> 'Delete',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_DELETE_BTN'			=> 'x',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_DELETE_NAME'			=> 'Delete %s',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEETS_EXPLAIN'				=> '--explain--',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_SIZE'					=> 'Size',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_NAME'					=> 'Name',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_DESCRIPTION'			=> 'Description',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET'						=> 'Sheet',
	'ACP_MARTTIPHPBB_EXTRASTYLE_EDITOR_ROWS'				=> 'Editor rows',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SAVE_CONFIRM'				=> 'Do you want to save the sheet %s?',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SAVE'						=> 'Save',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SAVE_PURGE_CACHE_CONFIRM'	=> 'Do you want to save the sheet %s and purge the cache?',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_SAVED'				=> 'The sheet %s has been saved successfully!',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_CREATED'				=> 'The sheet %s has been created.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_NAME_EMPTY'			=> 'The sheet name was empty.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_NOT_CREATED'			=> 'The sheet %s could not be created.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_ALREADY_EXISTS'		=> 'The sheet %s already exists.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_DELETE_CONFIRM'		=> 'Delete sheet %s ?',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_DELETED'				=> 'The sheet %s has been deleted.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_DOES_NOT_EXIST'		=> 'The sheet %s does not exist.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_NOT_DELETED'			=> 'Failed to delete sheet %s.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_NOT_OPENED'			=> 'Failed to open sheet %s.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_NOT_CLOSED'			=> 'Failed to close sheet %s.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_WRITE_FAIL'			=> 'Failed to write to sheet %s.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_READ_FAIL'				=> 'Failed to read from sheet %s.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_TYPE_FAIL'				=> 'Failed to get the sheet type of %s.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_SIZE_FAIL'				=> 'Failed to get the sheet size of %s.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHOW_TEMPLATE_EVENTS_LOCATIONS'	=> 'Show Custom Code template events locations',
	'ACP_MARTTIPHPBB_EXTRASTYLE_HIDE_TEMPLATE_EVENTS_LOCATIONS'	=> 'Hide Custom Code template events locations',	
]);
