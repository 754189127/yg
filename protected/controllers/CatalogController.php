<?php

/**
 * 目录
 * Class CatalogController
 */
class CatalogController extends Controller
{
    public $layout = '//layouts/column2';

    public function actionIndex()
    {
        $page = isset($_POST['page'])?intval($_POST['page']):1;
        $condition['page'] = $page;
        $list = Catalog::model()->getList($condition);
        $arr = array('list'=>$list);
        $str = CJSON::encode($arr);
        $callback = isset($_REQUEST['callback'])?$_REQUEST['callback']:'';
        if($callback){
        echo($callback.'('.$str.');');
        }else{
            echo $str;
        }

    }

    public function actionCreate()
    {
        $model = new Catalog();
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
        $model = new Catalog();
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
        $model = new Catalog();
        $id = $_POST['id'];
        if ($model->deleteData($id)){
            $msg = array('success'=>true,'msg'=>'删除成功');
        }else{
            $msg = array('success'=>false,'msg'=>'删除失败');
        }
        exit(CJSON::encode($msg));
    }


    public function loadModel($id)
    {
        $model = Member::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }


}
