<?php
	function getCaptcha($width,$height,$line=10,$length=4){

	
	//1.产生图片资源
	$img = imagecreatetruecolor($width,$height);

	//2.背景颜色填充
	$bg_color = imagecolorallocate($img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
	imagefill($img,0,0,$bg_color);

	//3.获取随机字符串
	$str_arr = range('A','Z');
	shuffle($str_arr); #打乱数组

	//4.写入到图片
	$captcha = '';	#保存取出来的随机字符
	for($i=0;$i<$length;$i++){
		//保存第$i个元素
		$captcha .= $str_arr[$i];

		//单独为每个字符写入到图片
		$str_color = imagecolorallocate($img,mt_rand(0,80),mt_rand(0,80),mt_rand(0,80));
		imagestring($img,5,30+$i*10,10,$str_arr[$i],$str_color);
	}	
		//5.增加干扰线
		for($i=0;$i<$line;$i++){
			#画线
			$l_color = imagecolorallocate($img,mt_rand(100,160),mt_rand(100,160),mt_rand(100,160));
			imageline($img,mt_rand(0,$width),mt_rand(0,$height),mt_rand(0,$width),mt_rand(0,$height),$l_color);
		} 

	//6.输出内容
	header('Content-type:image/png');
	imagepng($img);

	//7.销毁资源
	imagedestory($img);
	}

	getCaptcha(100,30);
?>