<?php
/**
* phpBB Extension - marttiphpbb Extra Style
* @copyright (c) 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\extrastyle\event;

use phpbb\event\data as event;
use marttiphpbb\extrastyle\util\cnst;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/**
	*/
	public function __construct()
	{
	}

	static public function getSubscribedEvents()
	{
		return [
			'core.user_setup'	=> 'core_user_setup',
			'core.twig_environment_render_template_before'
				=> 'core_twig_environment_render_template_before',
		];
	}

	public function core_user_setup(event $event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => cnst::FOLDER,
			'lang_set' => 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function core_twig_environment_render_template_before(event $event)
	{
		$context = $event['context'];

		$context['marttiphpbb_extrastyle']['sheets']['all'] = <<<'EOT'
div.marttiphpbb-showtopicstarter {
	background-color: black;
	color: white;
}
EOT;


		$event['context'] = $context;
	}

		
}