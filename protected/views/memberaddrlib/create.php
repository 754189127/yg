<?php
/* @var $this MemberaddrlibController */
/* @var $model Memberaddrlib */

$this->breadcrumbs=array(
	'Memberaddrlibs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Memberaddrlib', 'url'=>array('index')),
	array('label'=>'Manage Memberaddrlib', 'url'=>array('admin')),
);
?>

<h1>Create Memberaddrlib</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>