<?php
	
	//1.��Ҫ���ˮӡͼ����Դ
	$dst = imagecreatefromjpeg('desktop.jpg');

	//2.��ˮӡͼƬ��Դ
	$src = imagecreatefrompng('php.png');

	//3.�������ƺϲ���ȫ��ˮӡͼ�ŵ�ԭͼ���Ͻ�
	$src_info = getimagesize('php.png');	#��ȡͼƬ��Ϣ�������飬0Ԫ��Ϊ��1Ԫ��Ϊ��

	imagecopymerge($dst,$src,0,0,0,0,$src_info[0],$src_info[1],60);	#͸����50

	//4.����ͼƬ
	
	header('Content-type:immage.jepg');
	imagejpeg($dst,'water.jpg');
	imagejpeg($dst);
	//5.������Դ
	imagedestory($dst);
	iamgedestory($src);