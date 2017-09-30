<h4 class="categories"><?php echo $tab['Tab']['name_en'] ?></h4>
<div class="clearfix">
    <?php
    
    echo $this->Html->link('BACK', array('controller' => 'tabs', 'action' => 'index', $tab['Tab']['category_id'], 'admin' => true), array('class' => 'cancel right'));
 ?>

</div>
<?php
    echo $this->Html->link('Add new text slide', array('controller' => 'contents', 'action' => 'add', $tab['Tab']['id'], 'admin' => true), array('id' => 'new-slide'));
 ?>
<h3 class="add-slide">OR</h3>

<div id="file-uploader">       
    <noscript>          
        <p>Please enable JavaScript to use file uploader.</p>
        <!-- or put a simple form for upload here -->
    </noscript>         
</div>
<div class="clearfix">
<?php

    echo $this->Html->link('DONE', array('controller' => 'contents', 'action' => 'index', $tab['Tab']['id'], 'admin' => true), array('id' => 'done-upload'));
 ?>
</div>

<script type="text/javascript">
	
    var tab_id = <?php echo $tab['Tab']['id']; ?>;
    var uploader = new qq.FileUploader({
        
        element: document.getElementById('file-uploader'),

        allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'] ,        
        action: cakeRoot+'/slides/load',
        debug: true,
        onComplete: function(id, fileName, responseJSON){
                        $('#done-upload').show();
                        $.post(cakeRoot + 'contents/add_image/'+ tab_id +'/'+fileName);
                    }
	})
</script>

<?php 

echo $this->Form->create('Content', array('url' => array('controller' => 'contents', 'action' => 'save_order', 'admin' => true))); ?>
<ul id="slides" class="clearfix">
    <?php foreach($contents as $content): ?>
        <li class="clearfix autoh">
            <?php if($content['Content']['type'] == 'image'): ?>

        <?php echo $this->Html->image('uploads/desktop/'.$content['Content']['image'], array('width' => '699', 'height' => '469', 'alt' => $content['Content']['image_alt'], 'title' => $content['Content']['image_title'])); ?>


                <div class="actions clearfix">
                    <?php 
                    echo $this->Html->link('', array('controller' => 'contents', 'action' => 'delete', $content['Content']['id'], 'admin' => true), array('class' => 'delete'), "Are you sure you want to delete?");
                    if($content['Content']['is_active'] == 1){
                        echo $this->Html->link('', array('controller' => 'contents', 'action' => 'set_status', $content['Content']['id'], 'admin' => true), array('class' => 'active change-status'));
                    }  
                    else{
                        echo $this->Html->link('', array('controller' => 'contents', 'action' => 'set_status', $content['Content']['id'], 'admin' => true), array('class' => 'busy change-status'));
                    }
                    ?>
                </div>
                <fieldset>
                    <legend>Image attributes</legend>
                    <label>Alt </label><input type="text" name="image_alt" style="width:250px;" value="<?php echo $content['Content']['image_alt']; ?>" data-slideID="<?php echo $content['Content']['id']; ?>" />
                    <label>Title </label><input type="text" name="image_title" style="width:250px;" value="<?php echo $content['Content']['image_title']; ?>" data-slideID="<?php echo $content['Content']['id']; ?>" />
                    <a href="javascript:void(0)" data-slideID="<?php echo $content['Content']['id']; ?>" class="update_img_seoinf">Update</a>
                    <span style="display:none;">Updating</span>
                </fieldset>
            <?php endif; ?>
            <?php if($content['Content']['type'] == 'text'): ?>


                    <div class="actions clearfix">
                    <?php 
                    echo $this->Html->link('', array('controller' => 'contents', 'action' => 'delete', $content['Content']['id'], 'admin' => true), array('class' => 'delete'), "Are you sure you want to make it the cover of the portfolio?");
                      echo $this->Html->link('', array('controller' => 'contents', 'action' => 'edit', $content['Content']['id'], 'admin' => true), array('class' => 'edit'));
                   if($content['Content']['is_active'] == 1){
                        echo $this->Html->link('', array('controller' => 'contents', 'action' => 'set_status', $content['Content']['id'], 'admin' => true), array('class' => 'active change-status'));
                   }  
                   else{
                        echo $this->Html->link('', array('controller' => 'contents', 'action' => 'set_status', $content['Content']['id'], 'admin' => true), array('class' => 'busy change-status'));
                   }
                ?>

                </div>

                <div class="en">
                    <div class="text"><?php echo $content['Content']['text_en'] ?></div>
                </div>
                <div class="de">
                    <div class="text"><?php echo $content['Content']['text_de'] ?></div>
                </div>


            <?php endif; ?>


            <?php echo $this->Form->input('rank.', array('type' => 'hidden','value' => $content['Content']['id']));  ?>
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
          url: cakeRoot+'admin/contents/save_image_seo',
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