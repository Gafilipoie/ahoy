<?php

class SettingsController extends AppController {





    function admin_index() {
        
        $this->layout = 'admin';
       
        if (!empty($this->data)) {
            $this->Setting->saveAll($this->data['Setting']);
            Cache::delete('settings');
        }

        $this->set('settings', $this->Setting->find('all'));
    }
    
}

?>
