<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      <?php echo Yii::app()->user->username ?>
      <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
    	<!--<li class="divider"></li>-->
    	<li>
    		<a tabindex="-1" href="<?php echo $this->getController()->createUrl('site/logout'); ?>"><i class="icon-off"></i> Logout
    		</a>
    	</li>
    </ul>
  </li>