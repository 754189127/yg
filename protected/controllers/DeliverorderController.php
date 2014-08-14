<?php
/**
 * 出货单管理
 * User: kevin
 * Date: 14-7-1
 * Time: 下午8:49
 */

class DeliverorderController extends BaseController{
    public function init(){
        parent::init();
    }

    //获取已收费的会员订购单（出货单）
    public function actionIndex(){
        $condition = array(
            'periodicalId'=>isset($_POST['periodicalId'])?trim($_POST['periodicalId']):0,
            'userCode'=>isset($_POST['userCode'])?trim($_POST['userCode']):'',
            'userName'=>isset($_POST['userName'])?trim($_POST['userName']):'',
            'deliveryOrderCode'=>isset($_POST['deliveryOrderCode'])?trim($_POST['deliveryOrderCode']):''
        );
        $model = new Orderremittance();
        $list = $model->getListForDelivery($condition);
        echo CJSON::encode(array('list'=>$list));
    }

    /*
     * 生成出货单号
     */
    public function actionGenerationcode()
    {
        $orderRemittanceId = $_POST['orderRemittanceId'];
        if($orderRemittanceId){
            $post =$_POST;
            $model = new DeliveryOrder();
            $deliveryOrderCode = 'DO'.date('YmdHis');
            $post['deliveryOrderCode']=$deliveryOrderCode;
            if ($model->saveData($post)){
                $msg = array('success'=>true,'msg'=>'出货单生成成功');
            }else{
                $deliveryOrderCode = '';
                $msg = array('success'=>false,'msg'=>'出货单生成失败');
            }
        }else{
            $deliveryOrderCode = '';
            $msg = array('success'=>false,'msg'=>'出货单生成失败');
        }
        echo CJSON::encode(array('code'=>$deliveryOrderCode,'msg'=>$msg));
    }

    public function actionCreate()
    {
        $model = new DeliveryOrder();
        if (isset($_POST)) {
            if ($model->saveData($_POST)){
                $msg = array('success'=>true,'msg'=>'添加成功');
            }else{
                $msg = array('success'=>false,'msg'=>'添加失败');
            }
            exit(CJSON::encode($msg));
        }
    }

    public function actionUpdate()
    {
        $model = new DeliveryOrder();
        if (isset($_POST)) {
            if ($model->saveData($_POST)){
                $msg = array('success'=>true,'msg'=>'修改成功');
            }else{
                $msg = array('success'=>false,'msg'=>'修改失败');
            }
            exit(CJSON::encode($msg));
        }
    }


    /**
     * 根据汇款订购单查看订单产品详情
     */
    public function actionVieworderdetail()
    {
        $orderRemittanceId = $_POST['orderRemittanceId'];
        $data = array();
        if($orderRemittanceId){
            $model = new  OrderProduct();
            $condition = array(
                'orderRemittanceId'=>$_POST['orderRemittanceId'],
                'productCode'=>isset($_POST['productCode'])?trim($_POST['productCode']):'',
                'number'=>isset($_POST['number'])?trim($_POST['number']):'',
                'remark'=>isset($_POST['remark'])?trim($_POST['remark']):''
            );
            $data = $model->getOrderProduct($condition);
        }
        echo CJSON::encode(array('list'=>$data));
    }

    /*
     * 保存订单产品详情
     */
    public function actionSaveorderproduct()
    {
        $model = new OrderProduct();
        if (isset($_POST)) {
            $post = $_POST;
            if(!$post['orderremittanceId']){
                $msg = array('success'=>false,'msg'=>'缺省汇款订购id');
                exit(CJSON::encode($msg));
            }
            if(!$post['productCode']){
                $msg = array('success'=>false,'msg'=>'货号不能为空');
                exit(CJSON::encode($msg));
            }
            if(!$post['number']){
                $msg = array('success'=>false,'msg'=>'数量不能为空');
                exit(CJSON::encode($msg));
            }
            $product = Product::model()->findByProductCode($post['productCode']);
            if(!$product){
                $msg = array('success'=>false,'msg'=>'货号不存在');
                exit(CJSON::encode($msg));
            }
            if ($model->saveData($post,$product)){
                $msg = array('success'=>true,'msg'=>'保存成功');
            }else{
                $msg = array('success'=>false,'msg'=>'保存失败');
            }
            exit(CJSON::encode($msg));
        }
    }

    /*
     * 根据订单产品记录id删除
     */
    public function actionDeleteorderproduct()
    {
        $model = new OrderProduct();
        $id = $_POST['id'];
        if ($model->deleteByPk($id)){
            $msg = array('success'=>true,'msg'=>'删除成功');
        }else{
            $msg = array('success'=>false,'msg'=>'删除失败');
        }
        exit(CJSON::encode($msg));
    }

}