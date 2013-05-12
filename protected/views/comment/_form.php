<section>
	<header>
		<h1>Post kommentieren</h1>
	</header>
<?php
	$form = $this->beginWidget('CActiveForm', array('id' => 'createComment'));
?>

<?php
	echo $form->errorSummary($comment);
?>

<?php
	echo $form->labelEx($comment, 'title');
	echo $form->textField($comment, 'title');
	echo $form->error($comment, 'title');
?>

<?php
	echo $form->labelEx($comment, 'content');
	echo $form->textArea($comment, 'content');
	echo $form->error($comment, 'content');
?>
	<div>
<?php
	echo CHtml::submitButton('Veröffentlichen');
?>
	</div>

<?php
	$this->endWidget();
?>
</section>