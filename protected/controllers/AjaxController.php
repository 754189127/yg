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
        $data = $this->_setting['paymentMethord'];
        $arr = array();
        $i=0;
        foreach($data as $k=>$v){
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
        $data = $this->_setting['sendMethord'];
        $arr = array();
        $i=0;
        foreach($data as $k=>$v){
            $arr[$i]['value'] = $k;
            $arr[$i]['name']= $v;
            $i++;
        }
        echo CJSON::encode(array('list'=>$arr));
    }
    /**
     * 订单来源
     */
    public function actionOrdersource(){
        $data = $this->_setting['orderSource'];
        $arr = array();
        $i=0;
        foreach($data as $k=>$v){
            $arr[$i]['value'] = $k;
            $arr[$i]['name']= $v;
            $i++;
        }
        echo CJSON::encode(array('list'=>$arr));
    }
    /**
     * 厂家分类
     */
    public function actionCompanytype(){
        $data = $this->_setting['companyType'];
        $arr = array();
        $i=0;
        foreach($data as $k=>$v){
            $arr[$i]['value'] = $k;
            $arr[$i]['name']= $v;
            $i++;
        }
        echo CJSON::encode(array('list'=>$arr));
    }


    /**
     * 进转损分类
     */
    public function actionJzstype(){
        $data = $this->_setting['jzsType'];
        $arr = array();
        $i=0;
        foreach($data as $k=>$v){
            $arr[$i]['value'] = $k;
            $arr[$i]['name']= $v;
            $i++;
        }
        echo CJSON::encode(array('list'=>$arr));
    }

    /**
     * 地址分类
     */
    public function actionAddresstype(){
        $data = $this->_setting['addressType'];
        $arr = array();
        $i=0;
        foreach($data as $k=>$v){
            $arr[$i]['value'] = $k;
            $arr[$i]['name']= $v;
            $i++;
        }
        echo CJSON::encode(array('list'=>$arr));
    }
    /**
     * 会员分类
     */
    public function actionMembertype(){
        $data = $this->_setting['memberType'];
        $arr = array();
        $i=0;
        foreach($data as $k=>$v){
            $arr[$i]['value'] = $k;
            $arr[$i]['name']= $v;
            $i++;
        }
        echo CJSON::encode(array('list'=>$arr));
    }
    /**
     * 会员来源
     */
    public function actionMembersource(){
        $data = $this->_setting['memberSource'];
        $arr = array();
        $i=0;
        foreach($data as $k=>$v){
            $arr[$i]['value'] = $k;
            $arr[$i]['name']= $v;
            $i++;
        }
        echo CJSON::encode(array('list'=>$arr));
    }

}