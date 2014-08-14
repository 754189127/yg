<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 14-8-7
 * Time: 下午10:50
 */

class BusinessController extends BaseController{
    public function init(){
        parent::init();
    }
    public $layout='//layouts/column1';

    /*
     * 会员列表
     */
    public function actionMemberlist()
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
            'memberType'=>0
        );
        $list = Member::model()->getMembers($condition);
        if($list){
            foreach($list as $k=>$v){
                $list[$k]['source'] =  $v['source']?$this->_setting['memberSource'][$v['source']]:'';
            }
        }
        $arr = array('list'=>$list);
        echo CJSON::encode($arr);
    }


   /*
    * 添加修改业务
    */
    public function actionSave()
    {
        $model = new Member();
        if ($_POST) {
            $post = $_POST;
            $post['memberType'] = 0;
            if($post['realName']==''){
                $msg = array('success'=>false,'msg'=>'会员姓名不能为空');
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
        $model = new Orderremittance();
        if (isset($_POST)) {
            $post = $_POST;
            if($post['periodicalId']==''){
                $msg = array('success'=>false,'msg'=>'期数不能为空');
                exit(CJSON::encode($msg));
            }
            if($post['memberId']==''){
                $msg = array('success'=>false,'msg'=>'会员不能为空');
                exit(CJSON::encode($msg));
            }
            if ($model->saveData($post)){
                $msg = array('success'=>true,'msg'=>'修改成功');
            }else{
                $msg = array('success'=>false,'msg'=>'修改失败');
            }
            exit(CJSON::encode($msg));
        }
    }



    public function actionView()
    {
        $model = new Orderremittance();
        $id = $_POST['id'];
        $data = $model->findByPk($id);
        exit(CJSON::encode(array('info'=>$data)));
    }

    public function actionDelete()
    {
        $model = new Orderremittance();
        $id = $_POST['id'];
        if ($model->deleteByPk($id)){
            $msg = array('success'=>true,'msg'=>'删除成功');
        }else{
            $msg = array('success'=>false,'msg'=>'删除失败');
        }
        exit(CJSON::encode($msg));
    }
} 