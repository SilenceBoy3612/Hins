<?php
	
	//1.打开要添加水印图的资源
	$dst = imagecreatefromjpeg('desktop.jpg');

	//2.打开水印图片资源
	$src = imagecreatefrompng('php.png');

	//3.采样复制合并：全部水印图放到原图左上角
	$src_info = getimagesize('php.png');	#获取图片信息返回数组，0元素为宽，1元素为高

	imagecopymerge($dst,$src,0,0,0,0,$src_info[0],$src_info[1],60);	#透明度50

	//4.保存图片
	
	header('Content-type:immage.jepg');
	imagejpeg($dst,'water.jpg');
	imagejpeg($dst);
	//5.销毁资源
	imagedestory($dst);
	iamgedestory($src);