<form class="form-horizontal" method="post" action="<?php echo $actionPath ?>">
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
    <div class="controls">
      <button type="submit" class="btn">Posten</button>
    </div>
  </div>
</form>