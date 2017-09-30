<div id="box">
      <div class="block" id="block-login">
        <h2>Login Box</h2>
        <div class="content login">
            <?php
            $message = $this->Session->flash();
            if($message) :?>
          <div class="flash">
            <div class="message notice">
              <p><?php echo $message ?></p>
            </div>
          </div>
            <?php endif; ?>
            
            
            <?php echo $this->Form->create ('User', array('url' => array('controller' => 'users', 'action' => 'change_password'))); 
            
            echo $this->Form->input('old_pass', array('label' => 'Old password', 'type' => 'password'));
            
            echo $this->Form->input('new_pass1', array('label' => 'New Password', 'type' => 'password'));
            
            echo $this->Form->input('new_pass2', array('label' => 'Retype Password', 'type' => 'password'));
  
            echo $this->Form->end('Change'); ?>
            
        </div>
      </div>
</div>