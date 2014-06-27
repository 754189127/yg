<?php
class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * 登录
	 */
	public function actionLogin()
	{
        $model=new Manager('login');
        if(isset($_POST['username']) && isset($_POST['password']))
        {
            $post['username'] = trim($_POST['username']);
            $post['password'] = trim($_POST['password']);

            $model->attributes = $post;
            if($model->validate()){
                $result =  $model->login();
                $msg = array('success'=>false,'errors'=>array('msg'=>'登录账号或密码有误'));
                if($result){
                    $msg = array('success'=>true,'msg'=>'');
                    //$this->redirect( $this->createUrl('member/index'));
                }
                exit(CJSON::encode($msg));
            }
        }
        $this->render('login',array('model'=>$model));
	}

    /**
     * 检测是否登录
     */
    public function actionIslogin(){
       $msg = array('success'=>false,'errors'=>array('msg'=>'未登录'));
       if( Yii::app()->user->getState('userId') ){
           $msg = array('success'=>true,'msg'=>'');
       }
        echo(CJSON::encode($msg));
    }
    /**
     * 修改用户登录密码
     */
    public function actionUpdate()
    {
        $newPassword = $_POST['password']?trim($_POST['password']):'';
        if($newPassword){
            exit('-1');
        }
        $userId = Yii::app()->user->getState('userId');
        $model = $this->loadModel($userId);
        $model->PASSWORD = md5($newPassword);
        if ($model->save())
            exit(1);
        else
            exit(0);
    }

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}