<h4 class="categories"><?php echo $tab['Tab']['name_en'] ?></h4>
<?php
    
    echo $this->Form->create('Content', array('url' => array('controller' => 'contents', 'action' => 'add' , 'admin' => true),   'class' => 'category-edit' )); 
?>
	<p class="full-line">NEW SLIDE</p>

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

    echo $this->Form->input('tab_id', array('type' => 'hidden' , 'value' => $tab['Tab']['id']));
    echo $this->Form->input('rank',array('type' => 'hidden', 'value' => 99));
    echo $this->Form->input('type',array('type' => 'hidden', 'value' => 'text'));
    echo $this->Form->input('is_active',array('type' => 'hidden', 'value' => 1));

    echo $this->Form->submit('ADD');
        echo $this->Html->link('CANCEL', array('controller' => 'contents', 'action' => 'index',$tab['Tab']['id'], 'admin' => true), array('class' => 'cancel'));
    echo $this->Form->end();

?>