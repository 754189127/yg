<?php

/**
 * 汇款订购记录
 * Class OrderRemittance
 */
class  OrderRemittance  extends CActiveRecord
{
    public $deliveryOrderId;
    public $deliveryOrderCode;
    public $totalSales;
    public $discount;
    public $overpaidAmount;
    public $receivableAmount;
    public $receivedRemittance;
    public $periodicalName;
    public $mailingDate;//邮寄日期
    public $packageCode;//包裹编号
	public $key;


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
        if($condition['billNumber']){
            $conStr .= ' and billNumber like "%'.$condition['billNumber'].'%"';
        }
        if($condition['userCode']){
            $conStr .= ' and userCode like "%'.$condition['userCode'].'%"';
        }
        if($condition['userName']){
            $conStr .= ' and userName like "%'.$condition['userName'].'%"';
        }
        if($condition['address']){
            $conStr .= ' and address like "%'.$condition['address'].'%"';
        }
        if($condition['zipCode']){
            $conStr .= ' and zipCode like "%'.$condition['zipCode'].'%"';
        }
        if(isset($condition['paymentMethord']) && $condition['paymentMethord']!=''){
            $conStr .= ' and paymentMethord = '.$condition['paymentMethord'];
        }
        $criteria = new CDbCriteria();
        $criteria->addCondition($conStr);
        $criteria->order='id desc';
        $data = Orderremittance::model()->findAll($criteria);
        if($data){
            foreach($data as $k=>$v){
                $data[$k]['isOrderReceived'] = $v['isOrderReceived']==1?'是':'否';
                $data[$k]['isRemittanceReceived'] = $v['isRemittanceReceived']==1?'是':'否';
                $data[$k]['remittanceDate'] = $v['remittanceDate']?date('Y-m-d',$v['remittanceDate']):'';
                $data[$k]['orderReceivedDate'] = $v['orderReceivedDate']?date('Y-m-d',$v['orderReceivedDate']):'';
                $data[$k]['remittanceReceivedDate'] = $v['remittanceReceivedDate']?date('Y-m-d',$v['remittanceReceivedDate']):'';
            }
        }
        return $data;
    }

    /**
     * 获取已收费的会员订购单（出货单）
     * @param $condition
     * @return array
     */
    public function getListForDelivery($condition)
    {
        $conStr = '1=1';
        if($condition['deliveryOrderCode']){
            $conStr .= ' and d.deliveryOrderCode like "%'.$condition['deliveryOrderCode'].'%"';
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
        $criteria->select='t.*,d.id as deliveryOrderId,d.deliveryOrderCode';
        $criteria->join = ' join '.DeliveryOrder::model()->tableName().' d on(t.id=d.orderRemittanceId)'; //连接表
        $criteria->addCondition($conStr);
        $criteria->order='t.addDate desc';
        $list = OrderRemittance::model()->findAll($criteria);
        $data = array();
        if($list){
            foreach($list as $k=>$v){
				$data[$k]['key'] = $k+1;
                $data[$k]['deliveryOrderId'] = $v['deliveryOrderId'];
                $data[$k]['deliveryOrderCode'] = $v['deliveryOrderCode'];
                $data[$k]['orderRemittanceId'] = $v['id'];
                $data[$k]['userCode'] = $v['userCode'];
                $data[$k]['userName'] = $v['userName'];
                $data[$k]['totalSales'] = $v['totalSales']?$v['totalSales']:0;
                $data[$k]['receivedRemittance'] = $v['receivedRemittance']?$v['receivedRemittance']:0;
                $data[$k]['postage'] = $v['postage']?$v['postage']:0;
                $data[$k]['overpaidAmount'] = $v['overpaidAmount']?$v['overpaidAmount']:0;
                $data[$k]['unDiscountAmount'] = $v['unDiscountAmount']?$v['unDiscountAmount']:0;
                $data[$k]['receivableAmount'] = $v['receivableAmount']?$v['receivableAmount']:0;
                $data[$k]['preferentialTicket'] = $v['preferentialTicket']?$v['preferentialTicket']:0;
                $data[$k]['billNumber'] = $v['billNumber']?$v['billNumber']:0;
                $data[$k]['orderCode'] = $v['orderCode'];
                $data[$k]['remitter'] = $v['remitter'];
                $data[$k]['remittanceAmount'] = $v['remittanceAmount'];
                //期数
                $periodical = Periodical::model()->findByPk($v['periodicalId']);
                $data[$k]['periodicalName'] = $periodical['title'];
                $data[$k]['periodicalId'] = $periodical['id'];
            }
        }
        return $data;
    }

    public function getListByMemberId($memberId)
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('memberId='.$memberId);
        $criteria->order='id desc';
        $list = OrderRemittance::model()->findAll($criteria);
        $data = array();
        if($list){
            foreach($list as $k=>$v){
                $data[$k]['key'] = $k+1;
                $data[$k]['id'] = $v['id'];
                $data[$k]['userCode'] = $v['userCode'];
                $data[$k]['userName'] = $v['userName'];
                $data[$k]['billNumber'] = $v['billNumber'];
                $data[$k]['receiptProceedsOffice'] = $v['receiptProceedsOffice'];
                $data[$k]['remitter'] = $v['remitter'];
                $data[$k]['remittanceAmount'] = $v['remittanceAmount'];
                $data[$k]['remittanceDate'] = $v['remittanceDate']?date('Y-m-d',$v['remittanceDate']):'';
                $data[$k]['preferentialTicket'] = $v['preferentialTicket'];
                $data[$k]['youthStuck'] = $v['youthStuck'];
                $data[$k]['unDiscountAmount'] = $v['unDiscountAmount'];
                $data[$k]['source'] = $v['source'];
                $data[$k]['postage'] = $v['postage'];
                $data[$k]['zipCode'] = $v['zipCode'];
                $data[$k]['address'] = $v['address'];
                $data[$k]['isRemittanceReceived'] = $v['isRemittanceReceived']==1?'是':'否';
                $data[$k]['remittanceReceivedDate'] = $v['remittanceReceivedDate']?date('Y-m-d',$v['remittanceReceivedDate']):'';
                $data[$k]['isOrderReceived'] = $v['isOrderReceived']==1?'是':'否';
                $data[$k]['orderReceivedDate'] = $v['orderReceivedDate']?date('Y-m-d',$v['orderReceivedDate']):'';
                $periodicalData = Periodical::model()->findByPk($v['periodicalId']);
                $data[$k]['periodicalName'] = $periodicalData['title'];
                $data[$k]['periodicalId'] = $periodicalData['id'];
                $data[$k]['deliveryMethod'] = $v['deliveryMethod'];
                $data[$k]['paymentMethord'] = $v['paymentMethord'];
                $data[$k]['mailingDate'] ='';
                $data[$k]['packageCode'] = '';
                $data[$k]['mailTimes'] = 0;
                //出货单信息
                $deliveryOrder = DeliveryOrder::model()->findByOrderRemittanceId($v['id']);
                if($deliveryOrder){
                    //包裹单信息
                    $package = Package::model()->findByDeliveryOrderId($deliveryOrder['id']);
                    if($package){
                        $data[$k]['mailingDate'] =$package['mailingDate']?date('Y-m-d',$package['mailingDate']):'';
                        $data[$k]['packageCode'] = $package['packageCode'];
                    }
                }


            }
        }
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
        $model->remittanceDate = isset($data['remittanceDate'])?strtotime($data['remittanceDate']):0;
        $model->preferentialTicket = isset($data['preferentialTicket'])?$data['preferentialTicket']:'';
        $model->youthStuck = isset($data['youthStuck'])?$data['youthStuck']:0;
        $model->unDiscountAmount = isset($data['unDiscountAmount'])?$data['unDiscountAmount']:0;
        $model->source = isset($data['source'])?$data['source']:1;
        $model->postage = isset($data['postage'])?$data['postage']:0;
        $model->zipCode = isset($data['zipCode'])?$data['zipCode']:'';
        $model->address = isset($data['address'])?$data['address']:'';
        $model->isRemittanceReceived = isset($data['isRemittanceReceived'])?$data['isRemittanceReceived']:0;
        $model->remittanceReceivedDate = isset($data['remittanceReceivedDate'])?strtotime($data['remittanceReceivedDate']):0;
        $model->isOrderReceived = isset($data['isOrderReceived'])?$data['isOrderReceived']:0;
        $model->orderReceivedDate = isset($data['orderReceivedDate'])?$data['orderReceivedDate']:0;
        $model->remark = isset($data['remark'])?$data['remark']:'';
        return $model->save();
    }

    public function getInfoById($id){
        $data = OrderRemittance::model()->findByPk($id);
        return $data;
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
