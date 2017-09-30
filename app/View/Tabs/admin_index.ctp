    

<h4 class="categories">TABS</h4>
    <div class="clearfix"> 
<?php echo $this->Form->create('Tab', array('url' => array('controller' => 'tabs', 'action' => 'save_order', $category_id, 'admin' => true))); ?>
<table class="normal right sortable">
    <thead>
    <tr>
        <th class="number">#</th>
        <th class="long-lenght">NAME</th>
        <th class="actions" colspan="4">ACTION</th>

    </tr>
    </thead>
     <tbody>
    <?php $i=0; foreach($tabs as $tab): $i++; ?>
    <tr  <?php if($i%2 == 0 ) echo 'class="odd"' ?> >
        <td class="number"><?php echo $i; ?></td>
        <td class="long-lenght"><span class="site-blue"><?php echo $tab['Tab']['name_en'] ?> /</span> <?php echo $tab['Tab']['name_de'] ?>   
  
        <td class="status">
        <?php 

        echo $this->Form->input('rank.', array('type' => 'hidden','value' => $tab['Tab']['id'])); 

        if(empty($tab['Tab']['active'])){
                echo $this->Html->link($this->Html->image('status-busy.png')
                        , array('controller' => 'tabs' , 'action' => 'tabActive', $tab['Tab']['id']),array('escape' => false));
        }
        else{
                echo $this->Html->link($this->Html->image('status.png')
                        , array('controller' => 'tabs' , 'action' => 'tabInActive', $tab['Tab']['id']),array('escape' => false));
        }
        ?>
        </td>
      
    
        <td class="action">
            <?php echo $this->Html->link('CONTENT', array('controller' => 'contents' , 'action' => 'admin_index', $tab['Tab']['id'])) ?>
        </td>
        <td class="action">
            <?php echo $this->Html->link('EDIT', array('controller' => 'tabs' , 'action' => 'admin_edit', $tab['Tab']['id'])) ?>
        </td>
                
        <td class="action">
            <?php echo $this->Html->link('DELETE', array('controller' => 'tabs' , 'action' => 'admin_delete', $tab['Tab']['id']), null, 'Are you sure you want to delete?') ?>
        </td>
        

    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php echo $this->Form->end();  ?>
     </div> 


<?php
    echo $this->Form->create('Tab', array('url' => array('controller' => 'tabs', 'action' => 'add' , 'admin' => true),   'class' => 'category-edit' )); 
    ?>
<p class="full-line">NEW TAB</p>
    <?php
    echo $this->Form->input('name_en',array('label' => 'Title (en)') );
    echo $this->Form->input('name_de',array('label' => 'Title (de)') );
    echo $this->Form->input('category_id', array('type' => 'hidden' , 'value' => $category_id));
    echo $this->Form->input('order',array('type' => 'hidden', 'value' => 99));
    echo $this->Form->submit('ADD');
    echo $this->Form->end();
?>