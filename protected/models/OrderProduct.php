<?php
/**
 * 汇款订购产品详情
 * User: kevin
 * Date: 14-7-16
 * Time: 下午8:45
 */

class OrderProduct   extends CActiveRecord{
	
	public $orderremittanceId;
	
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{orderproduct}}';
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

    /**
     * 根据汇款订购单查看订单产品详情
     * @param $condition
     * @return CActiveRecord[]
     */
    public function getOrderProduct($condition)
    {
        $conStr = '1=1';
        if($condition['orderRemittanceId']){
            $conStr .= ' and orderRemittanceId  ='.$condition['orderRemittanceId'];
        }
        if($condition['productCode']){
            $conStr .= ' and productCode like "%'.$condition['productCode'].'%"';
        }
        if($condition['number']){
            $conStr .= ' and number ='.$condition['number'] ;
        }
        if($condition['remark']){
            $conStr .= ' and remark like "%'.$condition['remark'].'%"';
        }
        $criteria = new CDbCriteria();
        $criteria->addCondition($conStr);
        $criteria->order='id desc';
        $data = OrderProduct::model()->findAll($criteria);
        return $data;
    }


    public function saveData($data,$product){
        $model = new OrderProduct();
        if(isset($data['id'])){
            $model =  OrderProduct::model()->findByPk($data['id']);
        }else{
            $model->orderremittanceId = isset($data['orderremittanceId'])?$data['orderremittanceId']:0;
            $model->productId = isset($product['id'])?$product['id']:0;
            $model->name = isset($product['name'])?$product['name']:'';
            $model->productCode = isset($product['productCode'])?$product['productCode']:'';
            $model->price = isset($product['price'])?$product['price']:0;
            $model->weight = isset($product['weight'])?$product['weight']:0;
            $model->addDate = time();
        }
        $model->number = isset($data['number'])?$product['number']:0;
        $model->amount = $model->number*$model->price;
        $model->remark = isset($data['remark'])?$data['remark']:'';
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