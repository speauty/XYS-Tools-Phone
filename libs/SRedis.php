<?php
namespace libs;


class SRedis
{
	private static $redis = null;
	
	public static function getRedis()
	{
		if (!(self::$redis instanceof \Redis)) {
			self::$redis = new \Redis;
			self::$redis->connect('127.0.0.1', 6379);
		}
		
		return self::$redis;
	}
}

?>