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
		$language = $phpbb_container->get('language');
		$ext_manager = $phpbb_container->get('ext.manager');
		$store = $phpbb_container->get('marttiphpbb.extrastyle.service.store');

		$language->add_lang('acp', cnst::FOLDER);
		add_form_key(cnst::FOLDER);

		switch($mode)
		{
			case 'edit':
	
				$this->tpl_name = 'edit';
				$this->page_title = $language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_EDIT');

				$request_sheet_name = $request->variable('sheet_name', '', true);
				$sheets = $store->get_all_sheets();

				if (!$sheets)
				{
					$u_sheets = str_replace('mode=edit', 'mode=sheets', $this->u_action);
					trigger_error($language->lang(cnst::L_ACP . '_NO_SHEETS', $u_sheets));
				}

				if ($request_sheet_name === '')
				{
					end($sheets);
					$request_sheet_name = key($sheets);
				}

				if (!isset($sheets[$request_sheet_name]))
				{
					trigger_error($language->lang(
						cnst::L_ACP . '_SHEET_DOES_NOT_EXIST', 
							$request_sheet_name),
								E_USER_WARNING);					
				}
				
				if ($request->is_set_post('save'))
				{
					$sheet_name = $request->variable('sheet_name', '');
					$sheet_content = $request->variable('sheet_content', '', true);
					$sheet_content = html_entity_decode($sheet_content, ENT_QUOTES | ENT_HTML5);	
					$script_names = $request->variable('script_names', '');
					$script_names = strtolower($script_names);

					if (confirm_box(true))
					{
						$script_names = str_replace([' ', '.php'], '', $script_names);
						$store->set_sheet($sheet_name, crc32($sheet_content), $script_names, $sheet_content);			
						trigger_error(sprintf($language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_SAVED'), $file) . adm_back_link($this->u_action . '&amp;filename=' . $file));
					}

					$s_hidden_fields = [
						'sheet_name'	=> $sheet_name,
						'sheet_content' => $sheet_content,
						'script_names'	=> $script_names,
						'mode'			=> 'edit',
						'save'			=> 1,
					];

					confirm_box(false, sprintf($language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_SAVE_CONFIRM'), $sheet_name), build_hidden_fields($s_hidden_fields));
				}

				foreach ($sheets as $sheet_name => $data)
				{
					$template->assign_block_vars('sheets', [
						'S_SELECTED'	=> $request_sheet_name === $sheet_name,
						'NAME'			=> $sheet_name,
					]);				
				}

				$codemirror_enabled = $ext_manager->is_enabled('marttiphpbb/codemirror');
		 
				if ($codemirror_enabled)
				{
					$load = $phpbb_container->get('marttiphpbb.codemirror.load');
					$load->set_mode('css');
				}

				$query = [];
				parse_str(parse_url(html_entity_decode($this->u_action), PHP_URL_QUERY), $query);

				$s_hidden_fields = [
					'sheet_name'	=> $request_sheet_name,
				];

				$template->assign_vars([
					'S_HIDDEN_FIELDS'		=> build_hidden_fields($s_hidden_fields),
					'SHEET_NAME'			=> $request_sheet_name,
					'SCRIPT_NAMES'			=> $sheets[$request_sheet_name]['script_names'],
					'SHEET_CONTENT'			=> $sheets[$request_sheet_name]['content'],
					'S_HIDDEN_FIELDS_GET'	=> build_hidden_fields($query),
				]);

			break;

			case 'sheets':

				$this->tpl_name = 'sheets';
				$this->page_title = $language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_SHEETS');

				$sheets = $store->get_all_sheets(); 

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
						trigger_error(
							$language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_NAME_EMPTY') . 
								adm_back_link($this->u_action), 
									E_USER_WARNING);
					}

					if (in_array($new_sheet, array_keys($sheets)))
					{
						trigger_error(sprintf(
							$language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_NAME_ALREADY_EXISTS'), 
								$new_sheet) . 
									adm_back_link($this->u_action), E_USER_WARNING);
					}

					if (preg_match('/^[a-z][a-z0-9-]*[a-z0-9]$/', $new_sheet) !== 1 
						|| strpos($new_sheet, '--') !== false)
					{
						trigger_error(sprintf(
							$language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_NAME_INVALID_FORMAT'), 
								$new_sheet) . 
									adm_back_link($this->u_action), E_USER_WARNING);						
					}

					$store->set_sheet($new_sheet, crc32(''), '', '');

					$u_edit = str_replace('mode=sheets', 'mode=edit&sheet_name=' . $new_sheet, $this->u_action);
					redirect($u_edit);
				}

				if ($request->is_set_post('delete'))
				{
					if (!in_array($sheet_to_delete, array_keys($sheets)))
					{
						trigger_error(sprintf(
							$language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_DOES_NOT_EXIST'), 
								$sheet_to_delete) . adm_back_link($this->u_action), 
									E_USER_WARNING);
					}

					if (confirm_box(true))
					{
						$store->delete_sheet($sheet_to_delete);

						trigger_error(sprintf(
							$language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_DELETED'), 
								$sheet_to_delete) . adm_back_link($this->u_action));
					}

					$s_hidden_fields = [
						'mode'		=> 'sheets',
						'delete'	=> [$sheet_to_delete => 1],
					];

					confirm_box(false, 
						sprintf($language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_DELETE_CONFIRM'), 
							$sheet_to_delete), build_hidden_fields($s_hidden_fields));
				}

				foreach ($sheets as $sheet_name => $d)
				{
					$template->assign_block_vars('sheets', [
						'NAME'				=> $sheet_name,
						'U_EDIT'			=> str_replace('mode=sheets', 'mode=edit&sheet_name=' . $sheet_name, $this->u_action),
						'SIZE'				=> strlen($d['content']),
						'DELETE_SHEET_NAME'	=> sprintf($language->lang('ACP_MARTTIPHPBB_EXTRASTYLE_SHEET_DELETE_NAME'), $sheet_name),
					]);
				}

			break;		
		}

		$template->assign_var('U_ACTION', $this->u_action);		
	}
}
