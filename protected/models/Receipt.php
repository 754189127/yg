<?php

/**
 * 进货单
 * Class   Receipt
 */
class Receipt extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{receipt}}';
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
        if($condition['companyId']){
            $conStr .= ' and companyId ='.$condition['companyId'];
        }
        if($condition['receiptCode']){
            $conStr .= ' and receiptCode like "%'.$condition['receiptCode'].'%"';
        }
        $criteria = new CDbCriteria();
        $criteria->addCondition($conStr);
        $criteria->order='id desc';
        $data =  Receipt::model()->findAll($criteria);
        return $data;
    }

    public function saveData($data){
        $model = new Receipt();
        if(isset($data['id'])){
            $model =  Receipt::model()->findByPk($data['id']);
        }else{
            $model->receiptCode = date('YmdHis');
            $model->companyId = isset($data['companyId'])?$data['companyId']:1;
            $model->addDate = time();
        }
        $model->purchaseAmount = isset($data['purchaseAmount'])?$data['purchaseAmount']:0;
        $model->receiptDate = isset($data['receiptDate'])?$data['receiptDate']:'';
        $model->remark = $data['remark'];
        return $model->save();
    }

    public function deleteData($id){
        $connection=Yii::app()->db;
        $transaction=$connection->beginTransaction();
        try{
             Product::model()->deleteAllByAttributes(array('receiptId'=>$id));
             Receipt::model()->deleteByPk($id);
            $transaction->commit();
            return true;
        }catch (Exception $e){
            $transaction->rollBack();
            return false;
        }
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
