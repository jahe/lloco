<form class="form-horizontal" method="post" action="<?php echo Yii::app()->createUrl('site/signup'); ?>">
	<div class="control-group">
		<label class="control-label" for="inputUsername">Benutzername</label>
		<div class="controls">
			<input type="text" id="inputUsername" name="username" placeholder="Benutzername">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputEmail">Email</label>
		<div class="controls">
			<input type="text" id="inputEmail" name="email" placeholder="Email">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputPassword">Passwort</label>
		<div class="controls">
			<input type="password" id="inputPassword" name="password" placeholder="Passwort">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputConfirmPassword">Passwort wiederholen</label>
		<div class="controls">
			<input type="password" id="inputConfirmPassword" name="confirmedpw" placeholder="Passwort wiederholen">
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-primary">Registrieren</button>
		</div>
	</div>
</form>