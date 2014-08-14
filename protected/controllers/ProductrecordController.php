<?php

class ProductrecordController extends BaseController
{
    public $layout = '//layouts/column2';

    public function init(){
        parent::init();
    }

    public function actionIndex()
    {
        $condition = array(
            'startDate'=>isset($_POST['startDate'])?trim($_POST['startDate']):0,
            'endDate'=>isset($_POST['endDate'])?trim($_POST['endDate']):0
        );
        $list = ProductRecord::model()->getList($condition);
        $arr = array('list'=>$list);
        echo CJSON::encode($arr);
    }

    public function actionCreate()
    {
        $model = new Company();
        if (isset($_POST)) {
            if ($model->saveData($_POST)){
                $msg = array('success'=>true,'msg'=>'厂商添加成功');
            }else{
                $msg = array('success'=>false,'msg'=>'厂商保存失败');
            }
            exit(CJSON::encode($msg));
        }
    }

    public function actionView()
    {
        $companyId = isset($_GET['companyId'])?intval($_GET['companyId']):0;
        $item = $this->loadModel($companyId);
        echo CJSON::encode(array('info'=>$item));
    }


    public function actionUpdate($id)
    {
        $model = new Company();
        if (isset($_POST)) {
            if ($model->saveData($_POST)){
                $msg = array('success'=>true,'msg'=>'厂商修改成功');
            }else{
                $msg = array('success'=>false,'msg'=>'厂商修改失败');
            }
            exit(CJSON::encode($msg));
        }
    }


    public function actionDelete($id)
    {
        if ($this->loadModel($id)->delete())
            exit(1);
        else
            exit(0);
    }


    public function loadModel($id)
    {
        $model = Company::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }


}
