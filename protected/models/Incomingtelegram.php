<?php

/**
 * 电话订购
 * User: kevin
 * Date: 14-7-9
 * Time: 下午8:44
 */
class Incomingtelegram extends CActiveRecord
{
    public function tableName()
    {
        return '{{incomingtelegram}}';
    }


    public function rules()
    {
        return array(
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array();
    }


    public function getList($memberId)
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('memberId='.$memberId);
        $criteria->order = 'id desc';
        $data = Company::model()->findAll($criteria);
        return $data;
    }

    public function saveData($data)
    {
        $model = new Incomingtelegram();
        $model->addDate = time();
        $model->memberId = isset($data['memberId']) ? $data['memberId'] : 0;
        $model->mobile = isset($data['mobile']) ? $data['mobile'] : '';
        return $model->save();
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
} 