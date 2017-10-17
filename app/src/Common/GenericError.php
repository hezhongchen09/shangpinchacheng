<?php
namespace Shangpinchacheng\Common;

class GenericError{
    public static function info($errorCode){
		$errorCodeMessage = [
			StatusCode::UnAuthorized => '用户未登录'
		];
		
		return $errorCodeMessage[$errorCode];
	}
}