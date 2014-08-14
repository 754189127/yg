<?php


class Actionlog extends CActiveRecord
{

	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{actionlog}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
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
			'id' => '序号',
			'action' => '操作行为',
			'logDate' => '操作时间',
			'userName' => '操作人员',
		);
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getList($con){
        $criteria = new CDbCriteria();
        $criteria->order='logDate desc';
        $count = Actionlog::model()->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 20;
        $pager->setCurrentPage($con['page']);
        $pager->applyLimit($criteria);
        $data =  Actionlog::model()->findAll($criteria);
        if($data){
            foreach($data as $k=>$val){
                $data[$k]['logDate'] = date('Y-m-d H:i:s',$val['logDate']);
            }
        }
        return array('list'=>$data,'paper'=>$pager);
    }

    public function saveLog($action,$username){
        $model = new Actionlog();
        $model->action=$action;
        $model->userName=$username;
        $model->logDate = time();
        $userId = Yii::app()->user->getState('userId');
        $model->userId = isset($userId)?intval($userId):0;
        $model->save();
    }

   public  function deleteData(){
       $datetime = time()-30*24*3600;
       return Actionlog::deleteAllByAttributes(array(),'logDate<:datetime',array("datetime"=>$datetime));
   }
}
