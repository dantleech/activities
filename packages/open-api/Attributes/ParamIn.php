<?php

namespace DTL\OpenApi\Attributes;

enum ParamIn: string
{
    case PATH = 'path';
    case QUERY = 'query';
    case HEADER = 'header';
    case COOKIE = 'cookie';
}
