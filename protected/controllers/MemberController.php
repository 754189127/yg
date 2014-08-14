<?php

/**
 * 会员
 * Class MemberController
 */
class MemberController extends BaseController
{
    public $layout = '//layouts/column2';

    public function init(){
        parent::init();
    }
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
            'memberType'=>2
        );
        $list = Member::model()->getMembers($condition);
        if($list){
            foreach($list as $k=>$v){
                $list[$k]['source'] =  $v['source']?$this->_setting['memberSource'][$v['source']]:'';
            }
        }
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
     * 电话订购
     */
      public function actionIncomingtelegram(){
          $memberId = isset($_POST['memberId'])?intval($_POST['memberId']):0;
          $model = new Incomingtelegram();
          $list = $model->getList($memberId);
          echo CJSON::encode(array('list'=>$list));
      }

    /*
     * 汇款订购记录
     */
    public function actionOrderremittance(){
        $memberId = isset($_GET['memberId'])?intval($_GET['memberId']):0;
        $model = new OrderRemittance();
        $list = $model->getListByMemberId($memberId);
        if($list){
            foreach($list as $k=>$v){
                $list[$k]['deliveryMethod'] = $v['deliveryMethod']?$this->_setting['sendMethord'][$v['deliveryMethod']]:'';
                $list[$k]['paymentMethord'] = $v['paymentMethord']?$this->_setting['paymentMethord'][$v['paymentMethord']]:'';
                $list[$k]['source'] = $v['source']?$this->_setting['memberSource'][$v['source']]:'';
              }
        }
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
            if($post['memberType']==''){
                $msg = array('success'=>false,'msg'=>'会员类型不能为空');
                exit(CJSON::encode($msg));
            }
            if($post['realName']==''){
                $msg = array('success'=>false,'msg'=>'会员姓名不能为空');
                exit(CJSON::encode($msg));
            }
            if($post['deliveryMethod']==''){
                $msg = array('success'=>false,'msg'=>'寄送方式不能为空');
                exit(CJSON::encode($msg));
            }

            if($post['zipCode']==''){
                $msg = array('success'=>false,'msg'=>'邮编不能为空');
                exit(CJSON::encode($msg));
            }
            if ($model->saveMember($post)){
                $msg = array('success'=>true,'msg'=>'会员添加成功');
            }else{
                $msg = array('success'=>false,'msg'=>'数据保存失败');
            }
            exit(CJSON::encode($msg));
        }
    }

    public function actionUpdate()
    {
        $model = new Member();
        if ($_POST) {
            $post = $_POST;
            if($post['memberType']==''){
                $msg = array('success'=>false,'msg'=>'会员类型不能为空');
                exit(CJSON::encode($msg));
            }
            if($post['realName']==''){
                $msg = array('success'=>false,'msg'=>'会员姓名不能为空');
                exit(CJSON::encode($msg));
            }
            if($post['deliveryMethod']==''){
                $msg = array('success'=>false,'msg'=>'寄送方式不能为空');
                exit(CJSON::encode($msg));
            }
            if($post['zipCode']==''){
                $msg = array('success'=>false,'msg'=>'邮编不能为空');
                exit(CJSON::encode($msg));
            }
            if ($model->updateMember($post)){
                $msg = array('success'=>true,'msg'=>'会员修改成功');
            }else{
                $msg = array('success'=>false,'msg'=>'数据修改失败');
            }
            exit(CJSON::encode($msg));
        }
    }


    public function actionDelete($id)
    {
        $model = new Member();
        $count = OrderRemittance::model()->count('memberId=:memberId',array(':memberId'=>$id));
        if($count>0){
            $msg = array('success'=>false,'msg'=>'该会员有订单信息，请先删除相关内容');
        }else{
            if ($model->deleteByPk($id)){
                $msg = array('success'=>true,'msg'=>'会员删除成功');
            }else{
                $msg = array('success'=>false,'msg'=>'数据删除失败');
            }
        }
        exit(CJSON::encode($msg));
    }


    public function loadModel($id)
    {
        $model = Member::model()->getMemberById($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }


}
