<?php
/**
* phpBB Extension - marttiphpbb Extra Style
* @copyright (c) 2018 - 2020 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\extrastyle\migrations;
use marttiphpbb\extrastyle\util\cnst;
use marttiphpbb\extrastyle\service\store;

class mgr_1 extends \phpbb\db\migration\migration
{
	static public function depends_on():array
	{
		return [
			'\phpbb\db\migration\data\v330\v330',
		];
	}

	public function update_data():array
	{
		$data = [
			'sheets' 	=> [],
			'load'		=> [],
		];

		return [
			['config_text.add', [store::KEY, serialize($data)]],

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
						'sheets',
						'edit',
					],
				],
			]],
		];
	}
}
