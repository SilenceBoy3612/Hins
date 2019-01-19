<?php
	#setcookie('name','wangyongsheng',time()+7*24*3600);
	#setcookie('age',24);
	#setcookie('sex','男');
	#header("Content-type: text/html; charset=utf-8"); 
	#setcookie('name','廖梓富',time()+3600);
	#setcookie('age',23);
	#setcookie('sex','男');

	//1.创建画布
	$img = imagecreatetruecolor(400,400);//宽度和高度，像素单位，得到画布资源

	//2.添加背景颜色
	//2.分配颜色
	$bg_color = imagecolorallocate($img,255,255,255);

	//2.2填充：自动找到指定颜色相同的相邻点，渲染
	imagefill($img,0,0,$bg_color);

	//3.写入字符串
	//3.1给字符串分配颜色
	$str_color = imagecolorallocate($img,150,150,150);
	//3.2写入字符串
	imagestring($img,4,180,180,'Hello',$str_color);

	//4.输出图片
	header('Content-type:image/png');
	#imagepng($img,'captcha.png');		//所有gd函数都需要图片资源
	imagepng($img);
	
	//5.销毁资源

	imagedestory($img);
?>