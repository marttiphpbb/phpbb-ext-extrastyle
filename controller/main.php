<?php

/**
* phpBB Extension - marttiphpbb extrastyle
* @copyright (c) 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\extrastyle\controller;

use phpbb\request\request;
use phpbb\template\twig\twig as template;
use phpbb\user;
use phpbb\language\language;
use phpbb\controller\helper;

use Symfony\Component\HttpFoundation\Response;

class main
{
	/** @var store */
	protected $store;

	/**
	* @param store $store
	*/

	public function __construct(
		store $store
	)
	{
		$this->store = $store;
	}

	/**
	* @param string   $name
	* @return Response
	*/
	public function render(string $name, string $v):Response
	{
		$response = new Response();
		$response->headers->set('Content-Type', 'text/css');

		if (!$v)
		{
			$response->setStatusCode(Response::HTTP_NOT_FOUND);
			return $response;
		}

		$content = $this->store->get();

		$response->setStatusCode(Response::HTTP_OK);
		$response->setContent($content);
		$response->setMaxAge(31536000);
		$response->setPublic();
		return $response;
	}
}
