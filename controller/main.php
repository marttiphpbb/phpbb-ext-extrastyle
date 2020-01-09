<?php

/**
* phpBB Extension - marttiphpbb extrastyle
* @copyright (c) 2018 - 2020 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\extrastyle\controller;

use phpbb\request\request;
use marttiphpbb\extrastyle\service\store;

use Symfony\Component\HttpFoundation\Response;

class main
{
	/** @var store */
	protected $store;

	/** @var request */
	protected $request;

	/**
	* @param store $store
	*/
	public function __construct(
		store $store,
		request $request
	)
	{
		$this->store = $store;
		$this->request = $request;
	}

	/**
	* @param string   $name
	* @return Response
	*/
	public function render(string $name):Response
	{
		$version = $this->request->variable('v', '');

		$response = new Response();
		$response->headers->set('Content-Type', 'text/css');

		if (!$version)
		{
			$response->setStatusCode(Response::HTTP_NOT_FOUND);
			return $response;
		}

		$content = $this->store->get_sheet_content($name, $version);

		if (!$content)
		{
			$response->setStatusCode(Response::HTTP_NOT_FOUND);
			return $response;
		}

		$response->setStatusCode(Response::HTTP_OK);
		$response->setContent($content);
		$response->setMaxAge(31536000);
		$response->setPublic();
		return $response;
	}
}
