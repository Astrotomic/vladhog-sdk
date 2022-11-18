<?php

namespace Astrotomic\VladhogSdk\Responses;

use Astrotomic\VladhogSdk\Exceptions\BadGatewayException;
use Astrotomic\VladhogSdk\Exceptions\BadResponseException;
use Astrotomic\VladhogSdk\Exceptions\ClientException;
use Astrotomic\VladhogSdk\Exceptions\ServerException;
use Sammyjo20\Saloon\Http\SaloonResponse;

class VladhogResponse extends SaloonResponse
{
    public function toException(): ?BadResponseException
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
