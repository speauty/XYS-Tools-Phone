<?php
namespace app;
use libs\Request;
use libs\SRedis;


class QueryPhone
{
	const TAOBAO_API = 'https://tcc.taobao.com/cc/json/mobile_tel_segment.htm';
	const CACHE_KEY = 'PHONE:INFO';
	
	public static function query($phone)
	{
		$ret = '';
		if (self::verifyPhone($phone)) {
			$redis = SRedis::getRedis();
			$redisKey = substr($phone, 0, 7);
			$ret = $redis->hGet(self::CACHE_KEY, $redisKey);
			if (!$ret) {
				$data = Request::request(self::TAOBAO_API, ['tel' => $phone]);
				$data = self::formatData($data);
				if ($data) {
					$json = json_encode($data);
					$redis->hSet(self::CACHE_KEY, $redisKey, $json);
					$ret = $data;
				}
			}
		}
		if (is_string($ret)) $ret = json_decode($ret, true);
		
		return $ret;
	}

	public static function verifyPhone($phone = '')
	{
		$res = false;
		if ($phone) {
			if (preg_match('/^1[345789]{1}\d{9}/', $phone)) {
				$res = true;
			}
		}

		return $res;
	}

	public static function formatData($data)
	{
		$res = null;
		if ($data) {
			$data = iconv('GB2312', 'utf-8', $data);
			preg_match_all("/(\w+):\'([^']+)/", $data, $res);
			$res = array_slice(array_combine($res[1], $res[2]),0, 3);
		}

		return $res;
	}
}
?>
