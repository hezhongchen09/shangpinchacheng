<?php
namespace Shangpinchacheng\Common;

class ApplicationError{
    public static function error(){
		return [
			"USERNAME_OR_PASSWORD_REQUIRED"=>"用户名或密码不能为空",
			"USERNAME_OR_PASSWORD_ERROR"=>"用户名或密码错误",
			"PASSWORD_ERROR"=>"密码错误"
		];
	}
}