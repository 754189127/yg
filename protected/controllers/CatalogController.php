<?php

class CatalogController extends Controller
{
    public $layout = '//layouts/column2';

    public function actionIndex()
    {

        $list = Catalog::model()->getList();
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
        $model = new Member;
        if (isset($_POST['Member'])) {
            $model->attributes = $_POST['Member'];
            if ($model->save())
                exit(1);
            else
                exit(0);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        if (isset($_POST['Member'])) {
            $model->attributes = $_POST['Member'];
            if ($model->save())
                exit(1);
            else
                exit(0);
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
        $model = Member::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }


}
