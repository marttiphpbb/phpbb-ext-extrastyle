<?php
/**
* phpBB Extension - marttiphpbb Extra Style
* @copyright (c) 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\extrastyle\event;

use phpbb\event\data as event;
use phpbb\db\driver\factory as db;
use phpbb\config\config;
use phpbb\auth\auth;
use phpbb\language\language;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\log\log;
use phpbb\user;
use marttiphpbb\extrastyle\util\cnst;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class mcp_forum_listener implements EventSubscriberInterface
{
	/** @var db */
	private $db;

	/** @var string */
	private $topics_table;

	/** @var string */
	private $forums_table;

	/** @var config */
	private $config;

	/** @var auth */
	private $auth;

	/** @var language */
	private $language;

	/** @var request */
	private $request;

	/** @var template */
	private $template;

	/** @var string */
	private $phpbb_rooth_path;

	/** @var string */
	private $php_ext;

	/** @var log */
	private $log;

	/** @var user */
	private $user;

	/**
	 * @param db
	 * @param string
	 * @param string
	 * @param config
	 * @param auth
	 * @param language
	 * @param template
	 * @param string
	 * @param string
	 * @param log
	 * @param user
	*/
	public function __construct(
		db $db, 
		string $topics_table, 
		string $forums_table,
		config $config, 
		auth $auth,
		language $language,
		request $request,
		template $template,
		string $phpbb_root_path,
		string $php_ext,
		log $log,
		user $user
	)
	{
		$this->db = $db;
		$this->topics_table = $topics_table;
		$this->forums_table = $forums_table;
		$this->config = $config;
		$this->auth = $auth;
		$this->language = $language;
		$this->request = $request;
		$this->template = $template;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->log = $log;
		$this->user = $user;
	}

	static public function getSubscribedEvents()
	{
		return [
			'core.mcp_forum_view_before'
				=> 'core_mcp_forum_view_before',
			'core.modify_quickmod_actions'
				=> 'core_modify_quickmod_actions',
		];
	}

	public function core_mcp_forum_view_before(event $event)
	{
		$forum_info = $event['forum_info'];
		$forum_id = $forum_info['forum_id'];

		if (!$this->auth->acl_get('m_move', $forum_id))
		{
			return;
		}

		$_id = $this->config[cnst::CONFIG_EXTRASTYLE_ID];

		if (!$_id)
		{
			return;
		}

		$s_ = $_id && $_id == $forum_id;

		$this->template->assign_vars([
			'S_' . cnst::L . '_CAN_EXTRASTYLE' => !$s_,
			'S_' . cnst::L . '_CAN_RESTORE'	=> $s_,
		]);
	}

	public function core_modify_quickmod_actions(event $event)
	{
		$action = $event['action'];
		$quickmod = $event['quickmod'];

		if ($quickmod)
		{
			return;
		}

		if (!in_array($action,[
			cnst::EXTRASTYLE_ACTION, 
			cnst::RESTORE_ACTION,
		]))
		{
			return;
		}

		$this->language->add_lang('mcp', cnst::FOLDER);

		$_id = $this->config[cnst::CONFIG_EXTRASTYLE_ID];

		if (!$_id)
		{
			trigger_error(cnst::L_MCP . '_NO_EXTRASTYLE_SET');
		}

		$s_ = $action === cnst::EXTRASTYLE_ACTION;

		$topic_ids = $this->request->variable('topic_id_list', [0]);
		
		if (!count($topic_ids))
		{
			trigger_error('NO_TOPIC_SELECTED');
		}

		if ($s)
		{
			$this->archive($topic_ids);
		}

		$this->restore($topic_ids);
	}

	private function archive(array $topic_ids)
	{
		if ($this->request->variable('confirm', ''))
		{
			mcp_move_topic([$topic_id]);
		}
	
		$_id = $this->config[cnst::CONFIG_EXTRASTYLE_ID];

		// The operation is limited to one forum
		$forum_id = phpbb_check_ids($topic_ids, $this->topics_table, 'topic_id', ['m_move'], true);

		if ($forum_id === false)
		{
			return;
		}

		$redirect = $this->request->variable('redirect', build_url(['action', 'quickmod']));

		$s_hidden_fields = build_hidden_fields([
			'topic_id_list'	=> $topic_ids,
			'to_forum_id'	=> $_id,
			'f'				=> $forum_id,
			'action'		=> 'move',
			'redirect'		=> $redirect,
		]);

		$this->template->assign_vars([
			'S_CAN_LEAVE_SHADOW'	=> true,
		]);

		$message = cnst::L_MCP . '_EXTRASTYLE_TOPIC';
		$message .= count($topic_ids) === 1 ? '' : 'S';

		confirm_box(false, $message, $s_hidden_fields, cnst::TPL . 'confirm.html');
	}

	private function restore(array $topic_ids)
	{
		$viewforum = $this->phpbb_root_path . 'viewforum.' . $this->php_ext;
		$viewtopic = $this->phpbb_root_path . 'viewtopic.' . $this->php_ext;
		$_id = $this->config[cnst::CONFIG_EXTRASTYLE_ID];
	
		$omit_topics = $move_ids = [];
		$topic_titles = $topic_urls = [];
		$count_move_topics = 0;
				
		$sql = 'select topic_id, topic_title, 
				forum_id, ' . cnst::FROM_FORUM_ID_COLUMN . '
			from ' . $this->topics_table . '
			where ' . $this->db->sql_in_set('topic_id', $topic_ids);

		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			if ($row['forum_id'] != $_id)
			{
				$this->db->sql_freeresult($result);				
				trigger_error(cnst::L_MCP . '_RESTORE_TOPIC_NOT_IN_EXTRASTYLE');
			}

			$to_forum_id = $row[cnst::FROM_FORUM_ID_COLUMN];	
			$topic_id = $row['topic_id'];

			$forum_ids[$topic_id] = $row['forum_id'];
			$topic_titles[$topic_id] = $row['topic_title'];

			if (!$to_forum_id)
			{
				$omit_topics[] = $topic_id;
				continue;
			}

			$move_ids[$to_forum_id][] = $topic_id;
			$count_move_topics++;
		}

		$this->db->sql_freeresult($result);

		if (!count($move_ids))
		{
			trigger_error(cnst::L_MCP . '_NO_RESTORABLE_TOPICS');
		}

		$redirect = $this->request->variable('redirect', build_url(['action']));

		$s_hidden_fields = build_hidden_fields([
			'topic_id_list'	=> $topic_ids,
			'move_ids'		=> $move_ids,
			'action'		=> cnst::RESTORE_ACTION,
			'redirect'		=> $redirect,
		]);	

		if ($this->request->variable('confirm', ''))
		{
			$confirmed_move_ids = $this->request->variable('move_ids', [0 => [0]]);

			if ($confirmed_move_ids != $move_ids)
			{
				trigger_error(cnst::L_MCP . '_RESTORE_DATA_CHANGED');
			}			
		}
		
		$to_forum_ids = array_keys($move_ids);
		$forum_names = [];

		$sql = 'select forum_id, forum_name
			from ' . $this->forums_table . '
			where ' . $this->db->sql_in_set('forum_id', 
				array_merge($to_forum_ids, [$_id]));

		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$forum_names[$row['forum_id']] = $row['forum_name'];
		}

		$this->db->sql_freeresult($result);

		if (confirm_box(true))
		{
			foreach ($move_ids as $to_forum_id => $topic_ids)
			{
				move_topics($topic_ids, $to_forum_id, true);

				foreach ($topic_ids as $topic_id)
				{
					$this->log->add(
						'mod', 
						$this->user->data['user_id'], 
						$this->user->ip, 
						'LOG_MOVE', 
						false, 
						[
							'forum_id'		=> (int) $to_forum_id,
							'topic_id'		=> (int) $topic_id,
							$forum_names[$_id],
							$forum_names[$to_forum_id],
							(int) $_id,
							(int) $to_forum_id,
						]
					);
				}
			}

			$success_msg = cnst::L_MCP . '_TOPIC';
			$success_msg .= $count_move_topics > 1 ? 'S' : '';
			$success_msg .= '_RESTORED';
		}
		else
		{
			foreach ($move_ids as $to_forum_id => $topic_ids)
			{
				$forum_link = append_sid($viewforum, [
					'f'	=> $to_forum_id,
				]);
			
				$this->template->assign_block_vars('to_forums', [
					'FORUM_LINK'	=> $forum_link,
					'FORUM_NAME'	=> $forum_names[$to_forum_id],
				]);

				foreach($topic_ids as $topic_id)
				{
					$topic_link = append_sid($viewtopic, [
						't'	=> $topic_id,
						'f'	=> $forum_ids[$topic_id],
					]);

					$this->template->assign_block_vars('to_forums.topics', [
						'TOPIC_LINK'	=> $topic_link,
						'TOPIC_TITLE'	=> $topic_titles[$topic_id],
					]);
				}
			}

			foreach ($omit_topics as $topic_id)
			{
				$topic_link = append_sid($viewtopic, [
					't'	=> $topic_id,
					'f'	=> $forum_ids[$topic_id],
				]);

				$this->template->assign_block_vars('omit_topics', [
					'TOPIC_LINK'	=> $topic_link,
					'TOPIC_TITLE'	=> $topic_titles[$topic_id],
				]);
			}

			$msg = cnst::L_MCP . '_RESTORE_TOPIC';
			$msg .= $count_move_topics > 1 ? 'S' : '';

			confirm_box(false, $msg, $s_hidden_fields, cnst::TPL . 'confirm_topics_restore.html');
		}

		// the usual phpBB message
	
		$redirect = $this->request->variable('redirect', 'index.' . $this->php_ext);
		$redirect = reapply_sid($redirect);
	
		if (!$success_msg)
		{
			redirect($redirect);
		}
		else
		{
			meta_refresh(3, $redirect);

			$link__forum = append_sid($viewforum, ['f' => $_id]);
	
			$message = $this->language->lang($success_msg);
			$message .= '<br /><br />';
			$message .= sprintf($this->language->lang('RETURN_PAGE'), '<a href="' . $redirect . '">', '</a>');
			$message .= '<br /><br />';
			$message .= sprintf($this->language->lang(cnst::L_MCP . '_RETURN_EXTRASTYLE_FORUM'), '<a href="' . $link__forum . '">', '</a>');
	
			trigger_error($message);
		}
	}
}