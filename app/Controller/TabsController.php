<?php

class TabsController extends AppController {



    function view($category_slug = null, $json = false){
     

        $category = $this->Tab->Category->find('first', 
            array( 
                'recursive' => -1,
                'conditions' => array('Category.slug' => $category_slug)
            ));


        $this->Tab->Behaviors->attach('Containable');

        $tabs = $this->Tab->find('all', 
            array( 
                'order' => array('Tab.rank', 'Tab.name_en'), 
                'conditions' => array(
                    'Tab.category_id' => $category['Category']['id'],
                ),
                'contain' => array('Content' => array(
                        'order' => array('Content.rank'),
                        'conditions' => array(
                            'Content.is_active' => 1,
                        ),
                    ))
            ));

        
        $category['Tab'] = $tabs;

        if($json == true){
            $this->autoRender = false;
            echo json_encode($category);
            die();
        }
        else{
            // debug($category);
            // die;
            $this->set(compact('category'));

            $this->set('selected_menu', $category_slug);  
        }
    }



    function admin_index($category_id = null) {

        $this->layout = 'admin';

        $this->set(compact('category_id'));
        $this->set('tabs', $this->Tab->find('all', 
            array( 'order' => array('Tab.rank', 'Tab.name_en'), 
            'recursive' => -1,
            'conditions' => array('Tab.category_id' => $category_id),
            )));
    }




    function admin_add() {
        $this->autoRender = false;


        if (!empty($this->data)) {
            if (!empty($this->data['Tab']['name_en'])) {
                $this->request->data['Tab']['slug'] = Inflector::slug($this->data['Tab']['name_en']);
                $this->Tab->save($this->data['Tab']);
            }

            $this->redirect( array('controller' => 'tabs', 'action' => 'index', $this->data['Tab']['category_id'], 'admin' => true));
        } 



    }

    function admin_edit($id = null) {
        $this->layout = 'admin';
        
        $tab =  $this->Tab->findById($id);

        $this->set('tab', $tab);

        if (!empty($this->data)) {

        	if (!empty($this->data['Tab']['name_en'])) {
                $this->request->data['Tab']['slug'] = Inflector::slug($this->data['Tab']['name_en']);
                $this->Tab->save($this->data['Tab']);
            }

            $this->redirect( array('controller' => 'tabs', 'action' => 'index', $this->data['Tab']['category_id'], 'admin' => true));
           
         } 

    }


    function admin_tabActive($idtab = null) {

        $this->autoRender = false;
        $this->Tab->id = $idtab;
        $tab = $this->Tab->read();
        $this->Tab->saveField('active', 1);
        $this->redirect(array('controller' => 'tabs', 'action' => 'index',$tab['Tab']['category_id'],'admin' => true));
       
    }

    function admin_tabInActive($idtab = null) {
    
        $this->autoRender = false;
        $this->Tab->id = $idtab;
        $tab = $this->Tab->read();
        $this->Tab->saveField('active', 0);
        $this->redirect(array('controller' => 'tabs', 'action' => 'index',$tab['Tab']['category_id'],'admin' => true));
     }






    function admin_save_order($category_id = null) {

        $this->autoRender = false;
        if (!empty($this->data)) {
            foreach ($this->data['Tab']['rank'] as $key => $value) {
                $this->Tab->id = $value;
                $this->Tab->saveField('rank', $key);
            }
        }

        $this->redirect(array('controller' => 'tabs', 'action' => 'index',$category_id,'admin' => true));


    }

    function admin_delete($id = null) {
    	$this->Tab->id = $id;
    	$tab = $this->Tab->read();
        $this->Tab->delete($id, true);
        $this->redirect(array('controller' => 'tabs', 'action' => 'index',$tab['Tab']['category_id'], 'admin' => true));
    }

}

?>
