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
            $model->attributes = '';
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
        $model = Periodical::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }


}
