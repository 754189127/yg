<?php
/**
 * 购物流程
 * Created by PhpStorm.
 * User: kevin
 * Date: 14-7-2
 * Time: 下午9:42
 */

class OrderremittanceController extends BaseController{
    public function init(){
        parent::init();
    }
    public $layout='//layouts/column1';

    public function actionIndex()
    {
        $condition = array(
            'periodicalId'=>isset($_POST['periodicalId'])?trim($_POST['periodicalId']):0,
            'companyCode'=>isset($_POST['companyCode'])?trim($_POST['companyCode']):'',
            'address'=>isset($_POST['address'])?trim($_POST['address']):'',
            'productCode'=>isset($_POST['productCode'])?trim($_POST['productCode']):''
        );
        $list = Orderremittance::model()->getList($condition);

        $arr = array('list'=>$list);
        echo CJSON::encode($arr);
    }


    public function actionAdd()
    {
            $this->render('add');
    }
    public function actionCreate()
    {
        $model = new Orderremittance();
        if (isset($_POST)) {
            $post = $_POST;
            if($post['periodicalId']==''){
                $msg = array('success'=>false,'msg'=>'期数不能为空');
                exit(CJSON::encode($msg));
            }
            if($post['memberId']==''){
                $msg = array('success'=>false,'msg'=>'会员不能为空');
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
        $model = new Orderremittance();
        if (isset($_POST)) {
            $post = $_POST;
            if($post['periodicalId']==''){
                $msg = array('success'=>false,'msg'=>'期数不能为空');
                exit(CJSON::encode($msg));
            }
            if($post['memberId']==''){
                $msg = array('success'=>false,'msg'=>'会员不能为空');
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



    public function actionView()
    {
        $model = new Orderremittance();
        $id = $_POST['id'];
        $data = $model->findByPk($id);
        exit(CJSON::encode(array('info'=>$data)));
    }

    public function actionDelete()
    {
        $model = new Orderremittance();
        $id = $_POST['id'];
        if ($model->deleteByPk($id)){
            $msg = array('success'=>true,'msg'=>'删除成功');
        }else{
            $msg = array('success'=>false,'msg'=>'删除失败');
        }
        exit(CJSON::encode($msg));
    }
} 