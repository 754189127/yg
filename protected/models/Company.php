<?php

/**
 * 厂商
 * Class Company
 */
class Company extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{company}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('id', 'required'),
            //array('address', 'length', 'max'=>100),
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




    public function getList($condition)
    {
        $conStr = '1=1';
        if($condition['periodicalId']){
            $conStr .= ' and periodicalId ='.$condition['periodicalId'];
        }
        if($condition['companyCode1'] && $condition['companyCode2']){
            $conStr .= ' and companyCode >= '.$condition['companyCode1'].' and companyCode <= '.$condition['companyCode2'];
        }else if($condition['companyCode1'] && $condition['companyCode2']==''){
            $conStr .= ' and companyCode like "%'.$condition['companyCode1'].'%"';
        }else if($condition['companyCode2'] && $condition['companyCode1']==''){
            $conStr .= ' and companyCode like "%'.$condition['companyCode2'].'%"';
        }
        if($condition['address']){
            $conStr .= ' and address like "%'.$condition['address'].'%"';
        }
        if($condition['productCode']){
            $conStr .= ' and productCode like "%'.$condition['productCode'].'%"';
        }
        $criteria = new CDbCriteria();
        $criteria->addCondition($conStr);
        $criteria->order='id desc';
        $data = Company::model()->findAll($criteria);
        return $data;
    }

    public function saveData($data){
        $model = new Company();
         if(isset($data['id'])){
             $model = Company::model()->findByPk($data['id']);
         }else{
             $model->companyCode = date('YmdHis');
             $model->addDate = time();
         }
        $model->periodicalId = isset($data['periodicalId'])?$data['periodicalId']:1;
        $model->title = isset($data['title'])?$data['title']:'';
        $model->linkMan = isset($data['linkMan'])?$data['linkMan']:'';
        $model->address = isset($data['address'])?$data['address']:'';
        $model->productClass =  isset($data['productClass'])?$data['productClass']:'';
        $model->zipCode = isset($data['zipCode'])?$data['zipCode']:'';
        $model->mobile1 = isset($data['mobile1'])?$data['mobile1']:'';
        $model->mobile2 = isset($data['mobile2'])?$data['mobile2']:'';
        $model->qq = isset($data['mobile2'])?$data['qq']:'';
        $model->email = isset($data['email'])?$data['email']:'';
        $model->website = isset($data['website'])?$data['website']:'';
        $model->openingBank = isset($data['openingBank'])?$data['openingBank']:'';
        $model->openingAccount = isset($data['openingAccount'])?$data['openingAccount']:0;
        $model->remark = $data['remark'];
         return $model->save();
    }

      public function findByCompanyCode($companyCode){
          return Company::model()->find('companyCode=:companyCode', array(':companyCode' => $companyCode));
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
