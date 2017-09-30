

<div class="block block-medium" id="block-tables"> 

    <div class="content"> 
        <h2 class="title">Settings</h2> 
        <div class="inner"> 

            <table class="table"> 
                <tr> 
                  
                    <th>Name</th> 
                    <th>Value</th> 
                  
                </tr> 
                <?php
                $i = 0;
                foreach ($settings as $setting):
                    
                    $i++;
                    if ($i % 2 == 0) {
                        echo '<tr class="even">';
                    } else {
                        echo '<tr class="odd">';
                    }
                    
?>
                   
                    <td><?php echo $setting['Setting']['tag'] ?></td>

                    <td><?php
                    
                    echo $this->Form->create('Setting', array('class' => 'form', 'url' => array('controller' => 'settings', 'action' => 'edit')));
                                  echo $this->Form->hidden('id', array('value' => $setting['Setting']['id'])); 
                                
                    echo $this->Form->text('value',array( 'value' => $setting['Setting']['value'], 'class' => 'settings-input'));
                     echo $this->Form->end();                    ?>
                    </td>

                    </tr> 
                
                <?php endforeach; ?>
            </table> 
        </div> 
        <h2 class="title"><?php echo $this->Session->flash(); ?> </h2> 

    </div>

</div> 

 


