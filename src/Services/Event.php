<?php

namespace Elsayed85\LmsRedis\Services;

abstract class Event
{
    public string $id;

    public function toJson(): string
    {
        return json_encode($this);
    }

    public function toSerializableString(): string
    {
        return serialize($this);
    }

    public function getEventId(): string
    {
        return $this->id;
    }
}
