

<h4 class="categories">ADD NEW CATEGORY</h4>
<?php

    echo $this->Form->create('Category', array('class' => 'category-edit', 'url' => array('controller' => 'categories', 'action' => 'add', 'admin' => true)));
    
    
    echo $this->Form->input('name_en',array('label' => 'Title (en)' ));
    echo $this->Form->input('name_de',array('label' => 'Title (de)' ));
    echo $this->Form->input('type',array('label' => 'Type', 'options' => array('projects' => 'projects', 'tabs' => 'text','inactive' => 'inactive')));
    echo $this->Form->input('id',array('type' => 'hidden'));
    
    echo $this->Form->submit('SAVE');
    echo $this->Html->link('CANCEL', array('controller' => 'categories' , 'action' => 'admin_index'), array('class' => 'cancel'));
    echo $this->Form->end();

?>