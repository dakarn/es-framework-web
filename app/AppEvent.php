<?php

namespace App;

use App\Event\AfterResponse;
use System\EventListener\EventManager;
use System\EventListener\EventTypes;
use App\Event\BeforeControllerEvent;
use System\ES;

final class AppEvent
{
	/**
	 * @param EventManager $eventManager
	 * @return EventManager
	 */
	public function installEvents(EventManager $eventManager): EventManager
	{
		$eventManager->addEventListener(EventTypes::BEFORE_CONTROLLER, BeforeControllerEvent::class);
		$eventManager->addEventListener(EventTypes::AFTER_OUTPUT_RESPONSE, AfterResponse::class);

		ES::set(ES::APP_EVENT, $eventManager);
		return $eventManager;
	}
}