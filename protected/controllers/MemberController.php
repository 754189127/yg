<?php

class MemberController extends Controller
{
	public $layout='//layouts/column2';

    public function actionIndex()
    {
        $curPage = isset($_REQUEST['page'])?intval($_REQUEST['page']):1;
        $condition = '';
        $criteria = new CDbCriteria(array(
            'condition' => $condition,
            'order' => 'id desc'
        ));
        $count = Member::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);
        $items = Member::model()->findAll($criteria);
        echo (CJSON::encode($items));

    }

	public function actionView($id)
	{
        $item = $this->loadModel($id);
		echo CJSON::encode($item);exit;
	}

	public function actionCreate()
	{
		$model=new Member;
		if(isset($_POST['Member']))
		{
			$model->attributes=$_POST['Member'];
			if($model->save())
				exit(1);
            else
                exit(0);
		}
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if(isset($_POST['Member']))
		{
			$model->attributes=$_POST['Member'];
			if($model->save())
				exit(1);
            else
                exit(0);
		}
	}


	public function actionDelete($id)
	{
		if($this->loadModel($id)->delete())
            exit(1);
        else
            exit(0);
	}


	public function loadModel($id)
	{
		$model=Member::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


}
