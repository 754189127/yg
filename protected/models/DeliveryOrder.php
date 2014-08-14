<?php

/**
 * 出货单
 */
class DeliveryOrder extends CActiveRecord
{

	public $key;//序号
    public $deliveryOrderId;
    private $mailTimes;//补寄次数

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{deliveryorder}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
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
        if($condition['deliveryOrderCode']){
            $conStr .= ' and t.deliveryOrderCode like "%'.$condition['deliveryOrderCode'].'%"';
        }
        if($condition['periodicalId']){
            $conStr .= ' and t.periodicalId  ='.$condition['periodicalId'];
        }
        if($condition['userCode']){
            $conStr .= ' and t.userCode like "%'.$condition['userCode'].'%"';
        }
        if($condition['userName']){
            $conStr .= ' and t.userName like "%'.$condition['userName'].'%"';
        }
        $criteria = new CDbCriteria();
        $criteria->select='t.*,o.remitter,o.remittanceAmount,o.billNumber,o.orderCode,o.id as orderRemittanceId';
        $criteria->join = ' join '.OrderRemittance::model()->tableName().' o on(o.id=t.orderRemittanceId)'; //连接表
        $criteria->addCondition($conStr);
        $criteria->order='t.addDate desc';
        $list = DeliveryOrder::model()->findAll($criteria);
        $data = array();
        if($list){
            foreach($list as $k=>$v){
                $data[$k]['id'] = $v['id'];
                $data[$k]['orderRemittanceId'] = $v['orderRemittanceId'];
                $data[$k]['deliveryOrderCode'] = $v['deliveryOrderCode'];
                $data[$k]['billNumber'] = $v['billNumber'];
                $data[$k]['orderCode'] = $v['orderCode'];
                $data[$k]['remitter'] = $v['remitter'];
                $data[$k]['remittanceAmount'] = $v['remittanceAmount'];
            }
        }
        return $data;
    }


    public function saveData($data){
        $model = new DeliveryOrder();
        if(isset($data['id'])){
            $model =  DeliveryOrder::model()->findByPk($data['id']);
        }else{
            $model->deliveryOrderCode = isset($data['deliveryOrderCode'])?$data['deliveryOrderCode']:'';
            $model->orderRemittanceId = isset($data['orderRemittanceId'])?$data['orderRemittanceId']:0;
            $model->periodicalId = isset($data['periodicalId'])?$data['periodicalId']:1;
            $model->userCode = isset($data['userCode'])?$data['userCode']:'';
            $model->userName = isset($data['userName'])?$data['userName']:'';
            $model->addDate = time();
        }
        $model->totalSales = isset($data['totalSales'])?$data['totalSales']:0;
        $model->receivedRemittance = isset($data['receivedRemittance'])?$data['receivedRemittance']:0;
        $model->unDiscountAmount = isset($data['unDiscountAmount'])?$data['unDiscountAmount']:0;
        $model->preferentialTicket = isset($data['preferentialTicket'])?$data['preferentialTicket']:0;
        $model->discount = isset($data['discount'])?$data['discount']:'';
        $model->overpaidAmount = isset($data['overpaidAmount'])?$data['overpaidAmount']:0;
        $model->receivableAmount = isset($data['receivableAmount'])?$data['receivableAmount']:0;
        $model->deliveryMethod = isset($data['deliveryMethod'])?$data['deliveryMethod']:0;
        $model->mailingDate = isset($data['mailingDate'])?$data['mailingDate']:0;
        $model->weight = isset($data['weight'])?$data['weight']:0;
        $model->referPostage = isset($data['referPostage'])?$data['referPostage']:0;
        $model->postage = isset($data['postage'])?$data['postage']:0;
        $model->zipCode = isset($data['zipCode'])?$data['zipCode']:'';
        $model->address = isset($data['address'])?$data['address']:'';
        $model->remark = isset($data['remark'])?$data['remark']:'';
        return $model->save();
    }


    //获取邮寄包裹列表
     public function getListForPackage($condition){
         $conStr = 'deliveryOrderCode!=""';
         if($condition['deliveryOrderCode']){
            $conStr .= ' and deliveryOrderCode like "%'.$condition['deliveryOrderCode'].'%"';
        }
        if($condition['periodicalId']){
            $conStr .= ' and periodicalId  ='.$condition['periodicalId'];
        }
        if($condition['userCode']){
            $conStr .= ' and userCode like "%'.$condition['userCode'].'%"';
        }
        if($condition['userName']){
            $conStr .= ' and userName like "%'.$condition['userName'].'%"';
        }
		 if($condition['mailingDate']){
            $conStr .= ' and mailingDate = '.strtotime($condition['mailingDate']);
        }
        $criteria = new CDbCriteria();
         $criteria->addCondition($conStr);
         $criteria->order='addDate desc';
         $list = DeliveryOrder::model()->findAll($criteria);
		 $data = array();
         if($list){
             foreach($list as $k=>$v){
				$data[$k]['key'] = $k+1;
			    $data[$k]['id'] = $v['id'];
                $data[$k]['deliveryOrderCode'] = $v['deliveryOrderCode'];
                $data[$k]['packageCode'] = $v['packageCode'];
                $data[$k]['serialNumber'] = $v['serialNumber'];
                $data[$k]['mailingDate'] =$v['mailingDate']>0?date('Y-m-d',$v['mailingDate']):'';
                $data[$k]['weight'] = $v['weight'];
                $data[$k]['postage'] = $v['postage'];
                $data[$k]['packaging'] = $v['packaging'];
                $data[$k]['userName'] = $v['userName'];
                $data[$k]['address'] = $v['address'];
                $data[$k]['packageRemark'] = $v['packageRemark'];
             }
         }
         return $data;
     }

    public  function findByOrderRemittanceId($orderRemittanceId){
        return DeliveryOrder::model()->find('orderRemittanceId=:orderRemittanceId', array(':orderRemittanceId' => $orderRemittanceId));

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
