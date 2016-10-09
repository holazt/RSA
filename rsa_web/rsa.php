<?php 
	//header("Content-type:text/javascript;charset=utf-8");
	$encrypted=$_POST['cipherb64'];
	$public_key = file_get_contents("../public.crt");
	$private_key = file_get_contents("../private.pem");
	
	//var_dump(base64_decode($encrypted));

	$pu_key = openssl_pkey_get_public($public_key);//这个函数可用来判断公钥是否是可用的
	$pi_key = openssl_pkey_get_private($private_key);//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
	//var_dump($pu_key);
	//var_dump($pi_key);
	openssl_private_decrypt(base64_decode($encrypted),$decrypted,$pi_key);//私钥解密
	echo "\n";
	var_dump($decrypted);
	echo "\n"."共".strlen($decrypted)."个字节。";
 ?>