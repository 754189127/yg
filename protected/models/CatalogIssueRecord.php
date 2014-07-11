<?php

/**
 * 目录发送记录
 * Class CatalogIssueRecord
 */
class CatalogIssueRecord extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{catalogissuerecord}}';
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
