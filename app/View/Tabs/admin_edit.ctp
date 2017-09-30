
<?php
    echo $this->Form->create('Tab', array('url' => array('controller' => 'tabs', 'action' => 'edit' , 'admin' => true),   'class' => 'category-edit' )); 
    ?>
<p class="full-line">NEW TAB</p>
    <?php
    echo $this->Form->input('name_en',array('label' => 'Title (en)' , 'value' => $tab['Tab']['name_en']) );
    echo $this->Form->input('name_de',array('label' => 'Title (de)' , 'value' => $tab['Tab']['name_de']) );
    echo $this->Form->input('category_id', array('type' => 'hidden' , 'value' => $tab['Tab']['category_id']));

    echo $this->Form->input('id', array('type' => 'hidden' , 'value' => $tab['Tab']['id']));

    echo $this->Form->input('order',array('type' => 'hidden', 'value' => 99));
    echo $this->Form->submit('ADD');
    echo $this->Html->link('BACK', array('controller' => 'tabs' , 'action' => 'index', $tab['Tab']['id'], 'admin' => true), array('class' => 'cancel'));
    echo $this->Form->end();
?>