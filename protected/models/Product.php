<?php

/**
 * 产品
 * Class   Product
 */
class Product extends CActiveRecord
{
    public  $companyId;
    public $companyCode;
    public $address;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{product}}';
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
        if($condition['productCode']){
            $conStr .= ' and productCode like "%'.$condition['productCode'].'%"';
        }

        $criteria = new CDbCriteria();
        $criteria->addCondition($conStr);
        $criteria->order='id desc';
        $list = Product::model()->findAll($criteria);
        $data = array();
        if($list){
            foreach($list as $k=>$v){
                $data[$k]['id'] = $v['id'];
                $data[$k]['productCode'] = $v['productCode'];
                $data[$k]['name'] = $v['name'];
                $data[$k]['number'] = $v['number'];
                $data[$k]['price'] = $v['price'];
                $data[$k]['bagShape'] = $v['bagShape'];
                $data[$k]['purchasePrice'] = $v['purchasePrice'];
                $data[$k]['weight'] = $v['weight'];
                $data[$k]['specification'] = $v['specification'];
                $data[$k]['safetyStock'] = $v['safetyStock'];
                $data[$k]['status'] = $v['status'];
                $data[$k]['remark'] = $v['remark'];
                $data[$k]['cardinalNumber'] = $v['cardinalNumber'];
                $data[$k]['content'] = $v['content'];
                $data[$k]['addDate'] = $v['addDate']?date('Y-m-d',$v['addDate']):'';
                $company = Company::model()->findByPk($v['companyId']);
                $data[$k]['companyId'] = $v['companyId'];
                $data[$k]['companyCode'] = $company['companyCode'];
                $data[$k]['address'] = $company['address'];

            }
        }

        return $data;
    }


    public function saveData($data){
        $model = new Product();
        if(isset($data['id'])){
            $model =  Product::model()->findByPk($data['id']);
        }else{
            $model->productCode = $data['productCode'];
            $model->companyId = $data['companyId'];
            $model->number = isset($data['number'])?$data['number']:0;
            $model->status = 1;
            $model->addDate = time();
        }
        $model->name = isset($data['name'])?$data['name']:'';
        $model->price = isset($data['price'])?$data['price']:0;
        $model->purchasePrice = isset($data['purchasePrice'])?$data['purchasePrice']:0;
        $model->bagShape = isset($data['bagShape'])?$data['bagShape']:'';
        $model->weight = isset($data['weight'])?$data['weight']:0;
        $model->cardinalNumber = isset($data['cardinalNumber'])?$data['cardinalNumber']:1;
        $model->content = isset($data['content'])?$data['content']:'';
        $model->safetyStock=isset($data['safetyStock'])?$data['safetyStock']:1;
        return $model->save();
    }



    /*
   * 根据产品编号获取产品
   */
    public function findByProductCode($productCode)
    {
        return Product::model()->find('productCode=:productCode', array(':productCode' => $productCode));
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
