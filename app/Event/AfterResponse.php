<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.04.2018
 * Time: 15:22
 */

namespace App\Event;

use System\EventListener\EventListenerInterface;

class AfterResponse implements EventListenerInterface
{
    /**
     * @var array
     */
    private $arguments = [];

    /**
     * AfterResponse constructor.
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