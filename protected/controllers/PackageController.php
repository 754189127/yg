<?php
/**
 * 邮寄包裹管理
 * User: kevin
 * Date: 14-7-21
 * Time: 下午9:43
 */

class PackageController extends  BaseController{
    public function init(){
        parent::init();
    }

    //包裹单列表
    public function actionIndex(){
        $condition = array(
            'periodicalId'=>isset($_POST['periodicalId'])?trim($_POST['periodicalId']):0,
            'userCode'=>isset($_POST['userCode'])?trim($_POST['userCode']):'',
            'userName'=>isset($_POST['userName'])?trim($_POST['userName']):'',
            'deliveryOrderCode'=>isset($_POST['deliveryOrderCode'])?trim($_POST['deliveryOrderCode']):'',
			'mailingDate'=>isset($_POST['mailingDate'])?trim($_POST['mailingDate']):'',
        );
        $model = new DeliveryOrder();
        $list = $model->getListForPackage($condition);
        echo CJSON::encode(array('list'=>$list));
    }

} 