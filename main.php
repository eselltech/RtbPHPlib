<?php

/**
 * Created by vscode.
 * User: wujunquan
 * Date: 2019/12/10
 * Time: 17:05
 */

 require "./rtbManager.php";


/**
 * 使用方法
 */
function main(){

    /**
     * 初始化广告管理类
     */
    $rtbManager=new rtbManager("lxro7k17u3asd8vj","al3l7unur521r3n3zutkpp7uf7tj87od","MLAT1A2019624001281");
    
    /**
     * 初始化一个广告位
     */
    $adsolt=new adSlotModel();
    
    /**
     * 设置广告位ID
     */
    $adsolt->slotid="25075828";
   
    /**
     * 广告位类型  IMG/VDO
     */
    $adsolt->type="IMG";
    
    /**
     * 获取数目: 如果只有一个广告，也会返回4个。 可以4个进行轮播。 返回的上报trace_url 是不一样的。 数目自己控制，可以减少请求频率
    * */ 
    $adsolt->quantity=4;
    
    /**
     * 发起请求
     */
    $result= $rtbManager->request($adsolt);
    

    /**
     * 返回json类型[广告实体类]
     */
    return $result;
}

echo main();
?>
