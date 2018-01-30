<?php
namespace App\Enums;

abstract class ErrorCode
{
    const OK           = 200;
    const BAD_REQUEST  = 400;
    const UNAUTHORIZED = 401;
    const FORBIDDEN    = 403;

    const DATA_INVALID       = "Data invalid";
    const DATA_ERROR         = "Data error";
    const PERMISSION_DENIED  = "Permission denied";

}
