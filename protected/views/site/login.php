<?php
if (isset($errorMsg))
{
?>
<div class="alert alert-error">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Auweia!</strong> <?php echo $errorMsg; ?>
</div>
<?php
}
?>
<form class="form-horizontal" method="post" action="<?php echo Yii::app()->createUrl('site/login'); ?>">
	<div class="control-group">
		<label class="control-label" for="inputUsername">Benutzername</label>
		<div class="controls">
			<input type="text" id="inputUsername" name="username" placeholder="Benutzername">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputPassword">Passwort</label>
		<div class="controls">
			<input type="password" id="inputPassword" name="password" placeholder="Passwort">
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-primary">Login</button>
		</div>
	</div>
</form>