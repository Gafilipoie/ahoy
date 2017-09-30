<h4 class="categories">PROJECTS</h4>
    <div class="clearfix"> 

<?php echo $this->Html->link('ADD NEW', array('controller' => 'projects', 'action' => 'add', 'admin' => true), array('class' => 'cancel right')) ?>

<table class="normal right">
    <thead>
    <tr>
        <th class="number">#</th>
        <th class="long-lenght">NAME</th>
        <th class="actions" colspan="4">ACTION</th>

    </tr>
    </thead>
     <tbody>
    <?php $i=0; foreach($projects as $project): $i++; ?>
    <tr  <?php if($i%2 == 0 ) echo 'class="odd"' ?> >
        <td class="number"><?php echo $i; ?></td>
        <td class="long-lenght"><span class="site-blue"><?php echo $project['Project']['name_en'] ?> /</span> <?php echo $project['Project']['name_de'] ?>   
  
        <td class="status">
        <?php 
        if(empty($project['Project']['active'])){
                echo $this->Html->link($this->Html->image('status-busy.png')
                        , array('controller' => 'projects' , 'action' => 'projectActive', $project['Project']['id']),array('escape' => false));
        }
        else{
                echo $this->Html->link($this->Html->image('status.png')
                        , array('controller' => 'projects' , 'action' => 'projectInActive', $project['Project']['id']),array('escape' => false));
        }
        ?>
        </td>
      
    
        <td class="action">
            <?php echo $this->Html->link('SLIDES', array('controller' => 'slides' , 'action' => 'admin_index', $project['Project']['id'])) ?>
        </td>
        <td class="action">
            <?php echo $this->Html->link('EDIT', array('controller' => 'projects' , 'action' => 'admin_edit', $project['Project']['id'])) ?>
        </td>
                
        <td class="action">
            <?php echo $this->Html->link('DELETE', array('controller' => 'projects' , 'action' => 'admin_delete', $project['Project']['id']), null, 'Are you sure you want to delete?') ?>
        </td>
        

    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

     </div> 
