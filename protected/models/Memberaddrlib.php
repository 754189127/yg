<?php

/**
 * This is the model class for table "{{memberaddrlib}}".
 *
 * The followings are the available columns in table '{{memberaddrlib}}':
 * @property string $id
 * @property integer $memberId
 * @property integer $type
 * @property string $address
 * @property string $zipCode
 * @property string $mobile
 * @property string $consignee
 * @property integer $isDefault
 */
class Memberaddrlib extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{memberaddrlib}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('memberId', 'required'),
			array('memberId, type, isDefault', 'numerical', 'integerOnly'=>true),
			array('address', 'length', 'max'=>100),
			array('zipCode', 'length', 'max'=>6),
			array('mobile, consignee', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, memberId, type, address, zipCode, mobile, consignee, isDefault', 'safe', 'on'=>'search'),
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
			'memberId' => '会员id',
			'type' => '地址分类（1-家庭，2-学校）',
			'address' => '地址',
			'zipCode' => '邮编',
			'mobile' => '电话',
			'consignee' => '收货人',
			'isDefault' => '默认地址（0-否，1-是）',
		);
	}


    /**
     * 获取用户地址
     * @param $condition
     * @param int $number
     */
    public function getMemberAddr($condition,$number=2)
    {
        $conStr = '1=1';
        if($condition['memberId']){
            $conStr .=' and memberId='.$condition['memberId'];
        }
        if($condition['address']){
            $conStr .= ' and address like "%'.$condition['address'].'%"';
        }
        if($condition['mobile']){
            $conStr .= ' and mobile like "%'.$condition['mobile'].'%"';
        }
        if($condition['zipCode']){
            $conStr .= ' and zipCode like "%'.$condition['zipCode'].'%"';
        }
        $criteria = new CDbCriteria();
        $criteria->select = '*';
        $criteria->addCondition($conStr);
        $criteria->order='isDefault desc,id asc';
        $criteria->limit=$number;
        $data = Memberaddrlib::model()->findAll($criteria);
        return $data;
    }

    public function getListByMemberId($memberId){
        $criteria = new CDbCriteria();
        $criteria->addCondition('memberId='.$memberId);
        $criteria->order='isDefault desc,id asc';
        $data = Memberaddrlib::model()->findAll($criteria);
        return $data;
    }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
