<?php

/**
 * This is the model class for table "{{member}}".
 *
 * The followings are the available columns in table '{{member}}':
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
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
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
                    $data[$k]['id'] = $val['id'];
                    $data[$k]['userCode'] = $val['userCode'];
                    $data[$k]['realName'] = $val['realName'];
                    $data[$k]['status'] = $val['status'];
                    if(count($addrList)==1){
                        $data[$k]['address1'] = $addrList[0]['address'];
                        $data[$k]['address2'] = '';
                    }elseif(count($addrList)>1){
                        $data[$k]['address1'] = $addrList[0]['address'];
                        $data[$k]['address2'] = $addrList[1]['address'];
                    }else{
                        $data[$k]['address1'] = '';
                        $data[$k]['address2'] = '';
                    }
                }
            }
        }
        return $data;
    }

    public function getMemberById($memberId){
        $data = Member::model()->findByPk($memberId);
        if($data){
            $data['birth'] = $data['birth']?date('Y-m-d',$data['birth']):'';
            $data['graduateDate'] = $data['graduateDate']?date('Y-m-d',$data['graduateDate']):'';
            $data['addDate'] = $data['addDate']?date('Y-m-d',$data['addDate']):'';
        }
        return $data;
    }

    public function saveMember($data){
        $model = new Member();
        $model->periodicalId = isset($data['periodicalId'])?$data['periodicalId']:1;
        $model->userCode = date('YmdHis');
        $model->realName = $data['realName'];
        $model->source = isset($data['source'])?$data['source']:1;
        $model->sex = isset($data['sex'])?$data['sex']:1;
        $model->birth =  isset($data['birth'])?$data['birth']:0;
        $model->status = isset($data['status'])?$data['status']:1;
        $model->isAgent = isset($data['isAgent'])?$data['isAgent']:0;
        $model->addDate = time();
        return $model->save();
    }

    /*
     * 修改会员
     */
    public function updateMember($data){
        if(!$data['id']) return false;
        $model = Member::model()->findByPk($data['id']);
        $model->periodicalId = isset($data['periodicalId'])?$data['periodicalId']:1;
        $model->userCode = date('YmdHis');
        $model->realName = $data['realName'];
        $model->source = isset($data['source'])?$data['source']:1;
        $model->sex = isset($data['sex'])?$data['sex']:1;
        $model->birth =  isset($data['birth'])?$data['birth']:0;
        $model->status = isset($data['status'])?$data['status']:1;
        $model->isAgent = isset($data['isAgent'])?$data['isAgent']:0;
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
