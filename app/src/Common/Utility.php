<?php
namespace Shangpinchacheng\Common;

class Utility{
    public static function getToken(){
    	$length = 30;
		$token = null;
		$pool = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
		$max = strlen($pool)-1;

		for($i=0;$i<$length;$i++){
			$token.=$pool[rand(0,$max)];
		}

		return $token;
	}
}