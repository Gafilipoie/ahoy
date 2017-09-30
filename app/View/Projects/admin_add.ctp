<?php

    echo $this->Form->create('Project', array('class' => 'category-edit', 'url' => array('controller' => 'projects', 'action' => 'add', 'admin' => true)));
    

 	echo $this->Form->input('Project.name_en',array('label' => 'Title (en)' ));
 	echo $this->Form->input('Project.name_de',array('label' => 'Title (de)' ));
    ?>
    <p style="margin: 0 20px;">Categories:</p>
    <?php
    echo $this->Form->input('Category.id',array('label' => false ,'type' => 'select', 'multiple' => 'checkbox', 'options' => $categories));
    
    echo $this->Form->submit('SAVE');
    echo $this->Html->link('CANCEL', array('controller' => 'categories' , 'action' => 'admin_index'), array('class' => 'cancel'));
    echo $this->Form->end();

?>