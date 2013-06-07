<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.MultiFile.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/createPostGeo.js', CClientScript::POS_END);
?>
<article class="span8">
<form enctype="multipart/form-data" id="postForm" class="form-horizontal" method="post" name="createPost" action="<?php echo $actionPath ?>">
  <div class="control-group">
    <label class="control-label" for="inputTitle">Titel</label>
    <div class="controls">
      <input type="text" id="inputTitle" placeholder="Titel..." name="title">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputNachricht">Nachricht</label>
    <div class="controls">
      <textarea rows="3" id="inputNachricht" placeholder="Nachricht..." name="content"></textarea>
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputFotos">Fotos</label>
    <div class="controls">
      <input id="inputFotos" name="pics[]" type="file" class="multi" accept="jpg"/>
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputCategory">Kategorie</label>
    <div class="controls">
      <select name="category" id="inputCategory">
      <?php
      foreach ($categories as $nr => $catdata)
      {
        echo "<option value=\"$catdata->_id\">$catdata->title</option>";
      }
      ?>
      </select>
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputTags">Tags</label>
    <div class="controls">
      <input id="inputTags" class="input-tag" type="text" placeholder="Tags..." name="tags" data-provide="tag">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputLocation">Standort</label>
    <div id="locationwrapper" class="controls">
      <p id="locationstatus" class="label label-info"><i class="icon-spinner icon-spin"></i> wird ermittelt</p>
      <input type="hidden" name="latitude" value="">
      <input type="hidden" name="longitude" value="">
    </div>
  </div>

  <div class="control-group">
    <div class="controls">
      <button id="submitpost" type="submit" class="btn btn-primary disabled" disabled>Posten</button>
    </div>
  </div>
</form>
</article>