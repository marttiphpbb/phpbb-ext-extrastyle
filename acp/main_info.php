<?php
/**
* phpBB Extension - marttiphpbb extrastyle
* @copyright (c) 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\extrastyle\acp;

use marttiphpbb\extrastyle\util\cnst;

class main_info
{
	function module()
	{
		return [
			'filename'	=> '\marttiphpbb\extrastyle\acp\main_module',
			'title'		=> cnst::L_ACP,
			'modes'		=> [			
				'sheets'	=> [
					'title'	=> cnst::L_ACP . '_SHEETS',
					'auth'	=> 'ext_marttiphpbb/extrastyle && acl_a_board',
					'cat'	=> [cnst::L_ACP],
				],
				'edit'	=> [
					'title'	=> cnst::L_ACP . '_EDIT',
					'auth'	=> 'ext_marttiphpbb/extrastyle && acl_a_board',
					'cat'	=> [cnst::L_ACP],
				],								
			],
		];
	}
}
