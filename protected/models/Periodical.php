<?php

/**
 * 期刊
 * Class periodical
 */
class Periodical extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{periodical}}';
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




    public function getList($number=0)
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('status=1');
        $criteria->order='id desc';
        if($number){
            $criteria->limit=$number;
        }
        $data = Periodical::model()->findAll($criteria);
        if($data){
            foreach($data as $k=>$v){
                $data[$k]['startDate'] = $v['startDate']?date('Y-m-d',$v['startDate']):'';
                $data[$k]['endDate'] = $v['endDate']?date('Y-m-d',$v['endDate']):'';
            }
        }
        return $data;
    }


    public function saveData($data){
        $model = new Periodical();
        if(isset($data['id'])){
            $model = Periodical::model()->findByPk($data['id']);
        }else{
            $model->code = date('YmdHis');
            $model->addDate = time();
            $model->status =1;
        }
        $model->title = isset($data['title'])?$data['title']:'';
        $model->startDate = isset($data['startDate'])?strtotime($data['startDate']):0;
        $model->endDate = isset($data['endDate'])?strtotime($data['endDate']):0;
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
