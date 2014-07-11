<?php


class Catalog extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{catalog}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id', 'required'),
            array('address', 'length', 'max'=>100),
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
            'id' => 'ID',
            'catalogCode' => '会员id',
            'catalogDate' => '地址分类（1-家庭，2-学校）',
            'address' => '地址',
            'mobile' => '电话',
        );
    }





    public function getList($number=0)
    {
        $criteria = new CDbCriteria();
        $criteria->order='id desc';
        if($number){
            $criteria->limit=$number;
        }
        $data = Catalog::model()->findAll($criteria);
        return $data;
    }
    public function saveData($data){
        $model = new Catalog();
        if(isset($data['id'])){
            $model =  Catalog::model()->findByPk($data['id']);
        }else{
            $model->catalogCode = date('YmdHis');
            $model->addDate = time();
        }
        $model->catalogDate = isset($data['catalogDate'])?$data['catalogDate']:0;
        $model->number = isset($data['number'])?$data['number']:0;
        $model->totalAmount = isset($data['totalAmount'])?$data['totalAmount']:0;
        $model->price = isset($data['price'])?$data['price']:0;
        $model->makeCompany = isset($data['makeCompany'])?$data['makeCompany']:'';
        $model->linkMan = isset($data['linkMan'])?$data['linkMan']:'';
        $model->mobile = isset($data['mobile'])?$data['mobile']:'';
        $model->address = isset($data['address'])?$data['address']:'';
        $model->remark = isset($data['remark'])?$data['remark']:'';
        return $model->save();
    }

    public function deleteData(){

    }
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
