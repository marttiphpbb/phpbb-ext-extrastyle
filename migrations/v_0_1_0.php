<?php
/**
* phpBB Extension - marttiphpbb Extra Style
* @copyright (c) 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\extrastyle\migrations;
use marttiphpbb\extrastyle\util\cnst;
use marttiphpbb\extrastyle\service\store;

class v_0_1_0 extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return [
			['config_text.add', [store::KEY, serialize([])]],

			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				cnst::L_ACP,
			]],

			['module.add', [
				'acp',
				cnst::L_ACP,
				[
					'module_basename'	=> '\marttiphpbb\extrastyle\acp\main_module',
					'modes'				=> [
						'files',
						'edit',
					],
				],
			]],			
		];
	}
}
