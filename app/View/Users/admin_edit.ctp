<?php

    echo $this->Form->create('User', array('class' => 'user-add', 'url' => array('controller' => 'users', 'action' => 'edit')));
?>
<p>EDIT USER</p>
  <?php  
    echo $this->Form->input('username', array('type' => 'text', 'label' => 'Username: ',));
    echo $this->Form->input('email', array('type' => 'text', 'label' => 'Email: ',));
    
 ?>
<p>EDIT PASSWORD</p>
  <?php 
    echo $this->Form->input('old_pass', array('type' => 'text', 'label' => 'Old Password: ',));
    echo $this->Form->input('pass', array('type' => 'text', 'label' => 'New Password: ',));
    echo $this->Form->input('pass2', array('type' => 'text', 'label' => 'Confirm Password: ',));

    echo $this->Form->input('active', array('type' => 'hidden'));
    echo $this->Form->input('type', array('type' => 'hidden', 'value' => 'normal',));
    echo $this->Form->input('id', array('type' => 'hidden', ));
     echo $this->Form->input('password', array('type' => 'hidden', ));
?>
<div class="clearfix">
  <?php 
    
    echo $this->Form->submit('SAVE');
    ?>
</div>
<div class="clearfix">
<?php
    echo $this->Html->link('CANCEL', array('controller' => 'users' , 'action' => 'index'), array('class' => 'cancel'));
    ?>
</div>

<?php
    echo $this->Session->flash();
    echo $this->Form->end(); 
    ?>