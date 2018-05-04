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

	'MCP_MARTTIPHPBB_EXTRASTYLE_NO_EXTRASTYLE_SET'
		=> 'No Extra Style has been set in the ACP',
	'MCP_MARTTIPHPBB_EXTRASTYLE_TOPIC_NOT_RESTORABLE'
		=> 'The topic can not be restored from  because the original forum is not known.',
	'MCP_MARTTIPHPBB_EXTRASTYLE_NO_RESTORABLE_TOPICS'
		=> 'No restorable topics have been selected.',
	'MCP_FORUM_MARTTIPHPBB_EXTRASTYLE_EXTRASTYLE'		
		=> '',
	'MCP_FORUM_MARTTIPHPBB_EXTRASTYLE_RESTORE'		
		=> 'Restore from ',
	'MCP_MARTTIPHPBB_EXTRASTYLE_EXTRASTYLE_TOPIC'		
		=> ' topic',
	'MCP_MARTTIPHPBB_EXTRASTYLE_EXTRASTYLE_TOPICS'		
		=> ' topics',
	'MCP_MARTTIPHPBB_EXTRASTYLE_RESTORE_TOPIC'		
		=> 'Restore topic from ',
	'MCP_MARTTIPHPBB_EXTRASTYLE_RESTORE_TOPICS'		
		=> 'Restore topics from ',
	'MCP_MARTTIPHPBB_EXTRASTYLE_EXTRASTYLE_TOPIC_CONFIRM'
		=> 'Do you want to move the topic to the  forum?',
	'MCP_MARTTIPHPBB_EXTRASTYLE_EXTRASTYLE_TOPICS_CONFIRM'
		=> 'Do you want to move the topics to the  forum?',		
	'MCP_MARTTIPHPBB_EXTRASTYLE_RESTORE_TOPIC_CONFIRM'
		=> 'Do you want to restore the d topic back to its original forum?',
	'MCP_MARTTIPHPBB_EXTRASTYLE_RESTORE_TOPICS_CONFIRM'
		=> 'Do you want to restore the d topics back to their original forum?',
	'MCP_MARTTIPHPBB_EXTRASTYLE_RETURN_EXTRASTYLE_FORUM'
		=> 'Return to the %s forum%s.',
	'MCP_MARTTIPHPBB_EXTRASTYLE_RESTORE_DATA_CHANGED'
		=> 'The restore could not be performed, because data changed for at least one topic.',
	'MCP_MARTTIPHPBB_EXTRASTYLE_TOPIC_RESTORED'
		=> 'The topic has been restored from  to its original forum.',	
	'MCP_MARTTIPHPBB_EXTRASTYLE_TOPICS_RESTORED'
		=> 'The topics have been restored from  to their original forum.',
	'MCP_MARTTIPHPBB_EXTRASTYLE_RESTORE_TOPIC_OMITTED'
		=> 'This topic cannot be restored from  (the original forum is unknown):',
	'MCP_MARTTIPHPBB_EXTRASTYLE_RESTORE_TOPICS_OMITTED'
		=> 'These topics cannot be restored from  (the original forum is unknown):',
	'MCP_MARTTIPHPBB_EXTRASTYLE_RESTORE_TOPIC_NOT_IN_EXTRASTYLE'
		=> 'Error: one topic to be restored is not in the  forum.',
	'MCP_MARTTIPHPBB_EXTRASTYLE_TOPIC_RESTORE_TO_FORUM'
		=> 'This topic will be restored to <a href="%1$s">%2$s</a>:',
	'MCP_MARTTIPHPBB_EXTRASTYLE_TOPICS_RESTORE_TO_FORUM'
		=> 'These topics will be restored to <a href="%1$s">%2$s</a>:',
]);
