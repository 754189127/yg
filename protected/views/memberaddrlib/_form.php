<?php
/* @var $this MemberaddrlibController */
/* @var $model Memberaddrlib */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'memberaddrlib-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'memberId'); ?>
		<?php echo $form->textField($model,'memberId'); ?>
		<?php echo $form->error($model,'memberId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type'); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'zipCode'); ?>
		<?php echo $form->textField($model,'zipCode',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'zipCode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mobile'); ?>
		<?php echo $form->textField($model,'mobile',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'mobile'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'consignee'); ?>
		<?php echo $form->textField($model,'consignee',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'consignee'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'isDefault'); ?>
		<?php echo $form->textField($model,'isDefault'); ?>
		<?php echo $form->error($model,'isDefault'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->