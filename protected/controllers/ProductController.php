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
            'productCode'=>isset($_POST['productCode'])?trim($_POST['productCode']):'',
            'receiptId'=>isset($_POST['receiptId'])?trim($_POST['receiptId']):'',
        );
        $model = new Product();
        $list = $model->getList($condition);
        echo CJSON::encode(array('list'=>$list));
    }

    public function actionAdd()
    {
        $receiptId = $_GET['receiptId'];
        $this->render('add',array('receiptId'=>$receiptId));
    }

    public function actionCreate()
    {
        $model = new Product();
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
        $model = new Product();
        if (isset($_POST)) {
            if ($model->saveData($_POST)){
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
} 