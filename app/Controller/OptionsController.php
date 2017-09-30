<?php

class OptionsController extends AppController {

  


    function admin_index() {

        $this->layout = 'admin';

        $this->set('options', $this->Option->find('all'));
        
       
        if (!empty($this->data)) {
            foreach($this->data['Option'] as $setting){
               $this->Option->save($setting);
                 } 
             $this->redirect(array('action' => 'admin_index'));
        }
    }
    
    
 
}

?>
