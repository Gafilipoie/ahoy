<h4 class="categories">EDIT: <?php echo $project['Project']['name_en'].'/'.$project['Project']['name_de'] ?></h4>
<?php
    echo $this->Form->create('CategoryProject', array('class' => 'category-edit' ));

    echo $this->Form->input('Project.name_en',array('label' => 'Title (en)', 'value' => $project['Project']['name_en'] ) );
    echo $this->Form->input('Project.name_de',array('label' => 'Title (de)', 'value' => $project['Project']['name_de'] ) );
   echo $this->Form->input('Project.id', array('type' => 'hidden', 'value' => $project['Project']['id']));
    ?>
    <p style="margin: 0 20px;">Categories:</p>
    <?php
    echo $this->Form->input('Category.id',array('label' => false ,'type' => 'select', 'multiple' => 'checkbox', 'options' => $categories, 'value' => $s_categories));

    echo $this->Form->submit('SAVE');
    echo $this->Html->link('CANCEL', array('controller' => 'projects' , 'action' => 'index', 'admin' => true), array('class' => 'cancel'));
    echo $this->Form->end();

?>