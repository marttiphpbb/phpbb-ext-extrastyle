<?php
/**
* phpBB Extension - marttiphpbb Extra Style
* @copyright (c) 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\extrastyle\event;

use phpbb\event\data as event;
use phpbb\controller\helper;
use marttiphpbb\extrastyle\service\store;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $store;
	protected $helper;

	public function __construct(helper $helper, store $store)
	{
		$this->helper = $helper;
		$this->store = $store;
	}

	static public function getSubscribedEvents()
	{
		return [
			'core.twig_environment_render_template_before'
				=> 'core_twig_environment_render_template_before',
		];
	}

	public function core_twig_environment_render_template_before(event $event)
	{
		$context = $event['context'];

		if (!isset($context['SCRIPT_NAME']))
		{
			return;
		}

		$load_sheets = $this->store->get_load_sheets($context['SCRIPT_NAME']);
		$sheets = [];

		foreach ($load_sheets as $sheet_name => $sheet_version)
		{
			$params = [
				'name'		=> $sheet_name,
				'v'			=> $sheet_version,
			];

			$sheets[] = $this->helper->route('marttiphpbb_extrastyle_render_controller', $params);
		}

		$context['marttiphpbb_extrastyle'] = $sheets;
		$event['context'] = $context;
	}
}
