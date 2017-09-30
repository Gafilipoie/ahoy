



<table class="normal right">
    <thead>
    <tr>
        <th class="number">#</th>
        <th class="short-length">USERNAME</th>
        <th class="short-length">EMAIL</th>
        <th class="actions" colspan="3">ACTION</th>

    </tr>
    </thead>
     <tbody>
    <?php $i=0;  foreach ($users as $user): $i++; ?>
    <tr  <?php if($i%2 == 0 ) echo 'class="odd"' ?> >
        <td class="number"><?php echo $i; ?></td>
        <td class="short-length"><?php echo $user['User']['username'];?> </td>
            <td  class="short-length"><?php echo $user['User']['email'];?> </td>
        <td class="status">
        <?php 
        if($user['User']['active'] == 0)
                echo $this->Html->link($this->Html->image('status-busy.png')
                        , array('controller' => 'users' , 'action' => 'userActive', $user['User']['id']),array('escape' => false));
        else{
                echo $this->Html->link($this->Html->image('status.png')
                        , array('controller' => 'users' , 'action' => 'userInActive', $user['User']['id']),array('escape' => false));
        }
        ?>
        </td>
        <td class="action">
            <?php echo $this->Html->link('EDIT',
                    array('controller' => 'users' , 'action' => 'edit', 
                        $user['User']['id'])) ?>
        </td>
        <td class="action">
            <?php echo $this->Html->link('DELETE', 
                    array('controller' => 'users' , 'action' => 'delete', 
                        $user['User']['id']), null, 'Are you sure you want to delete?') ?>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
   <?php echo $this->Html->link('ADD USER', array('controller' => 'users' , 'action' => 'add', 'admin' => true), array('class' => 'cancel')) ?>
