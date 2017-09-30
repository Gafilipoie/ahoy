
<div class="right">

    <div class="clearfix"> 
<?php
echo $this->Form->create('Project', array('url' => array('controller' => 'projects', 'action' => 'saveOrder', 'admin' => true)));  ?>

<table class="normal right sortable">
    <thead>
    <tr>
        <th class="number">#</th>
        <th class="long-lenght">Cover</th>
        <th class="long-lenght">Project</th>
        <th class="actions" colspan="3">ACTION</th>

    </tr>
    </thead>
     <tbody>
    <?php $i=0; foreach($categories as $category): $i++; ?>
    <tr  <?php if($i%2 == 0 ) echo 'class="odd"' ?> >
        <td class="number"><?php echo $i; ?></td>
        <td class="long-lenght"><span class="site-blue"><?php echo $category['Category']['name_en'] ?> /</span> <?php echo $category['Category']['name_de'] ?>                    
            <input name="data[Category][order_rank][]" type="hidden" value='<?php echo $category['Category']['id']; ?>' /></td>
  
        
        <td class="status">
        <?php 
        if(empty($category['Category']['active'])){
                echo $this->Html->link($this->Html->image('status-busy.png')
                        , array('controller' => 'categories' , 'action' => 'categoryActive', $category['Category']['id']),array('escape' => false));
        }
        else{
                echo $this->Html->link($this->Html->image('status.png')
                        , array('controller' => 'categories' , 'action' => 'categoryInActive', $category['Category']['id']),array('escape' => false));
        }
        ?>
        </td>
        
        <td class="action">
            <?php echo $this->Html->link('EDIT', array('controller' => 'categories' , 'action' => 'admin_edit', $category['Category']['id'])) ?>
        </td>
                
        <td class="action">
            <?php echo $this->Html->link('DELETE', array('controller' => 'categories' , 'action' => 'admin_delete', $category['Category']['id']), null, 'Are you sure you want to delete?') ?>
        </td>
        

    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php echo $this->Form->end();?>
     </div> 
        
    
<?php
    echo $this->Form->create('Category', array('url' => array('controller' => 'categories', 'action' => 'admin_add'),   'class' => 'category-edit' )); 
    echo $this->Form->input('name_en',array('label' => 'Title (en)') );
    echo $this->Form->input('name_de',array('label' => 'Title (de)') );
    echo $this->Form->input('type',array('label' => 'Type', 'options' => array('projects' => 'projects', 'tabs' => 'tabs')) );
    echo $this->Form->input('order',array('type' => 'hidden', 'value' => 99));
    echo $this->Form->submit('ADD');
    echo $this->Form->end();
?>
</div>
