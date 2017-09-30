<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->css('admin'); ?>
    </head>
    <body>


        <div id="wrapper">

            <div id="header" class="clearfix">
                <p class="left">AHOY STUDIOS
                </p> 
                <p class="right">CMS</p>
            </div>

            <div id="content">
                <?php

					    echo $this->Form->create('User', array('class' => 'user-add','style' => 'margin: 130px auto; float: none' , 'url' => array('controller' => 'users', 'action' => 'login')));
					?>
					<p>LOGIN</p>
					  <?php  
					echo $this->Form->input('username', array('label' => 'Username:',));

					echo $this->Form->input('password', array('label' => 'Password:'))
					    
					 ?>
					<div class="clearfix">
					  <?php 
					    echo $this->Form->submit('LOGIN');
					    ?>
					</div>

					<?php
					    echo $this->Session->flash();
					    echo $this->Form->end(); 
  					  ?>
            </div>

        </div>

    </body>
</html>

