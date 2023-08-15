<?php

namespace ClicKargoTeam\ClicConnector\Exceptions;

use Exception;

class ClicConnectServiceException extends Exception
{
    public static function invalidPath(string $path): self
    {
        return new static("The path {$path} is not exists");
    }
}
