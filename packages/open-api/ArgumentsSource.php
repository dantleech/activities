<?php

namespace DTL\OpenApi;

use Closure;
use Psr\Http\Message\ServerRequestInterface;

class ArgumentsSource
{
    /**
     * @param array<string,string> $path
     * @param array<string,string> $header
     * @param array<string,string> $query
     * @param Closure(): string $bodyReader
     */
    public function __construct(
        public array $path = [],
        public array $header = [],
        public array $query = [],
        public ?Closure $bodyReader = null,
    ) {
    }

    public static function fromPsrServerRequest(ServerRequestInterface $request): ArgumentsSource
    {
        return new self(
            [],
            array_combine(
                array_keys($request->getHeaders()),
                (function () use ($request) {
                    $c = [];
                    foreach ($request->getHeaders() as $name => $values) {
                        foreach ($values as $value) {
                            $c[$name] = $value;
                            break;
                        }
                    }
                    return $c;
                })(),
            ),
            $request->getQueryParams(),
        );
    }
    /**
     * @param array<string,mixed> $path
     */
    public function withPathParameters(array $path): ArgumentsSource
    {
        return new self(
            $path,
            $this->header,
            $this->query,
            $this->bodyReader,
        );
    }

    public function requestBody(): string
    {
        if (!$this->bodyReader) {
            return '';
        }

        $reader = $this->bodyReader;
        return $reader();
    }
    /**
     * @param Closure(): string $bodyReader
     */
    public function withBodyReader(Closure $bodyReader): ArgumentsSource
    {
        return new self(
            $this->path,
            $this->header,
            $this->query,
            $bodyReader,
        );
    }

}
