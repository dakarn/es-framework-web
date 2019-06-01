<?php

namespace ES\App;

use ES\App\Event\AfterResponse;
use ES\Kernel\System\EventListener\EventManager;
use ES\Kernel\System\EventListener\EventTypes;
use ES\App\Event\BeforeControllerEvent;
use ES\Kernel\System\ES;

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