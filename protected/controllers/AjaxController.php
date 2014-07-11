<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 14-6-30
 * Time: 下午8:24
 */

class AjaxController extends BaseController{
    public function init(){
        parent::init();
    }

    /**
     *支付方式
     */
    public function actionPaymentmethord(){
        $payment = $this->_setting['paymentMethord'];
        $arr = array();
        $i=0;
        foreach($payment as $k=>$v){
            $arr[$i]['value'] = $k;
            $arr[$i]['name']= $v;
            $i++;
        }
        echo CJSON::encode(array('list'=>$arr));
    }

    /**
     * 寄送方式
     */
    public function actionSendmethord(){
        $send = $this->_setting['sendMethord'];
        $arr = array();
        $i=0;
        foreach($send as $k=>$v){
            $arr[$i]['value'] = $k;
            $arr[$i]['name']= $v;
            $i++;
        }
        echo CJSON::encode(array('list'=>$arr));
    }


}