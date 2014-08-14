<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 14-7-1
 * Time: 下午8:49
 */

class ProductController extends BaseController{
    public function init(){
        parent::init();
    }

    public function actionIndex(){
        $condition = array(
            'productCode'=>isset($_POST['productCode'])?trim($_POST['productCode']):''
        );
        $model = new Product();
        $list = $model->getList($condition);
        echo CJSON::encode(array('list'=>$list));
    }



    public function actionCreate()
    {
        $model = new Product();
        if (isset($_POST)) {
            $post = $_POST;
            if($post['periodicalId']==''){
                $msg = array('success'=>false,'msg'=>'请选择期数');
                exit(CJSON::encode($msg));
            }
            if($post['companyCode']==''){
                $msg = array('success'=>false,'msg'=>'厂商编号不能为空');
                exit(CJSON::encode($msg));
            }else{
                $companyData = Company::model()->findByCompanyCode($post['companyCode']);
                if(!$companyData){
                    $msg = array('success'=>false,'msg'=>'厂商编号不存在');
                    exit(CJSON::encode($msg));
                }
                $post['companyId'] = $companyData['id'];
            }
            if($post['productCode']==''){
                $msg = array('success'=>false,'msg'=>'货号不能为空');
                exit(CJSON::encode($msg));
            }
            if($post['name']==''){
                $msg = array('success'=>false,'msg'=>'品名不能为空');
                exit(CJSON::encode($msg));
            }
            if ($model->saveData($post)){
                $msg = array('success'=>true,'msg'=>'添加成功');
            }else{
                $msg = array('success'=>false,'msg'=>'添加失败');
            }
            exit(CJSON::encode($msg));
        }
    }

    public function actionUpdate()
    {
        $model = new Product();
        if (isset($_POST)) {
            $post = $_POST;
            if($post['id']==''){
                $msg = array('success'=>false,'msg'=>'缺省参数id');
                exit(CJSON::encode($msg));
            }
            if($post['periodicalId']==''){
                $msg = array('success'=>false,'msg'=>'请选择期数');
                exit(CJSON::encode($msg));
            }
            if($post['name']==''){
                $msg = array('success'=>false,'msg'=>'品名不能为空');
                exit(CJSON::encode($msg));
            }
            if ($model->saveData($post)){
                $msg = array('success'=>true,'msg'=>'修改成功');
            }else{
                $msg = array('success'=>false,'msg'=>'修改失败');
            }
            exit(CJSON::encode($msg));
        }
    }

    public function actionDelete()
    {
        $model = new Product();
        $id = $_POST['id'];
        if ($model->deleteByPk($id)){
            $msg = array('success'=>true,'msg'=>'删除成功');
        }else{
            $msg = array('success'=>false,'msg'=>'删除失败');
        }
        exit(CJSON::encode($msg));
    }


    /*
     * 根据产品编号获取相关信息
     */
    public function actionProductbycode(){
        $productCode =  trim($_POST['ptoductCode']);
        $data= Product::model()->findByProductCode($productCode);
        echo CJSON::encode(array('info'=>$data));
    }
} 