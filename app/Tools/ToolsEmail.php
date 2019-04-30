<?php 

namespace App\Tools;

use Mail;

/**
 *
 */
 /**
 * 
 */
 class ToolsEmail
 {
 	//发送纯文本邮件
 	public static function sendEmail($emailData)
 	{
 		//发送纯文本
        $res = Mail::raw($emailData['content'], function ($message) use($emailData) {
            $to = $emailData['email_address'];
            $message ->to($to)->subject($emailData['subject']);
        });

        return $res;
 	}

 	public static function sendHtmlEmail($viewData, $emailData)
 	{
 		 //发送HTML的邮件信息
 		$res = Mail::send($viewData['url'],$viewData['assign'],function($message) use($emailData) { 
            $to = $emailData['email_address']; 
            $message ->to($to)->subject($emailData['subject']); 
        });

        return $res;
 	}

 	//生成激活码
 	public static function createActiveCode($username, $email)
 	{
 		$rand = rand(100000,999999);

 		$key = "FORGET_".$username."_".$email;

 		$redis = new \Redis();

 		$redis->connect('127.0.0.1',6379);

 		$redis->setex($key,1800,$rand);

 		return $rand;
 	}
 }


 ?>