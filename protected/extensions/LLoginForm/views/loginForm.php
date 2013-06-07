<li><a href="<?php echo $this->getController()->createUrl('site/signup'); ?>">Registrieren</a></li>
<li class="divider-vertical"></li>
<li class="dropdown">
	<a class="dropdown-toggle" href="#" data-toggle="dropdown">Login <strong class="caret"></strong></a>
	<div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
		<form method="post" action="<?php echo $this->getController()->createUrl('site/login'); ?>">
			<div class="input-prepend">
				<span class="add-on"><i class="icon-user icon-black"></i></span>
				<input class="span2" type="text" name="username" placeholder="Benutzername">
			</div>
			<div class="input-prepend">
				<span class="add-on"><i class="icon-key icon-black"></i></span>
				<input class="span2" type="password" name="password" placeholder="Passwort">
			</div>
			<button type="submit" class="btn btn-primary" data-loading-text="anmelden...">Login</button>
		</form>
	</div>
</li>