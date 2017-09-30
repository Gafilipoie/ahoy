<h4 class="categories"><?php echo $project['Project']['name_en'] ?></h4>
<div class="clearfix"><?php echo $this->Html->link('BACK', array('controller' => 'projects', 'action' => 'index', 'admin' => true), array('class' => 'cancel right')); ?></div>

<?php echo $this->Html->link('Add new text slide', array('controller' => 'slides', 'action' => 'add', $project_id, 'admin' => true), array('id' => 'new-slide')); ?>
<h3 class="add-slide">OR</h3>

<?php echo $this->Html->link('Add new video slide', array('controller' => 'slides', 'action' => 'addvideo', $project_id, 'admin' => true), array('id' => 'new-slide')); ?>
<h3 class="add-slide">OR</h3>

<div id="file-uploader">
  <noscript>
    <p>Please enable JavaScript to use file uploader.</p>
    <!-- or put a simple form for upload here -->
  </noscript>
</div>

<div class="clearfix"><?php echo $this->Html->link('DONE', array('controller' => 'slides', 'action' => 'index', $project_id, 'admin' => true), array('id' => 'done-upload')); ?></div>

<script type="text/javascript">
  var project_id = <?php echo $project_id; ?>;
  var uploader = new qq.FileUploader({
    element: document.getElementById('file-uploader'),
    allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'] ,
    action: cakeRoot+'/slides/load',
    debug: true,
    onComplete: function(id, fileName, responseJSON){
      $('#done-upload').show();
      $.post(cakeRoot + 'slides/add_image/'+ project_id +'/'+fileName);
    }
  })
</script>

<?php echo $this->Form->create('Slide', array('url' => array('controller' => 'slides', 'action' => 'save_order', 'admin' => true))); ?>
<ul id="slides" class="clearfix">
  <?php foreach($slides as $slide): ?>
    <li>
      <?php if($slide['Slide']['type'] == 'image'): ?>
        <?php echo $this->Html->image('uploads/desktop/'.$slide['Slide']['image'], array('width' => '699', 'height' => '469')); ?>
        <div class="actions clearfix">
          <?php
            echo $this->Html->link('', array('controller' => 'slides', 'action' => 'delete', $slide['Slide']['id'], 'admin' => true), array('class' => 'delete'), "Are you sure you want to delete?");
            if($slide['Slide']['is_active'] == 1){
              echo $this->Html->link('', array('controller' => 'slides', 'action' => 'set_status', $slide['Slide']['id'], 'admin' => true), array('class' => 'active change-status'));
            }
            else{
              echo $this->Html->link('', array('controller' => 'slides', 'action' => 'set_status', $slide['Slide']['id'], 'admin' => true), array('class' => 'busy change-status'));
            }
          ?>
        </div>
        <?php
          if(empty($slide['Slide']['is_cover'])){
            echo $this->Html->link('', array('controller' => 'slides', 'action' => 'set_cover', $slide['Slide']['id'],$project_id, 'admin' => true), array('class' => 'cover'), "Are you sure you want to make it the cover of the portfolio?");
          }
          else{
            echo $this->Html->tag('span', '', array('class' => 'cover'));
          }
        ?>
        <fieldset>
          <legend>Image attributes</legend>
          <label>Alt </label><input type="text" name="image_alt" style="width:250px;" value="<?php echo $slide['Slide']['image_alt']; ?>" data-slideID="<?php echo $slide['Slide']['id']; ?>" />
          <label>Title </label><input type="text" name="image_title" style="width:250px;" value="<?php echo $slide['Slide']['image_title']; ?>" data-slideID="<?php echo $slide['Slide']['id']; ?>" />
          <a href="javascript:void(0)" data-slideID="<?php echo $slide['Slide']['id']; ?>" class="update_img_seoinf">Update</a>
          <span style="display:none;">Updating</span>
        </fieldset>
      <?php endif; ?>

      <?php if($slide['Slide']['type'] == 'text'): ?>
        <div class="actions clearfix">
          <?php
            echo $this->Html->link('', array('controller' => 'slides', 'action' => 'delete', $slide['Slide']['id'], 'admin' => true), array('class' => 'delete'), "Are you sure you want to make it the cover of the portfolio?");
            echo $this->Html->link('', array('controller' => 'slides', 'action' => 'edit', $slide['Slide']['id'], 'admin' => true), array('class' => 'edit'));
            if($slide['Slide']['is_active'] == 1){
              echo $this->Html->link('', array('controller' => 'slides', 'action' => 'set_status', $slide['Slide']['id'], 'admin' => true), array('class' => 'active change-status'));
            }
            else{
              echo $this->Html->link('', array('controller' => 'slides', 'action' => 'set_status', $slide['Slide']['id'],'admin' => true), array('class' => 'busy change-status'));
            }
          ?>
        </div>
        <div class="en">
          <h3><?php echo $slide['Slide']['title_en'] ?></h3>
          <div class="text"><?php echo $slide['Slide']['text_en'] ?></div>
        </div>
        <div class="de">
          <h3><?php echo $slide['Slide']['title_de'] ?></h3>
          <div class="text"><?php echo $slide['Slide']['text_de'] ?></div>
        </div>
      <?php endif; ?>

      <?php if($slide['Slide']['type'] == 'video'): ?>
        <div class="actions clearfix">
          <?php
            echo $this->Html->link('', array('controller' => 'slides', 'action' => 'delete', $slide['Slide']['id'], 'admin' => true), array('class' => 'delete'), "Are you sure you want to make it the cover of the portfolio?");
            echo $this->Html->link('', array('controller' => 'slides', 'action' => 'editvideo', $slide['Slide']['id'], 'admin' => true), array('class' => 'edit'));
            if($slide['Slide']['is_active'] == 1){
              echo $this->Html->link('', array('controller' => 'slides', 'action' => 'set_status', $slide['Slide']['id'],'admin' => true), array('class' => 'active change-status'));
            }
            else{
              echo $this->Html->link('', array('controller' => 'slides', 'action' => 'set_status', $slide['Slide']['id'], 'admin' => true), array('class' => 'busy change-status'));
            }
          ?>
        </div>
        <video class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto" width="699" height="469" data-setup="{}">
          <source src="<?php echo Router::url('/').'img/uploads/videos/'.$slide['Slide']['mp4'] ?>" type='video/mp4' />
          <source src="<?php echo Router::url('/').'img/uploads/videos/'.$slide['Slide']['webm'] ?>" type='video/webm' />
        </video>
        <?php
          if(empty($slide['Slide']['is_cover'])){
            echo $this->Html->link('', array('controller' => 'slides', 'action' => 'set_cover', $slide['Slide']['id'],$project_id, 'admin' => true), array('class' => 'cover'), "Are you sure you want to make it the cover of the portfolio?");
          }
          else{
            echo $this->Html->tag('span', '', array('class' => 'cover'));
          }
        ?>
      <?php endif; ?>

      <?php echo $this->Form->input('rank.', array('type' => 'hidden','value' => $slide['Slide']['id']));  ?>
    </li>
  <?php endforeach; ?>
</ul>

<?php echo $this->Form->end();  ?>
<?php echo $this->Html->script('jquery.js'); ?>
<script type="text/javascript">
  $(document).ready(function() {
    $('.update_img_seoinf').click(function(ev) {
      ev.preventDefault();
      target = $(ev.target);
      slideID = target.attr('data-slideID');
      altVal = $('input[name="image_alt"][data-slideID="'+slideID+'"]').val();
      titleVal = $('input[name="image_title"][data-slideID="'+slideID+'"]').val();
      data = {
        image_alt: altVal,
        image_title: titleVal,
        slide_id: slideID
      }
      target.hide();
      target.next('span').show();
      $.ajax({
        type: "POST",
        url: cakeRoot+'admin/slides/save_image_seo',
        data: data,
        success: function(d) {
          target.next('span').hide();
          target.fadeIn('slow');
        }
      });
      return false;
    });
  });
</script>
