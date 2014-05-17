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
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('memberId',$this->memberId);
		$criteria->compare('type',$this->type);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('zipCode',$this->zipCode,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('consignee',$this->consignee,true);
		$criteria->compare('isDefault',$this->isDefault);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Memberaddrlib the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
