<?php

class PeriodicalController extends Controller
{
    public $layout = '//layouts/column2';

    public function actionIndex()
    {
        $list = Periodical::model()->getList();
        $arr = array('list'=>$list);
        echo CJSON::encode($arr);
    }



    public function actionCreate()
    {
        $model = new Periodical();
        if (isset($_POST)) {
            $post = $_POST;
            if($post['title']==''){
                $msg = array('success'=>false,'msg'=>'期数名称不能为空');
                exit(CJSON::encode($msg));
            }
            if($post['startDate']==''){
                $msg = array('success'=>false,'msg'=>'开始日期不能为空');
                exit(CJSON::encode($msg));
            }
            if($post['endDate']==''){
                $msg = array('success'=>false,'msg'=>'结束日期不能为空');
                exit(CJSON::encode($msg));
            }
            if ($model->saveData($post)){
                $msg = array('success'=>true,'msg'=>'保存成功');
            }else{
                $msg = array('success'=>false,'msg'=>'保存失败');
            }
            exit(CJSON::encode($msg));
        }
    }

    public function actionUpdate()
    {
        $model = new Periodical();
        if (isset($_POST)) {
            $post = $_POST;
            if($post['title']==''){
                $msg = array('success'=>false,'msg'=>'期数名称不能为空');
                exit(CJSON::encode($msg));
            }
            if($post['startDate']==''){
                $msg = array('success'=>false,'msg'=>'开始日期不能为空');
                exit(CJSON::encode($msg));
            }
            if($post['endDate']==''){
                $msg = array('success'=>false,'msg'=>'结束日期不能为空');
                exit(CJSON::encode($msg));
            }
            if ($model->saveData($post)){
                $msg = array('success'=>true,'msg'=>'保存成功');
            }else{
                $msg = array('success'=>false,'msg'=>'保存失败');
            }
            exit(CJSON::encode($msg));
        }
    }





    public function loadModel($id)
    {
        $model = Periodical::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }


}
