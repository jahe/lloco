<li class="dropdown">
    <a style="" href="#" class="dropdown-toggle" data-toggle="dropdown">
      <img alt="Profilfoto" src="<?php echo $this->getController()->createUrl('user/getprofileimg', ['user' => Yii::app()->user->username, 'width' => 18, 'height' => 18]); ?>">
      &nbsp;
      <?php echo Yii::app()->user->username ?>
      <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
      <li>
        <a tabindex="-1" href="<?php echo $this->getController()->createUrl('post/create'); ?>"><i class="icon-plus"></i> Post erstellen</a>
      </li>
    	<li class="divider"></li>
    	<li>
    		<a tabindex="-1" href="<?php echo $this->getController()->createUrl('site/logout'); ?>"><i class="icon-off"></i> Logout
    		</a>
    	</li>
    </ul>
  </li>