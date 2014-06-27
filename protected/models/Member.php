<?php

/**
 * This is the model class for table "{{member}}".
 *
 * The followings are the available columns in table '{{member}}':
 * @property integer $id
 * @property string $userCode
 * @property string $password
 * @property string $email
 */
class Member extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{member}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userCode, password, email', 'required'),
			array('userCode, password, email', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, userCode, password, email', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'userCode' => 'userCode',
			'password' => 'Password',
			'email' => 'Email',
		);
	}

    /**
     * 获取会员
     */
    public function getMembers($condition=array())
    {
        $conStr = '1=1';
        if($condition['userCode']){
            $conStr .= ' and userCode like "%'.$condition['userCode'].'%"';
        }
        if($condition['realName']){
            $conStr .= ' and realName like "%'.$condition['realName'].'%"';
        }
        if($condition['source']){
            $conStr .= ' and source like ='.$condition['source'];
        }
        $criteria = new CDbCriteria();
        $criteria->select = 'id,userCode,realName,status';
        $criteria->addCondition($conStr);
        $criteria->order='id desc';
        $items = Member::model()->findAll($criteria);
        $data = array();
        if($items){
            foreach($items as $k=>$val){
                $condition['memberId'] = $val['id'];
                $addrList =Memberaddrlib::model()->getMemberAddr($condition,2);
                if(($condition['address'] || $condition['mobile'] || $condition['zipCode']) && !$addrList){
                    unset($data[$k]);
                }else{
                    $data[$k]['addrList'] = $addrList;
                    $data[$k]['id'] = $val['id'];
                    $data[$k]['userCode'] = $val['userCode'];
                    $data[$k]['realName'] = $val['realName'];
                    $data[$k]['status'] = $val['status'];
                }
            }
        }
        return $data;
    }


    public function saveMember($data){
        $model = new Member();
        $model->periodicalId = $data['periodicalId'];
        $model->userCode = date(YmdHis);
        $model->realName = $data['realName'];
        $model->source = $data['source'];
        $model->sex = $data['sex']?$data['sex']:1;
        $model->birth = $data['birth'];
        $model->status = $data['status']?$data['status']:1;
        $model->isAgent = $data['isAgent'];
        $model->addDate = time();
        return $model->save();
    }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Member the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
