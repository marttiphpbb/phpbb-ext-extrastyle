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

	'ACP_MARTTIPHPBB_EXTRASTYLE_CREATE_FILE'				=> 'Create file',
	'ACP_MARTTIPHPBB_EXTRASTYLE_DELETE'						=> 'Delete',
	'ACP_MARTTIPHPBB_EXTRASTYLE_DELETE_FILE_NAME'			=> 'Delete %s',
	'ACP_MARTTIPHPBB_EXTRASTYLE_FILES_EXPLAIN'				=> 'Files directly included with template events %1$s cannot be deleted. All files reside at directory %2$s.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_FILE_SIZE'					=> 'Size',
	'ACP_MARTTIPHPBB_EXTRASTYLE_FILE_NAME'					=> 'Name',
	'ACP_MARTTIPHPBB_EXTRASTYLE_FILE_COMMENT'				=> 'Comment',
	'ACP_MARTTIPHPBB_EXTRASTYLE_FILE'						=> 'File',
	'ACP_MARTTIPHPBB_EXTRASTYLE_EDITOR_ROWS'				=> 'Editor rows',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SAVE_CONFIRM'				=> 'Do you want to save the file %s?',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SAVE'						=> 'Save',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SAVE_PURGE_CACHE'			=> 'Save and purge the cache',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SAVE_PURGE_CACHE_CONFIRM'	=> 'Do you want to save the file %s and purge the cache?',
	'ACP_MARTTIPHPBB_EXTRASTYLE_FILE_SAVED'					=> 'The file %s has been saved successfully!',
	'ACP_MARTTIPHPBB_EXTRASTYLE_FILE_SAVED_CACHE_PURGED'	=> 'The file %s has been saved and the cache has been purged successfully!',
	'ACP_MARTTIPHPBB_EXTRASTYLE_FILE_CREATED'				=> 'The file %s has been created.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_FILENAME_EMPTY'				=> 'The filename was empty.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_FILE_NOT_CREATED'			=> 'The file %s could not be created.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_FILE_ALREADY_EXISTS'		=> 'The file %s already exists.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_DELETE_FILE_CONFIRM'		=> 'Delete file %s ?',
	'ACP_MARTTIPHPBB_EXTRASTYLE_FILE_DELETED'				=> 'The file %s has been deleted.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_FILE_DOES_NOT_EXIST'		=> 'The file %s does not exist.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_FILE_NOT_DELETED'			=> 'Failed to delete file %s.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_FILE_NOT_OPENED'			=> 'Failed to open file %s.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_FILE_NOT_CLOSED'			=> 'Failed to close file %s.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_FILE_WRITE_FAIL'			=> 'Failed to write to file %s.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_FILE_READ_FAIL'				=> 'Failed to read from file %s.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_FILE_TYPE_FAIL'				=> 'Failed to get the file type of %s.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_FILE_SIZE_FAIL'				=> 'Failed to get the file size of %s.',
	'ACP_MARTTIPHPBB_EXTRASTYLE_EVENT_FILE_INDICATOR'		=> '(E)',
	'ACP_MARTTIPHPBB_EXTRASTYLE_SHOW_TEMPLATE_EVENTS_LOCATIONS'	=> 'Show Custom Code template events locations',
	'ACP_MARTTIPHPBB_EXTRASTYLE_HIDE_TEMPLATE_EVENTS_LOCATIONS'	=> 'Hide Custom Code template events locations',
	'ACP_MARTTIPHPBB_EXTRASTYLE_DIRECTORY_NOT_CREATED'		=> 'Failed to create the directory %s',
	'ACP_MARTTIPHPBB_EXTRASTYLE_DIRECTORY_NOT_DELETED'		=> 'Failed to delete the directory %s',
	'ACP_MARTTIPHPBB_EXTRASTYLE_DIRECTORY_LIST_FAIL'		=> 'Failed to list content of directory %s',
	
]);
