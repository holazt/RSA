<?php 
define('OPENSSL_CNF','G:\xampp\php\extras\openssl\openssl.cnf');
define('SHA',"sha512");
define('LENGTH',2048);

header("Content-type:text/html;charset=utf-8");
$configargs=array(
	'config'=> OPENSSL_CNF,
	"digest_alg" => SHA,
    "private_key_bits" => LENGTH,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,);
$res=openssl_pkey_new($configargs);
openssl_pkey_export($res,$pri,null, $configargs);

	/*
	 * Hexadecimal Data to Binary Data
	 * @param string $hexString
	 * @return string $binString
	 */
	
	  function hexTobin($hexString) 
        { 
            $hexLenght = strlen($hexString); 
            // only hexadecimal numbers is allowed 
            if ($hexLenght % 2 != 0 || preg_match("/[^\da-fA-F]/",$hexString)) return FALSE; 

            unset($binString); 
            for ($x = 1; $x <= $hexLenght/2; $x++) 
            { 
                    $binString .= chr(hexdec(substr($hexString,2 * $x - 2,2))); 
            } 

            return $binString; 
        } 

    /*
	 * Binary Data to Decimal Data
	 * @param string $data
	 * @return string $result
	 */
    
	function binTodec($data)
	{
		$base = "256";
		$radix = "1";
		$result = "0";

		for($i = strlen($data) - 1; $i >= 0; $i--)
		{
			$digit = ord($data{$i});
			$part_res = bcmul($digit, $radix);
			$result = bcadd($result, $part_res);
			$radix = bcmul($radix, $base);
		}

		return $result;
	}

$details=openssl_pkey_get_details($res);

$n_hex=bin2hex($details['rsa']['n']);
$d_hex=bin2hex($details['rsa']['d']);
$e_hex=bin2hex($details['rsa']['e']);

$n_dec=binTodec($details['rsa']['n']);
$d_dec=binTodec($details['rsa']['d']);
$e_dec=binTodec($details['rsa']['e']);

openssl_pkey_free($res);

$pub=$details['key'];

$crtpath = "./test.crt"; //公钥文件路径  
$pempath = "./test.pem"; //私钥文件路径  

$n_hexpath = "./n_hex.key"; //n_hex文件路径  
$d_hexpath = "./d_hex.key"; //d_hex文件路径  
$e_hexpath = "./e_hex.key"; //e_hex文件路径 

$n_decpath = "./n_dec.key"; //n_dec文件路径  
$d_decpath = "./d_dec.key"; //d_dec文件路径  
$e_decpath = "./e_dec.key"; //e_dec文件路径 

//生成证书文件  
$fp = fopen($crtpath, "w");  
fwrite($fp, $pub);  
fclose($fp);  

$fp = fopen($pempath, "w");  
fwrite($fp, $pri);  
fclose($fp);  
//生成n_hex,d_hex,e_hex文件
$fp = fopen($n_hexpath, "w");  
fwrite($fp, $n_hex);  
fclose($fp);  

$fp = fopen($d_hexpath, "w");  
fwrite($fp, $d_hex);  
fclose($fp);  

$fp = fopen($e_hexpath, "w");  
fwrite($fp, $e_hex);  
fclose($fp); 
//生成n_dec,d_dec,e_dec文件
$fp = fopen($n_decpath, "w");  
fwrite($fp, $n_dec);  
fclose($fp);  

$fp = fopen($d_decpath, "w");  
fwrite($fp, $d_dec);  
fclose($fp);  

$fp = fopen($e_decpath, "w");  
fwrite($fp, $e_dec);  
fclose($fp); 

var_dump($pub);
echo "<br/>";
var_dump($pri);
$pu_key = openssl_pkey_get_public($pub);
print_r($pu_key);
echo "<br/>";
$data = 'plaintext data goes here.';

// Encrypt the data to $encrypted using the public key
openssl_public_encrypt($data, $encrypted,$pub,OPENSSL_PKCS1_PADDING);

// Decrypt the data using the private key and store the results in $decrypted
openssl_private_decrypt($encrypted, $decrypted, $pri,OPENSSL_PKCS1_PADDING);

echo $encrypted." ".strlen($encrypted)."   ".base64_encode($encrypted)."<br/>";
echo $decrypted;


?>