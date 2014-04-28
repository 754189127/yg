<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $email
 */
class User extends CActiveRecord
{
	
	public $username;
	public $password;

	public $_userInfo;
	private $_identity;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
    public function rules()
    {
        return array(
            // username and password are required
            array('username, password', 'required'),
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
			'username' => '登录账号',
			'password' => '登录密码',
			'email' => '邮箱',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function login()
    {
    	if($this->_identity===null)
		{
			$this->_identity= new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		
        
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$this->_userInfo = $this->_identity->userInfoModel;
			
			Yii::app()->user->login($this->_identity);
			return true;
		}
		else
			return false;
    }
    
    
    public function safeLogin($username,$password){
    	$data = $this->find("username=:username and password=:password", array(':username' => $username,'password'=>md5($password)));
    	if(!$data) 
    		return null;
       
        // 记录当前用户SESSION.
        Yii::app()->user->setState('userId', $data->id);                    // 用户ID
        Yii::app()->user->setState('userName', $data->username);      // 用户名        
        //角色
    	/*$userRole = AdminUserRole::model()->getUserRole($userLogin->ADMIN_USER_ID);
        Yii::app()->user->setState('ROLE', $userRole['ROLEID']);                  // 角色ID
        
        if ($userLogin->SYS == 1)
        {
        	// 自动添加所有权限
        	AdminRole::model()->autoAddPriv();
        }

        // 保存当前登录信息
        $sqlString = "UPDATE " . $this->tableName() . " SET LAST_IP='{$loginIP}', LOGIN_TIMES=LOGIN_TIMES+1, LAST_LOGIN_TIME=sysdate WHERE USER_NAME='{$userLogin->USER_NAME}'";
        Yii::app()->db->createCommand($sqlString)->query();
        
        // 保存登录日志文件
        $userLog = new UserLog; 
        $logTitle = '用户登录';
        $userLog->saveData($logTitle);
        */
        return  $data;
    }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
