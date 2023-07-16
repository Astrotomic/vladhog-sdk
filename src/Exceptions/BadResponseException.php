<?php

namespace Astrotomic\VladhogSdk\Exceptions;

use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Response;
use Throwable;

class BadResponseException extends RequestException
{
    final public function __construct(Response $response, string $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($response, $message, $code, $previous);
    }

    public static function fromResponse(Response $response): static
    {
        return new static($response, $response->body(), $response->status(), $response->getSenderException());
    }
}
