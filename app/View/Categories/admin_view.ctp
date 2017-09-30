
    <div class="clearfix"> 
        <h4 class="categories">CATEGORY - ORDER PROJECTS</h4>
<?php
echo $this->Form->create('Project', array('url' => array('controller' => 'categories', 'action' => 'saveProjects',$category_id, 'admin' => true)));  ?>

<table class="normal right sortable">
    <thead>
    <tr>
        <th class="number">#</th>
        <th class="">Project</th>
        <th>Action</th>

    </tr>
    </thead>
     <tbody>
    <?php
     $i=0; foreach($categoryproject as $project): $i++; ?>
    <tr  <?php if($i%2 == 0 ) echo 'class="odd"' ?> >
        <td class="number"><?php echo $i; ?></td>
        <td class="long-lenght"><span class="site-blue"><?php echo $project['Project']['name_en'] ?> /</span> <?php echo $project['Project']['name_de'] ?>                    
            <input name="data[Project][order_rank][]" type="hidden" value='<?php echo $project['Project']['id']; ?>' /></td>
  
        
        <td class="status">
        <?php 
                echo $this->Html->link($this->Html->image('icon-delete.png')
                        , array('controller' => 'categories' , 'action' => 'deleteProject',$project['CategoryProject']['category_id'], $project['CategoryProject']['project_id']),array('escape' => false));
        ?>
        </td>
        

    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php echo $this->Form->end();?>
     </div> 
        

