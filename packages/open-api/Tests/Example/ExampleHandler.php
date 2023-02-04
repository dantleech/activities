<?php

namespace DTL\OpenApi\Tests\Example;

use stdClass;
use DTL\OpenApi\Attributes as Api;

class ExampleHandler
{
    #[Api\Param('uuid', 'The UUID', Api\ParamIn::PATH)]
    #[Api\Param('location', 'The location', Api\ParamIn::PATH)]
    #[Api\Param('from', 'From this date', Api\ParamIn::QUERY)]
    #[Api\Param('X-FOOBAR', 'The secure foobar', Api\ParamIn::HEADER)]
    #[Api\Param('session', 'Cookie value', Api\ParamIn::COOKIE)]
    #[Api\Path('/foobar/{location}/{uuid}')]
    public function handle(): stdClass {
        return new stdClass();
    }

}
