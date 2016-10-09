package org.aisharing.rsa.response;

import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.security.InvalidKeyException;
import java.security.NoSuchAlgorithmException;
import java.security.spec.InvalidKeySpecException;

import javax.crypto.BadPaddingException;
import javax.crypto.IllegalBlockSizeException;
import javax.crypto.NoSuchPaddingException;
import javax.xml.parsers.ParserConfigurationException;

import org.xml.sax.SAXException;
import org.aisharing.rsa.format.KeyFormat;
import org.aisharing.rsa.data.KeyWorker;

public class App2Server {

	public static String resdString(String path){
		String str="";
		File file=new File(path);
		try {
			FileInputStream in=new FileInputStream(file);
			int size=in.available();
			byte[] buffer=new byte[size];
			in.read(buffer);
			in.close();
			str=new String(buffer, "UTF-8");
			
		} catch (Exception e) {
			// TODO: handle exception
			e.printStackTrace();
		}
		return str;
	}
	
	public static void PemEncypt(){
		
		String pubkey=resdString("G:/xampp/htdocs/Projects/test.crt");//更改为你的公钥文件路径
		String prikey=resdString("G:/xampp/htdocs/Projects/test.pem");//更改为你的私钥文件路径
		
		pubkey=pubkey.replace("-----BEGIN PUBLIC KEY-----", "").replace("-----END PUBLIC KEY-----", "");
		//去掉公钥的header,footer
		prikey=prikey.replace("-----BEGIN PRIVATE KEY-----", "").replace("-----END PRIVATE KEY-----", "");
        //去掉私钥的header,footer
		KeyWorker priWorker = new KeyWorker(prikey, KeyFormat.PEM);
        KeyWorker pubWorker = new KeyWorker(pubkey, KeyFormat.PEM);
        //ASN格式的转换:KeyFormat.ASN
       
		try {
			
			String data="www.aisharing.org";
			String pub_encrypted;
			pub_encrypted = pubWorker.encrypt(data);//公钥加密
			String pri_decypted;
			pri_decypted = priWorker.decrypt(pub_encrypted);//私钥解密
			
			System.out.println(pub_encrypted);
			System.out.println("\n");
			System.out.print("私钥解密后: "+pri_decypted);
			
		} catch (InvalidKeyException | IllegalBlockSizeException | BadPaddingException | NoSuchAlgorithmException
				| NoSuchPaddingException | InvalidKeySpecException | IOException | SAXException
				| ParserConfigurationException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
       // System.out.print(pubWorker.decrypt(priWorker.encrypt(data)));//此为私钥加密，公钥解密

	}
	
	public static void PemDecypt(){
		
		String prikey=resdString("G:/xampp/htdocs/Projects/test.pem");
		//更改为你的私钥文件路径
		prikey=prikey.replace("-----BEGIN PRIVATE KEY-----", "").replace("-----END PRIVATE KEY-----", "");
        //去掉私钥的header,footer
		KeyWorker priWorker = new KeyWorker(prikey, KeyFormat.PEM);
        //ASN格式的转换:KeyFormat.ASN
       
		try {
			
			String pub_encrypted="Khc8OWr0Y@2jOC88oo@3aB3ZHnX4g"
					+ "lqcTBZSTWDJ3ylzTCgGseBz9nG0CUAIlydvh1@1K"
					+ "dssjidEy8M+d7cFyAopghUKmXkNcUN1mLbmf4XZG"
					+ "SJ4CpLsNXowlGNJv7vBE4dWg2KLRuvxyo91GBamL"
					+ "wI0W0dMMhQE0sdnWdfou6hSlPLWcZw0xaSRCYXvG"
					+ "D0ugKHwjlQSdbWQTonpiX0wh@uzjZdCIoZGoITAq"
					+ "uo7ftXS0F@8fOw98dbwlMnd1+WuqrvowVD8BQgzH"
					+ "1vu2emPUByG9iCISoaC+7Ewsw1KlTsTYhlstGd9o"
					+ "MiquwYO9HRcgbiAmJpk8qcxMtgBd@4ztg==";	
			pub_encrypted=pub_encrypted.replace("@", "/");
			//将后台传过来的密文中的“@”替换为“/”。
			
			String pri_decypted;
			pri_decypted = priWorker.decrypt(pub_encrypted);//私钥解密
	
			System.out.print("私钥解密后: "+pri_decypted);
			
		} catch (InvalidKeyException | IllegalBlockSizeException | BadPaddingException | NoSuchAlgorithmException
				| NoSuchPaddingException | InvalidKeySpecException | IOException | SAXException
				| ParserConfigurationException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
       // System.out.print(pubWorker.decrypt(priWorker.encrypt(data)));//此为私钥加密，公钥解密

	}
	
	public static void main(String[] args) {
		// TODO Auto-generated method stub
		PemEncypt();//加密
		//PemDecypt();//解密
	}
}
