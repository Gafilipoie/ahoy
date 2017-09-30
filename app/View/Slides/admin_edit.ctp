<h4 class="categories"><?php echo $project['Project']['name_en'] ?></h4>
<?php



    echo $this->Form->create('Slide', array('url' => array('controller' => 'slides', 'action' => 'edit' , 'admin' => true),   'class' => 'category-edit' )); 
?>
	<p class="full-line">EDIT SLIDE</p>
<?php
 echo $this->Form->input('id',array('type' => 'hidden', 'value' => $slide['Slide']['id']) );   

    echo $this->Form->input('title_en',array('label' => 'Title (en)', 'value' => $slide['Slide']['title_en']) );   
     echo $this->Form->input('title_de',array('label' => 'Title (de)', 'value' => $slide['Slide']['title_de']) );

     ?>
<div class="clearfix">
	<h3 class="add-slide">Text EN/DE</h3>
     <div class="left">
    <?php
 	echo $this->Form->textarea('text_en',array('class' => 'tinymce left' , 'value' => $slide['Slide']['text_en']) );
    ?>
    </div>

    <div class="right">
    <?php
    echo $this->Form->textarea('text_de',array('class' => 'tinymce right', 'value' => $slide['Slide']['text_de']));
    ?>
    </div>
</div>

    <?php

    echo $this->Form->input('project_id', array('type' => 'hidden' , 'value' => $slide['Slide']['project_id']));
    echo $this->Form->input('type',array('type' => 'hidden', 'value' => 'text'));
    echo $this->Form->submit('SAVE');	
    echo $this->Html->link('CANCEL', array('controller' => 'slides', 'action' => 'index',$slide['Slide']['project_id'], 'admin' => true), array('class' => 'cancel'));
    echo $this->Form->end();

?>