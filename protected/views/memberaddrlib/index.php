<?php
/* @var $this MemberaddrlibController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Memberaddrlibs',
);

$this->menu=array(
	array('label'=>'Create Memberaddrlib', 'url'=>array('create')),
	array('label'=>'Manage Memberaddrlib', 'url'=>array('admin')),
);
?>

<h1>Memberaddrlibs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
