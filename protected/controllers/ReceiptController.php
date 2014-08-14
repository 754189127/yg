<?php
/**
 * 进货单
 * Created by PhpStorm.
 * User: kevin
 * Date: 14-7-2
 * Time: 下午9:42
 */

class ReceiptController extends BaseController{
    public function init(){
        parent::init();
    }
    public $layout='//layouts/column1';

    public function actionIndex()
    {
        $receipt = new Receipt();
        $condition = array(
            'companyId'=>isset($_POST['companyId'])?trim($_POST['companyId']):'',
            'receiptCode'=>isset($_POST['receiptCode'])?trim($_POST['receiptCode']):''
        );
        $list = $receipt->getList($condition);
        if(isset($_GET['t']) && $_GET['t']==1){
            $this->render('index',array('list'=>$list));
        }
        $arr = array('list'=>$list);
        echo CJSON::encode($arr);
    }


    public function actionAdd()
    {
            $this->render('add');
    }
    public function actionCreate()
    {
        $model = new Receipt();
        if (isset($_POST)) {
            $post = $_POST;
            unset($post['id']);
            if($post['companyId']==''){
                $msg = array('success'=>false,'msg'=>'缺省企业id');
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
        $model = new Receipt();
        if ($_POST) {
            $post = $_POST;
            if($post['companyId']==''){
                $msg = array('success'=>false,'msg'=>'缺省企业id');
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
        $model = new Receipt();
        $id = $_POST['id'];
        if ($model->deleteData($id)){
            $msg = array('success'=>true,'msg'=>'删除成功');
        }else{
            $msg = array('success'=>false,'msg'=>'删除失败');
        }
        exit(CJSON::encode($msg));
    }

} 