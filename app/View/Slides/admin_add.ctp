<h4 class="categories"><?php echo $project['Project']['name_en'] ?></h4>
<?php
    
    echo $this->Form->create('Slide', array('url' => array('controller' => 'slides', 'action' => 'add' , 'admin' => true),   'class' => 'category-edit' )); 
?>
	<p class="full-line">NEW SLIDE</p>
<?php

         echo $this->Form->input('title_en',array('label' => 'Title (en)') );   
         echo $this->Form->input('title_de',array('label' => 'Title (de)') );
?>
<div class="clearfix">
        <h3 class="add-slide">Text EN/DE</h3>
     <div class="left">
    <?php
 	echo $this->Form->textarea('text_en',array('label' => 'Text en / de','class' => 'tinymce left' ) );
    ?>
    </div>

    <div class="right">
    <?php
    echo $this->Form->textarea('text_de',array('label' => 'Text (de)', 'class' => 'tinymce right'));
    ?>
    </div>
</div>

    <?php

    echo $this->Form->input('project_id', array('type' => 'hidden' , 'value' => $project_id));
    echo $this->Form->input('rank',array('type' => 'hidden', 'value' => 99));
    echo $this->Form->input('is_active',array('type' => 'hidden', 'value' => 1));
    echo $this->Form->input('type',array('type' => 'hidden', 'value' => 'text'));
    echo $this->Form->submit('ADD');
        echo $this->Html->link('CANCEL', array('controller' => 'slides', 'action' => 'index',$project_id, 'admin' => true), array('class' => 'cancel'));
    echo $this->Form->end();

?>