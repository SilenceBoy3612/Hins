<?php
/*
 *制作水印图
 *@param1 string $image,原图路径
 *@param2 string $path,存储路径
 *@param3 string $water,水印资源
 *@param4 int $pct = 50,水印透明度
 @return string $water_file,新的水印图名字
 */
	function getWatermark($image,$path,$water,$pct=50){

	//1.打开原图资源
	$dst = imagecreatefromjpeg($image);

	//2.打开水印资源
	$src = imagecreatefrompng($water);

	//3.采样合并资源
	$src_info = getimagesize($water);	#获取图片信息

	imagecopymerge($dst,$src,0,0,0,0,$src_info[0],$src_info[1],$pct);	#͸����50

	//4.保存输出
	$image_info = pathinfo($image); #返回数组：extension是后缀名，filename是纯名字
	//拼凑新文件名字
	$water_name = $image_info['filename'].'_water.'.$image_info['extension'];
	imagejpeg($dst,$path.''.$water_name);

	//5.销毁资源
	imagedestroy($dst);
	imagedestroy($src);

	//6.返回文件名
	// return $water_name;
}

getWatermark('desktop.jpg','./','php.png');
