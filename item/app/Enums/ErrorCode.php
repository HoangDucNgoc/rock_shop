<?php
namespace App\Enums;

abstract class ErrorCode {
	const OK = 200;
	const BAD_REQUEST = 400;
	const UNAUTHORIZED = 401;
	const FORBIDDEN = 403;

	const DATA_INVALID = "Data invalid";
	const DATA_ERROR = "Data error";
	const lOGIC_PROCESS_FAIL = "Logic process fail";
	const SAVE_DATA_FAIL = "Create data fail";
	const SAVE_DATA_SUCCESS = "Save data success";

}
