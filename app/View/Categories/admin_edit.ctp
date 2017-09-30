

<h4 class="categories">EDIT CATEGORY</h4>
<?php

    echo $this->Form->create('Category', array('class' => 'category-edit' ));
    
    
    echo $this->Form->input('name_en',array('label' => 'Title (en)', 'value' => $category['Category']['name_en'] ) );
    echo $this->Form->input('name_de',array('label' => 'Title (de)', 'value' => $category['Category']['name_de'] ) );
   // echo $this->Form->input('type',array('label' => 'Type', 'options' => array('projects' => 'projects', 'tabs' => 'tabs',), 'value' => $category['Category']['type']) );
    echo $this->Form->input('id',array('type' => 'hidden', 'value' => $category['Category']['id']));
    
    if($category['Category']['type'] == 'projects' ){
    	echo $this->Form->input('active_slide',array('label' => 'TextSlide active', 'value' => $category['Category']['active_slide'], 'options' => array(0 => 'No', 1 => 'Yes') ) );
    	echo $this->Form->input('bgcolor',array('label' => 'Background color', 'type' => 'text','class' => 'color', 'value' => $category['Category']['bgcolor']));

   		echo $this->Form->input('text_en',array('label' => 'Text (en)', 'value' => $category['Category']['text_en'], 'class' => 'tinymce-category' ) );
    	echo $this->Form->input('text_de',array('label' => 'Text (de)', 'value' => $category['Category']['text_de'],'class' => 'tinymce-category' ));

    }


    echo $this->Form->submit('SAVE');
    echo $this->Html->link('CANCEL', array('controller' => 'categories' , 'action' => 'admin_index'), array('class' => 'cancel'));
    echo $this->Form->end();

?>