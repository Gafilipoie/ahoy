
<?php
    echo $this->Form->create('Setting', array('class' => 'options' ));
    
    
    
                    $i = 0;
                foreach ($settings as $setting){
                 $i++;
                 echo $this->Form->input('Setting.'.$i.'.value', array('type' => 'textarea', 'label' => $setting['Setting']['name'] ,'value' => $setting['Setting']['value'] ));
                 echo $this->Form->input('Setting.'.$i.'.id', array('type' => 'hidden', 'value' => $setting['Setting']['id'] ));
          
                }
    
    

  
    
    echo $this->Form->submit('SAVE');
   
    echo $this->Form->end();
?>
    