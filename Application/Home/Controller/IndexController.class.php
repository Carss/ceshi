<?php
namespace Home\Controller;

use Think\Controller;


class IndexController extends Controller {
   /*
   需要注意，必须环境要放在有域名的条件下如www.nmwxpay.com，这样才可以，在host里面配置个虚拟域名，就好了。 
   */ 
	public function    index()
	{
		
			import('Common.Wxpay.lib.WxPay#Config',APP_PATH,'.php');
			import('Common.Wxpay.lib.WxPay#Api',APP_PATH,'.php');
			import('Common.Wxpay.qrcode.WxPay#NativePay',APP_PATH,'.php');
			import('Common.Wxpay.qrcode.log',APP_PATH,'.php');
   
            $notify = new \NativePay();
            $WxPayConfig=new \WxPayConfig();
            $input = new \WxPayUnifiedOrder();
            $order_no = date("YmdHis") . rand(1000, 9999); //支付订单号
            $total_fee=0.01;
			$input->SetBody("test");
			$input->SetAttach("test");
			$input->SetOut_trade_no($order_no);
			$input->SetTotal_fee($total_fee*100);
			$input->SetTime_start(date("YmdHis"));
			$input->SetTime_expire(date("YmdHis", time() + 600));
			$input->SetGoods_tag("test");
			$input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
			$input->SetTrade_type("NATIVE");
			$input->SetProduct_id("123456789");
			$result = $notify->GetPayUrl($input);
			$codeurl = $result["code_url"];
			//echo $url;
			$mysql=M("wxpay");
			$SQL="insert into wxpay(out_trade_no,total_fee) values('$order_no','$total_fee')";
			$mysql->query($SQL);
			echo $SQL;

			$this->assign('codeurl',$codeurl);   
		    $this->display();
	}

	public function order($trade_no){
			import('Common.Wxpay.lib.WxPay#Config',APP_PATH,'.php');
			import('Common.Wxpay.lib.WxPay#Api',APP_PATH,'.php');
			import('Common.Wxpay.qrcode.WxPay#NativePay',APP_PATH,'.php');
			import('Common.Wxpay.qrcode.log',APP_PATH,'.php');
			$a=new \WxPayApi();
		$input = new \WxPayOrderQuery();
		$input->SetTransaction_id($trade_no);
		echo "<pre>";
		var_dump($a::orderQuery($input));
		echo "</pre>";


	}
	//腾讯云短信接口
	public function SMS(){

		//引入核心文件	
		import('Common.SMS.SmsSender',APP_PATH,'.php');
		import('Common.SMS.SmsTools',APP_PATH,'.php');
		import('Common.SMS.SmsVoiceSender',APP_PATH,'.php');
		$appid = "1400054729";//appid
	    $appkey = "d4a13246b5aba6d59c736541d2abc2c7";//appkey
	    $phoneNumber1 = $_GET['n'];  //收到短信的手机号 
	    $templId = "64659";
	     $singleSender = new SmsSingleSender($appid, $appkey);
    	//发送内容,对应腾讯SMS控制台里短信正文里的{1}{2}{3}您的账号是{1},密码是{2} 有问题请随时联系{3}
   		 $cen=array(
        $_POST['phonenumber'],//内容1-->账号/手机号
        rand(11111,55555),//内容2-->密码/随机数字或字符串
        "QQ1943728672",//内容3-->联系方式

        );

    $params = $cen;
    echo $templId;
    $result = $singleSender->sendWithParam("86", $phoneNumber1, $templId,  $params, "", "", "");
    
    $rsp = json_decode($result);
    echo $result;

	}
}