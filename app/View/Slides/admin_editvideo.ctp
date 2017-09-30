<h4 class="categories"><?php echo $project['Project']['name_en'] ?></h4>


<div id="file-uploader">       
    <noscript>          
        <p>Please enable JavaScript to use file uploader.</p>
        <!-- or put a simple form for upload here -->
    </noscript>         
</div>

<script type="text/javascript">
    
    var project_id = <?php echo $project_id; ?>;
    var uploader = new qq.FileUploader({
        
        element: document.getElementById('file-uploader'),

        allowedExtensions: ['jpg', 'jpeg', 'png', 'gif', 'flv', 'ogv', 'mp4', 'webm'] ,        
        action: cakeRoot+'/slides/load',
        debug: true,
        onComplete: function(id, fileName, responseJSON){
            
                        var extension = fileName.split('.').pop();
                        
                        if($.inArray(extension, ['png', 'jpg', 'gif', 'jpeg']) != -1){
                            $('#img').val(fileName);  
                        }

                        if(extension == 'flv'){
                            $('#flv').val(fileName);
                        }
                        if(extension == 'mp4'){
                            $('#mp4').val(fileName);
                        }
                        if(extension == 'ogv'){
                            $('#ogv').val(fileName);
                        }
                        if(extension == 'webm'){
                            $('#webm').val(fileName);
                        }
        
        }

    })
</script>

<?php
    
    echo $this->Form->create('Slide', array('url' => array('controller' => 'slides', 'action' => 'addvideo', $project_id, 'admin' => true) , 'class' => 'category-edit' )); 
?>
	<p class="full-line">EDIT VIDEO SLIDE</p>

<p><span style="color: red">IMPORTANT</span>: Please upload the file in .mp4 formmat</p>

    <?php

    echo $this->Form->input('id', array('type' => 'hidden' , 'value' => $slide['Slide']['id']));
    echo $this->Form->input('project_id', array('type' => 'hidden' , 'value' => $slide['Slide']['project_id']));


    // echo $this->Form->input('flv',array('label' => 'FLV video', 'readonly' => true, 'id' => 'flv')); 
    // if(!empty($slide['Slide']['flv'])) {
    //   echo '<span>Current value: '. $slide['Slide']['flv']. '</span>';
    // }
    echo $this->Form->input('mp4',array('label' => 'MP4 video', 'readonly' => true, 'id' => 'mp4'));
    if(!empty($slide['Slide']['mp4'])) {
      echo '<span>Current value: '. $slide['Slide']['mp4']. '</span>';
    }
    // echo $this->Form->input('ogv',array('label' => 'OGV video', 'readonly' => true, 'id' => 'ogv', ));    
    // if(!empty($slide['Slide']['ogv'])) {
    //   echo '<span>Current value: '. $slide['Slide']['ogv']. '</span>';
    // }
  /*  echo $this->Form->input('webm',array('label' => 'WEBM video', 'readonly' => true, 'id' => 'webm', ));
    if(!empty($slide['Slide']['webm'])) {
      echo '<span>Current value: '. $slide['Slide']['webm']. '</span>';
    }*/
    echo $this->Form->input('img',array('label' => 'COVER image', 'readonly' => true, 'id' => 'img', ));
    if(!empty($slide['Slide']['image'])) {
      echo '<span>Current value: '. $this->Html->image('uploads/desktop/'.$slide['Slide']['image'], array('width' => '200')). '</span>';
    }

   echo $this->Form->input('video_width', array('type' => 'text' , 'value' => $slide['Slide']['video_width']));
   echo $this->Form->input('video_height', array('type' => 'text' , 'value' => $slide['Slide']['video_height']));


    echo $this->Form->submit('SAVE');
        echo $this->Html->link('CANCEL', array('controller' => 'slides', 'action' => 'index',$project_id, 'admin' => true), array('class' => 'cancel'));
    echo $this->Form->end();

?>