<?php
/* @var $this MemberaddrlibController */
/* @var $model Memberaddrlib */

$this->breadcrumbs=array(
	'Memberaddrlibs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Memberaddrlib', 'url'=>array('index')),
	array('label'=>'Create Memberaddrlib', 'url'=>array('create')),
	array('label'=>'Update Memberaddrlib', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Memberaddrlib', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Memberaddrlib', 'url'=>array('admin')),
);
?>

<h1>View Memberaddrlib #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'memberId',
		'type',
		'address',
		'zipCode',
		'mobile',
		'consignee',
		'isDefault',
	),
)); ?>
