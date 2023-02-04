<?php

namespace Activities\Tests\Support\Client;

final class TestClient
{
    public function __construct(private RequestHandler $handler)
    {
    }

    public function activities(): ActivitiesClient
    {
        return new ActivitiesClient($this->handler);
    }
}
