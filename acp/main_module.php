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
		global $phpbb_container;

		$request = $phpbb_container->get('request');
		$template = $phpbb_container->get('template');
		$config = $phpbb_container->get('config');
		$cache = $phpbb_container->get('cache');
		$language = $phpbb_container->get('language');
		$user = $phpbb_container->get('user');
		$ext_manager = $phpbb_container->get('ext.manager');
		

//		$phpbb_root_path = $phpbb_container->getParameter('core.root_path');
	
		$language->add_lang('acp', cnst::FOLDER);
		add_form_key(cnst::FOLDER);

//		$extrastyle_directory = new extrastyle_directory($user, $phpbb_root_path);

//		$filenames = $extrastyle_directory->get_filenames();

		switch($mode)
		{
			case 'edit':
				$this->tpl_name = 'edit';
				$this->page_title = $language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_EDIT');

				$file =	$request->variable('filename', '', true);
		
				if ($request->is_set_post('save'))
				{

					$data	= utf8_normalize_nfc($request->variable('sheet_content', '', true));
					$data	= htmlspecialchars_decode($data);

					if (confirm_box(true))
					{
//						$extrastyle_directory->save_to_file($file, $data);

						if ($save_purge_cache)
						{
							$config->increment('assets_version', 1);
							$cache->purge();
							trigger_error(sprintf($language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_SAVED_CACHE_PURGED'), $file) . adm_back_link($this->u_action . '&amp;filename='. $file));
						}

						trigger_error(sprintf($language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_SAVED'), $file) . adm_back_link($this->u_action . '&amp;filename=' . $file));
					}

					if (!in_array($file, $filenames))
					{
						trigger_error(sprintf($language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_DOES_NOT_EXIST'), $file) . adm_back_link($this->u_action), E_USER_WARNING);
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
//					reset($filenames);
//					$file = $file == '' ? current($filenames) : $file;
				}

//				$data = $extrastyle_directory->file_get_contents($file);

				$sheets = [];

				foreach ($sheets as $sheet)
				{
					$template->assign_block_vars('sheets', [
						'S_SELECTED'	=> $sheet_name === $sheet,
						'NAME'			=> $sheet,
					]);				
				}

				$codemirror_enabled = $ext_manager->is_enabled('marttiphpbb/codemirror');
		 
				if ($codemirror_enabled)
				{
					$load = $phpbb_container->get('marttiphpbb.codemirror.load');
					$load->set_mode('css');
				}

				$template->assign_vars([
					'EDITOR_ROWS'			=> $editor_rows,
					'SHEET_NAME'			=> $sheet_name,
					'SHEET_CONTENT'			=> utf8_htmlspecialchars($content),
				]);

				break;

			case 'sheets':

				$this->tpl_name = 'sheets';
				$this->page_title = $language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_SHEETS');

				$new_sheet = $request->variable('new_sheet', '');
				$sheet_to_delete = array_keys($request->variable('delete', array('' => '')));
				$sheet_to_delete = count($sheet_to_delete) ? $sheet_to_delete[0] : false;

				if ($request->is_set_post('create'))
				{
					if (!check_form_key(cnst::FOLDER))
					{
						trigger_error('FORM_INVALID');
					}

					if (!$new_sheet)
					{
						trigger_error($language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_NAME_EMPTY') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					if (in_array($new_sheet, $sheets))
					{
						trigger_error(sprintf($language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_ALREADY_EXISTS'), $new_sheet) . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$customcode_directory->create_file($new_sheet);

					trigger_error(sprintf($language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_CREATED'), $new_file) . adm_back_link($this->u_action));
				}

				if ($request->is_set_post('delete'))
				{
					if (!in_array($sheet_to_delete, $filenames))
					{
						trigger_error(sprintf($language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_DOES_NOT_EXIST'), $sheet_to_delete) . adm_back_link($this->u_action), E_USER_WARNING);
					}

					if (confirm_box(true))
					{
						$customcode_directory->delete_file($sheet_to_delete);

						trigger_error(sprintf($language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_DELETED'), $sheet_to_delete) . adm_back_link($this->u_action));
					}

					$s_hidden_fields = [
						'mode'		=> 'sheets',
						'delete'	=> [$sheet_to_delete => 1],
					];

					confirm_box(false, sprintf($user->lang('ACP_MARTTIPHPBB_EXTRASTYLE_DELETE_SHEET_CONFIRM'), $sheet_to_delete), build_hidden_fields($s_hidden_fields));
				}


				$u_edit = str_replace('mode=sheet', 'mode=edit', $this->u_action);

				foreach ($sheets as $sheet)
				{
					$template->assign_block_vars('sheets', [
						'NAME'					=> $sheet,
						'U_EDIT'				=> $u_edit . '&amp;sheet=' . $sheet,
						'SIZE'					=> $extrastyle_directory->get_size($sheet),
						'COMMENT'				=> $extrastyle_directory->get_comment($sheet),
						'DELETE_SHEET_NAME'		=> sprintf($language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_DELETE_FILE_NAME'), $filename),
					]);
				}

				break;
			
			case 'external_sheets':

				$this->tpl_name = 'external_sheets';
				$this->page_title = $language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_EXTERNAL_SHEETS');



//

				break;
		}

		$template->assign_var('U_ACTION', $this->u_action);		
	}
}
