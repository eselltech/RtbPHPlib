<?php

 require './adSlotModel.php';


 class rtbManager{

    /**
     * appid
     */
    private $appid;

    /**
     * appkey
     */
    private $appkey;

    /**
     * 设备ID
     */
    private $deviceid;

    /**
     * 构造函数
     */
    function __construct($p_appid,$p_appkey,$p_deivceid)
    {

        if(empty($p_appid)||empty($p_appkey)||empty($p_deivceid))
        {
             throw new Exception("appid ,appkey, deviceid  不能位空");
        }

       $this->appid= $p_appid;
       $this->appkey=$p_appkey;
       $this->deviceid=$p_deivceid;
    }

    /**
     * 发起针对广告位的请求
     */
    function request(adSlotModel $adSlotModel){

        $timestamp=time();

        $payload = array(
            "device-uuid"=> $this->deviceid,
            "slot-id"=> $adSlotModel->slotid,
            "quantity"=>$adSlotModel->quantity,
            "type"=> $adSlotModel->type,
            "ip"=> "",
            "debug"=>"esell"
        );

        $sign=$this->sign($adSlotModel,$payload,$timestamp,$timestamp);
        $url="http://api6.pingxiaobao.com/rtb/subscribe.shtml?appid=$this->appid&sequence=$timestamp&timestamp=$timestamp&version=1.3&sign=$sign";
        $con = curl_init((string)$url); curl_setopt($con, CURLOPT_HEADER, false);
        
        print("请求链接-->".$url."\n");
        

        $payload_str=json_encode($payload);
        $requestString="payload={$payload_str}";
        
        print("请求内容-->".$requestString."\n");
        
        curl_setopt($con, CURLOPT_POSTFIELDS, $requestString); 
        curl_setopt($con, CURLOPT_POST,true); curl_setopt($con, CURLOPT_RETURNTRANSFER,true);
        $output = curl_exec($con); if($output === FALSE ){
        echo "CURL Error:".curl_error($con);
        }
        curl_close($con);

        print("返回内容-->".$output."\n");
        
        $repdata=(json_decode($output, false));; 
      
        return $repdata;
    }

     

    function sign(adSlotModel $adSlotModel,$payload,$sequence,$timestamp){       
            $data = array();
            $data['appkey'] =$this->appkey;
            $data['appid'] = $this->appid;
            $data['version'] = "1.3";
            $data['sequence'] = $sequence;
            $data['timestamp'] = $timestamp;
            $data['payload'] = json_encode($payload); ksort($data,SORT_STRING);
            $arr = array();
            foreach ($data as $key => $value) {
            $arr[] = $key . '=' . $value ;
            }
            $str = implode('&', $arr); return (md5($str));
    }

 }

?>
