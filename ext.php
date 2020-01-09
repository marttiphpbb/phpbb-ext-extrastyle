<?php
/**
* phpBB Extension - marttiphpbb extrastyle
* @copyright (c) 2018 - 2020 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\extrastyle;

use phpbb\extension\base;
use marttiphpbb\extrastyle\service\store;

class ext extends base
{
	public function is_enableable()
	{
		$config = $this->container->get('config');
		return phpbb_version_compare($config['version'], '3.3.0', '>=')
			&& version_compare(PHP_VERSION, '7.1', '>=');
	}

	public function enable_step($old_state)
	{
        if ($old_state === false)
        {
			$config_text = $this->container->get('config_text');
			$cache = $this->container->get('cache.driver');
			$store = new store($config_text, $cache);
			$store->refresh_script_names();
            return 'refreshed_script_names';
        }

        return parent::enable_step($old_state);
	}
}
