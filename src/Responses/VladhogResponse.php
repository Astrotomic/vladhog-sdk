<?php

namespace Astrotomic\VladhogSdk\Responses;

use Astrotomic\VladhogSdk\Exceptions\BadGatewayException;
use Astrotomic\VladhogSdk\Exceptions\BadResponseException;
use Astrotomic\VladhogSdk\Exceptions\ClientException;
use Astrotomic\VladhogSdk\Exceptions\ServerException;
use Saloon\Http\Response;
use Throwable;

class VladhogResponse extends Response
{
    public function toException(): ?Throwable
    {
        return match (true) {
            $this->clientError() => ClientException::fromResponse($this),
            $this->serverError() => match ($this->status()) {
                502 => BadGatewayException::fromResponse($this),
                default => ServerException::fromResponse($this),
            },
            $this->failed() => BadResponseException::fromResponse($this),
            default => null,
        };
    }
}
