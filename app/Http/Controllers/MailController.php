<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function send()
    {
        Mail::raw("这是测试的内容", function ($message){
            // * 如果你已经设置过, mail.php中的from参数项,可以不用使用这个方法,直接发送
            // $message->from("1182468610@qq.com", "laravel学习测试");
            $user='1114621937@qq.com';
            $message->subject("测试的邮件主题");
            // 指定发送到哪个邮箱账号
            $message->to($user);
        });

        // 返回的一个错误数组，利用此可以判断是否发送成功
        dd(Mail::failures());
    }
}
