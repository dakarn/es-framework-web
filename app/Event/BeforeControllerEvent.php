<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.03.2018
 * Time: 1:49
 */

namespace App\Event;

use System\EventListener\EventListenerInterface;

class BeforeControllerEvent implements EventListenerInterface
{
	/**
	 * @var array
	 */
	private $arguments = [];

	/**
	 * BeforeControllerEvent constructor.
	 * @param array $arguments
	 */
	public function __construct(array $arguments = [])
	{
		$this->arguments = $arguments;
	}

	/**
	 *
	 */
	public function execute()
	{

	}
}