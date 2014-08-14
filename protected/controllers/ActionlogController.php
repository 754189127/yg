<?php

/**
 * 操作日志
 * Class CatalogController
 */
class ActionlogController extends Controller
{
    public $layout = '//layouts/column2';

    public function actionIndex()
    {
        $page = isset($_POST['page'])?intval($_POST['page']):1;
        $condition['page'] = $page;
        $data = Actionlog::model()->getList($condition);
        $arr = array('list'=>$data['list'],'paper'=>$data['paper']);
        echo CJSON::encode($arr);

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
        $model = new Actionlog();
        if ($model->deleteData()){
            $msg = array('success'=>true,'msg'=>'删除成功');
        }else{
            $msg = array('success'=>false,'msg'=>'删除失败');
        }
        exit(CJSON::encode($msg));
    }



}
