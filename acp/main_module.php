<?php
/**
* phpBB Extension - marttiphpbb extrastyle
* @copyright (c) 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\extrastyle\acp;

use marttiphpbb\extrastyle\util\cnst;
use marttiphpbb\extrastyle\model\extrastyle_directory;

class main_module
{
	public $u_action;

	function main($id, $mode)
	{
		global $phpbb_container, $phpbb_root_path, $phpbb_admin_path, $phpEx;

		$request = $phpbb_container->get('request');
		$template = $phpbb_container->get('template');
		$config = $phpbb_container->get('config');
		$cache = $phpbb_container->get('cache');
		$language = $phpbb_container->get('language');
		$user = $phpbb_container->get('user');
	
		$language->add_lang('acp', cnst::FOLDER);
		add_form_key(cnst::FOLDER);

		$extrastyle_directory = new extrastyle_directory($user, $phpbb_root_path);

		$filenames = $extrastyle_directory->get_filenames();

		switch($mode)
		{
			case 'edit':
				$this->tpl_name = 'edit';
				$this->page_title = $language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_EDIT');

				$file =	$request->variable('filename', '', true);
				$editor_rows = max(5, min(999, $request->variable('editor_rows', 8)));

				$save = $request->is_set_post('save');
				$save_purge_cache = $request->is_set_post('save_purge_cache');

				if ($save || $save_purge_cache)
				{

					$data	= utf8_normalize_nfc($request->variable('file_data', '', true));
					$data	= htmlspecialchars_decode($data);

					if (confirm_box(true))
					{
						$extrastyle_directory->save_to_file($file, $data);

						if ($save_purge_cache)
						{
							$config->increment('assets_version', 1);
							$cache->purge();
							trigger_error(sprintf($language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_FILE_SAVED_CACHE_PURGED'), $file) . adm_back_link($this->u_action . '&amp;filename='. $file));
						}

						trigger_error(sprintf($language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_FILE_SAVED'), $file) . adm_back_link($this->u_action . '&amp;filename=' . $file));
					}

					if (!in_array($file, $filenames))
					{
						trigger_error(sprintf($language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_FILE_DOES_NOT_EXIST'), $file) . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$confirm_message = ($save_purge_cache) ? 'ACP_MARTTIPHPBB_EXTRASTYLE_SAVE_PURGE_CACHE_CONFIRM' : 'ACP_MARTTIPHPBB_EXTRASTYLE_SAVE_CONFIRM';

					$s_hidden_fields = [
						'filename'			=> $file,
						'file_data' 		=> utf8_htmlspecialchars($data),
						'mode'				=> 'edit',
					];

					$submit_field = $save_purge_cache ? 'save_purge_cache' : 'save';
					$s_hidden_fields[$submit_field] = 1;

					confirm_box(false, sprintf($language->lang($confirm_message), $file), build_hidden_fields($s_hidden_fields));
				}
				else
				{
					reset($filenames);
					$file = $file == '' ? current($filenames) : $file;
				}

				$data = $extrastyle_directory->file_get_contents($file);

				$options = '';

				$event_file_indicator = $language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_EVENT_FILE_INDICATOR');

				foreach($filenames as $filename)
				{
					$options .= '<option value="' . $filename . '"';
					$options .= ($filename == $file) ? ' selected="selected"' : '';
					$options .= '>' . $filename;
					$options .= $extrastyle_directory->is_event($filename) ? ' ' . $event_file_indicator : '';
					$options .= '</option>';
				}

				$template->assign_block_vars('files', [
					'S_SELECTED'	=> $filename === $file,
				]);

				$template->assign_vars([
					'EDITOR_ROWS'			=> $editor_rows,
					'FILENAME'				=> $file,
					'S_IS_EVENT'			=> $extrastyle_directory->is_event($file),
					'FILE_DATA'				=> utf8_htmlspecialchars($data),
					'S_FILENAMES'			=> $options,
				]);

				break;

			case 'sheets':

				$this->tpl_name = 'sheets';
				$this->page_title = $language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_SHEETS');



				$u_edit = str_replace('mode=files', 'mode=edit', $this->u_action);

				foreach ($filenames as $filename)
				{
					$template->assign_block_vars('sheets', array(
						'S_IS_EVENT'			=> $extrastyle_directory->is_event($filename),
						'NAME'					=> $filename,
						'U_EDIT'				=> $u_edit . '&amp;filename=' . $filename,
						'SIZE'					=> $extrastyle_directory->get_filesize($filename),
						'COMMENT'				=> $extrastyle_directory->get_comment($filename),
						'DELETE_FILE_NAME'		=> sprintf($language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_DELETE_FILE_NAME'), $filename),
					));
				}

				break;
		}

		$template->assign_var('U_ACTION', $this->u_action);		
	}
}
