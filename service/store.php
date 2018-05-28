<?php

/**
* phpBB Extension - marttiphpbb Extra Style
* @copyright (c) 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\extrastyle\service;

use phpbb\config\db_text as config_text;
use phpbb\cache\driver\driver_interface as cache;
use marttiphpbb\extrastyle\util\cnst;

class store
{
	const KEY = cnst::ID;
	const CACHE_KEY = '_' . self::KEY;

	/** @var config_text */
	private $config_text;

	/** @var cache */
	private $cache;
	
	/** @var array */
	private $data = [];

	public function __construct(config_text $config_text, cache $cache)
	{
		$this->config_text = $config_text;	
		$this->cache = $cache;		
	}

	private function load()
	{
		if ($this->data)
		{
			return;
		}

		$this->data = $this->cache->get(self::CACHE_KEY);		
		
		if ($this->data)
		{
			return;
		}
		
		$this->data = unserialize($this->config_text->get(self::KEY));
		$this->cache->put(self::CACHE_KEY, $this->data);
	}

	private function write()
	{
		$this->config_text->set(self::KEY, serialize($this->data));
		$this->cache->put(self::CACHE_KEY, $this->data);
	}

	public function get_sheet_content(string $name, string $version):string
	{
		$this->load();
		$sheet = $this->data['sheets'][$name];
		if ($sheet['version'] === $version)
		{
			return $sheet['content'];
		}
		return  '';
	}

	public function set_sheet(string $name, string $version, string $script_names, string $content)
	{
		$this->load();
		$this->data['sheets'][$name] = [
			'content'	=> $content,
			'version'	=> $version,
			'script_names' => $script_names,
		];
		$this->write();
	}

	public function get_all_sheets():array 
	{
		$this->load();
		return $this->data['sheets'];
	}

	public function delete_sheet(string $name)
	{
		$this->load();
	
		unset($this->data['sheets'][$name]);

		foreach($this->data['load'] as $script_name => $name_ary)
		{
			foreach ($name_ary as $key => $n)
			{
				if ($n === $name)
				{
					unset($this->data['load'][$script_name][$key]);
				}
			}
		}

		$this->write();
	}

	public function get_load_sheets(string $script_name):array
	{
		$this->load();
		return $this->data['load'][$script_name] ?? [];
	}

	public function set_script_names(string $sheet_name, array $script_names)
	{
		$this->load();

		foreach ($script_names as $script_name)
		{
			if (isset($this->data['load'][$script_name]))
			{
				foreach($this->data['load'][$script_name] as $sh_name)
				{
					if ($sh_name === $sheet_name)
					{
						// already stored.
						continue;
					}
				}

				array_push($this->data['load'][$script_name], $sheet_name);

				continue;
			}

			$this->data['load'][$script_name] = [$sheet_name];
		}

		// cleanup
		foreach($this->data['load'] as $script_name => $sheet_names)
		{
			if (in_array($sheet_name, $sheet_names))
			{
				if (!in_array($script_name, $script_names))
				{
					$key = array_search($heet_name, $sheet_names);
					unset($this->data['load'][$script_name][$key]);
				}
			}
		}

		$this->write();
	}
}
