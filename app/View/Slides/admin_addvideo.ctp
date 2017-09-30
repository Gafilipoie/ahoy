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
		action: cakeRoot+'/slides/load/video',
		debug: true,
		onComplete: function(id, fileName, responseJSON){
						
						var extension = fileName.split('.').pop();
						
						if($.inArray(extension.toLowerCase(), ['jpg', 'jpeg', 'png', 'gif']) != -1){
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
		}

	})
</script>

<?php
	
	echo $this->Form->create('Slide', array('class' => 'category-edit' )); 
?>
	<p class="full-line">NEW VIDEO SLIDE</p>

<p><span style="color: red">IMPORTANT</span>: Please upload the file in .webm and .mp4 formats to offer support in all browsers and all devices. You can use <a href="http://handbrake.fr/downloads.php">handbreak app</a> or use an <a href="http://www.convertdirect.com/free_online_flv_converter.html">online service</a></p>
	
	<!--<form action="/admin/slides/addvideo/" method="POST" />-->
	<?php

	echo $this->Form->input('project_id', array('type' => 'hidden' , 'value' => $project_id));
	echo $this->Form->input('rank',array('type' => 'hidden', 'value' => 99));
	echo $this->Form->input('type',array('type' => 'hidden', 'value' => 'video'));
	echo $this->Form->input('is_active',array('type' => 'hidden', 'value' => 1));

	// echo $this->Form->input('flv',array('label' => 'FLV video', 'readonly' => true, 'id' => 'flv'));
	$this->Form->error('mp4');
	echo $this->Form->input('mp4',array('label' => 'MP4 video', 'readonly' => true, 'id' => 'mp4'));
	// echo $this->Form->input('ogv',array('label' => 'OGV video', 'readonly' => true, 'id' => 'ogv'));
	//echo $this->Form->input('webm',array('label' => 'WEBM video', 'readonly' => true, 'id' => 'webm'));
	$this->Form->error('img');
	echo $this->Form->input('img',array('label' => 'COVER image', 'readonly' => true, 'id' => 'img'));

	echo $this->Form->input('video_width',array('type' => 'hidden', 'value' => 699));
	echo $this->Form->input('video_height',array('type' => 'hidden', 'value' => 499));    

	echo $this->Form->submit('ADD', array('id' => 'addVideoButton'));
		echo $this->Html->link('CANCEL', array('controller' => 'slides', 'action' => 'index',$project_id, 'admin' => true), array('class' => 'cancel'));
	echo $this->Form->end();

?>