<?php
	#setcookie('name','wangyongsheng',time()+7*24*3600);
	#setcookie('age',24);
	#setcookie('sex','��');
	#header("Content-type: text/html; charset=utf-8"); 
	#setcookie('name','������',time()+3600);
	#setcookie('age',23);
	#setcookie('sex','��');

	//1.��������
	$img = imagecreatetruecolor(400,400);//��Ⱥ͸߶ȣ����ص�λ���õ�������Դ

	//2.��ӱ�����ɫ
	//2.������ɫ
	$bg_color = imagecolorallocate($img,255,255,255);

	//2.2��䣺�Զ��ҵ�ָ����ɫ��ͬ�����ڵ㣬��Ⱦ
	imagefill($img,0,0,$bg_color);

	//3.д���ַ���
	//3.1���ַ���������ɫ
	$str_color = imagecolorallocate($img,150,150,150);
	//3.2д���ַ���
	imagestring($img,4,180,180,'Hello',$str_color);

	//4.���ͼƬ
	header('Content-type:image/png');
	#imagepng($img,'captcha.png');		//����gd��������ҪͼƬ��Դ
	imagepng($img);
	
	//5.������Դ

	imagedestory($img);
?>