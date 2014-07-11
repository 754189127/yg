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
        $list = Orderremittance::model()->getList();
        if($_GET['t']==1){
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
        $model = new Orderremittance();
        if (isset($_POST)) {
            if ($model->saveData($_POST)){
                $msg = array('success'=>true,'msg'=>'添加成功');
            }else{
                $msg = array('success'=>false,'msg'=>'添加失败');
            }
            exit(CJSON::encode($msg));
        }
    }
} 