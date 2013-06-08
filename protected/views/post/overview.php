<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/geoPostOverview.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('http://maps.google.com/maps/api/js?sensor=false', CClientScript::POS_BEGIN);
 ?>
<article class="span6">
<div class="accordion" id="accordion2">
	<div class="accordion-group">
		<div class="accordion-heading">
			<span class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#filterMenu">
				Suchoptionen&nbsp;&nbsp;<i class="icon-chevron-down icon-black"></i>
			</span>
		</div>
		<div id="filterMenu" class="accordion-body collapse">
			<div class="accordion-inner">
				<form class="form-horizontal" action="" name="filterForm" method="get" id="filterForm">
					<div class="control-group">
						<label class="control-label" for="filterAdress">Standort</label>
						<div class="controls">
							<button style="display: inline-block" type="button" class="btn btn-small"><i class="icon-screenshot"></i></button>
							<span>Elmshorn, Königsstraße 2 <i class="icon-ok"></i></span>
							<input type="hidden" name="latitude" value="">
							<input type="hidden" name="longitude" value="">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="filterCategory">Kategorie</label>
						<div class="controls">
							<select name="cat" id="filterCategory">
								<option value="all">Alle Kategorien</option>
								<?php
								foreach ($categories as $nr => $catdata)
								{
									// HIER NOCH FRAGEN OB $filter['cat'] gesetzt ist, und dann den wert default-selecten
									echo "<option value=\"$catdata->_id\">$catdata->title</option>";
								}
								?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="filterSort">Sortierung</label>
						<div class="controls">
							<select name="sort" id="filterSort">
								<?php
								foreach ($sorts as $value => $title)
								{
									// HIER NOCH FRAGEN OB $filter['sort'] gesetzt ist, und dann den wert default-selecten
									echo "<option value=\"$value\">$title</option>";
								}
								?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<button type="submit" class="btn btn-primary">Suchen</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="posts">
</div>
</article>