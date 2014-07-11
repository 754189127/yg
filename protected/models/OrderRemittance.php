<?php

/**
 * 汇款订购记录
 * Class OrderRemittance
 */
class  OrderRemittance  extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{orderremittance}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

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
        if($condition['companyCode']){
            $conStr .= ' and companyCode like "%'.$condition['companyCode'].'%"';
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
        $data = Orderremittance::model()->findAll($criteria);
        return $data;
    }


    public function getListByMemberId($memberId)
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('memberId='.$memberId);
        $criteria->order='id desc';
        $data = OrderRemittance::model()->findAll($criteria);
        return $data;
    }


    public function saveData($data){
        $model = new Orderremittance();
        if(isset($data['id'])){
            $model =  Orderremittance::model()->findByPk($data['id']);
        }else{
            $model->periodicalId = isset($data['periodicalId'])?$data['periodicalId']:0;
            $model->memberId = isset($data['memberId'])?$data['memberId']:0;
            $model->userCode = isset($data['userCode'])?$data['userCode']:'';
            $model->userName = isset($data['userName'])?$data['userName']:'';
            $model->status =0;
            $model->addDate = time();
        }
        $model->billNumber = isset($data['billNumber'])?$data['billNumber']:'';
        $model->receiptProceedsOffice = isset($data['receiptProceedsOffice'])?$data['receiptProceedsOffice']:'';
        $model->remitter = isset($data['remitter'])?$data['remitter']:'';
        $model->remittanceAmount = isset($data['remittanceAmount'])?$data['remittanceAmount']:'';
        $model->remittanceDate = isset($data['remittanceDate'])?$data['remittanceDate']:0;
        $model->preferentialTicket = isset($data['preferentialTicket'])?$data['preferentialTicket']:'';
        $model->youthStuck = isset($data['youthStuck'])?$data['youthStuck']:0;
        $model->unDiscountAmount = isset($data['unDiscountAmount'])?$data['unDiscountAmount']:0;
        $model->source = isset($data['source'])?$data['source']:1;
        $model->postage = isset($data['postage'])?$data['postage']:0;
        $model->zipCode = isset($data['zipCode'])?$data['zipCode']:'';
        $model->address = isset($data['address'])?$data['address']:'';
        $model->isRemittanceReceived = isset($data['isRemittanceReceived'])?$data['isRemittanceReceived']:0;
        $model->remittanceReceivedDate = isset($data['remittanceReceivedDate'])?$data['remittanceReceivedDate']:0;
        $model->isOrderReceived = isset($data['isOrderReceived'])?$data['isOrderReceived']:0;
        $model->orderReceivedDate = isset($data['orderReceivedDate'])?$data['orderReceivedDate']:0;
        $model->remark = $data['remark'];
        return $model->save();
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
