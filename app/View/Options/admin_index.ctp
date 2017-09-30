

<h4 class="categories">OPTIONS</h4>
<?php
    echo $this->Form->create('Option', array('class' => 'options' ));



                    $i = 0;
                foreach ($options as $setting){
                 $i++;
                 echo $this->Form->input('Option.'.$i.'.value', array('type' => 'textarea', 'label' => $setting['Option']['name'] ,'value' => $setting['Option']['value'] ));
                 echo $this->Form->input('Option.'.$i.'.id', array('type' => 'hidden', 'value' => $setting['Option']['id'] ));

                }





    echo $this->Form->submit('SAVE');

    echo $this->Form->end();
?>
