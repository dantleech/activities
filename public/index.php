<?php

use Activities\Activities\ContainerFactory;
use Slim\App;

require __DIR__  . '/../vendor/autoload.php';

ContainerFactory::container()->get(App::class)->run();
