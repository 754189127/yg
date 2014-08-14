<?php


class ProductRecord extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{productrecord}}';
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
        if($condition['startDate']){
            $conStr .= ' and t.addDate>= '.strtotime($condition['startDate']);
        }
        if($condition['endDate']){
            $conStr .= ' and t.addDate<= '.strtotime($condition['endDate']);
        }
        $criteria = new CDbCriteria();
        $criteria->select='t.*,p.name,p.productCode,r.receiptCode,r.companyId';
        $criteria->join = ' join '.Product::model()->tableName().' p on(t.productId=p.id)'; //连接表
        $criteria->join = ' join '.Receipt::model()->tableName().' r on(t.receiptId=r.id)'; //连接表
        $criteria->addCondition($conStr);
        $criteria->order='t.id desc';
        $data = ProductRecord::model()->findAll($criteria);
        $list = array();
        if($data){
            foreach($data as $k=>$v){
                $list[$k]['id'] = $v['id'];
                $list[$k]['number'] = $v['number'];
                $list[$k]['remark'] = $v['remark'];
                $list[$k]['addDate'] = $v['addDate']?date('Y-m-d',$v['addDate']):'';
                $list[$k]['productCode'] = $v['productCode'];
                $list[$k]['name'] = $v['name'];
                $list[$k]['receiptCode'] = $v['receiptCode'];
            }
        }
        return $list;
    }

    public function saveData($data){
        $model = new ProductRecord();
         if(isset($data['id'])){
             $model = ProductRecord::model()->findByPk($data['id']);
         }else{
             $model->addDate = time();
         }
        $model->changeType = isset($data['changeType'])?$data['changeType']:1;
        $model->receiptId = isset($data['receiptId'])?$data['receiptId']:0;
        $model->productId = isset($data['productId'])?$data['productId']:0;
        $model->number = isset($data['number'])?$data['number']:0;
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
