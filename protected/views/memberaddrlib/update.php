<?php
/* @var $this MemberaddrlibController */
/* @var $model Memberaddrlib */

$this->breadcrumbs=array(
	'Memberaddrlibs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Memberaddrlib', 'url'=>array('index')),
	array('label'=>'Create Memberaddrlib', 'url'=>array('create')),
	array('label'=>'View Memberaddrlib', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Memberaddrlib', 'url'=>array('admin')),
);
?>

<h1>Update Memberaddrlib <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>