<?php
/**
 * 邮寄包裹
 * User: kevin
 * Date: 14-7-21
 * Time: 下午9:46
 */

class Parcelpost extends CActiveRecord{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{parcelpost}}';
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

        $criteria = new CDbCriteria();
        $criteria->addCondition($conStr);
        $criteria->order='id desc';
        $data = Parcelpost::model()->findAll($criteria);
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