<?php

class MemberController extends Controller
{
    public $layout = '//layouts/column2';

    public function actionIndex()
    {
        $condition = array(
            'userCode'=>isset($_POST['userCode'])?trim($_POST['userCode']):'',
            'realName'=>isset($_POST['realName'])?trim($_POST['realName']):'',
            'address'=>isset($_POST['address'])?trim($_POST['address']):'',
            'mobile'=>isset($_POST['mobile'])?trim($_POST['mobile']):'',
            'zipCode'=>isset($_POST['zipCode'])?trim($_POST['zipCode']):'',
            'beginDate'=>isset($_POST['beginDate'])?trim($_POST['beginDate']):'',
            'endDate'=>isset($_POST['endDate'])?trim($_POST['endDate']):'',
            'source'=>isset($_POST['source'])?trim($_POST['source']):'',
        );
        $list = Member::model()->getMembers($condition);

        $arr = array('list'=>$list);
        $str = CJSON::encode($arr);
        $callback = isset($_REQUEST['callback'])?$_REQUEST['callback']:'';
        if($callback){
        echo($callback.'('.$str.');');
        }else{
            echo $str;
        }

    }

    public function actionCatalog(){
        $model = new Catalog();
        $list = $model->getList();
        echo CJSON::encode(array('list'=>$list));
    }

    /*
     * 汇款订购记录
     */
    public function actionOrderremittance(){
        $memberId = isset($_GET['memberId'])?intval($_GET['memberId']):0;
        $model = new OrderRemittance();
        $list = $model->getListByMemberId($memberId);
        echo CJSON::encode(array('list'=>$list));
    }

    /*
     * 查看会员详细
     */
    public function actionView()
    {
        $memberId = isset($_GET['memberId'])?intval($_GET['memberId']):0;
        $item = $this->loadModel($memberId);
        //地址信息
        $model = new Memberaddrlib();
        $addressList = $model->getListByMemberId($memberId);
        echo CJSON::encode(array('info'=>$item,'addressList'=>$addressList));
    }

    /*
     * 添加会员
     */
    public function actionCreate()
    {
        $model = new Member();
        if ($_POST) {
            $post = $_POST;
            if ($model->saveMember($post))
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
