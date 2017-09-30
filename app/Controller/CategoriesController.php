<?php

class CategoriesController extends AppController {


    function admin_view($category_id){

        $this->layout = 'admin';

        $this->set(compact('category_id'));
        $categoryproject = $this->Category->CategoryProject->find('all', array(
                'recursive' => 0,
                'conditions' => array('CategoryProject.category_id' => $category_id),
                'order' => array('CategoryProject.rank')
        ));

        $this->set(compact('categoryproject'));

    }


    function admin_index() {
        $this->layout = 'admin';
        $this->set('left_menu', 'list');
        $this->set('categories', $this->Category->find('all', array( 'order' => array('rank', 'id'), 'recursive' => 0)));
    }

    function admin_categoryActive($idCategory = null) {

        $this->autoRender = false;
        $this->Category->id = $idCategory;
        $this->Category->saveField('active', 1);
        $this->redirect(array('controller' => 'projects', 'action' => 'index', $idCategory, 'admin' => true));
       
    }

    function admin_categoryInActive($idCategory = null) {
        $this->autoRender = false;
        $this->Category->id = $idCategory;
        $this->Category->saveField('active', 0);
        $this->redirect(array('controller' => 'projects', 'action' => 'index', $idCategory, 'admin' => true));
       
    }

    function admin_add() {
        $this->layout = 'admin';
        if (!empty($this->data)) {
            if (!empty($this->data['Category']['name_en'])) {
                $this->request->data['Category']['slug'] = Inflector::slug($this->data['Category']['name_en']);
                $this->Category->save($this->data);
                $last_id =  $this->Category->id;
                $this->redirect(array('controller' => 'categories', 'action' => 'index', 'admin' => true));
            }
        }
        
    }

    function admin_edit($id = null) {
        $this->layout = 'admin';
        $this->set('category', $this->Category->read(null, $id));
        if (!empty($this->data)) {
        
                if (!empty($this->data['Category']['name_en'])) {
                    $this->request->data['Category']['slug'] = Inflector::slug($this->data['Category']['name_en']);
                }
        
                $this->Category->save($this->data);
                $last_id =  $this->data['Category']['id'];
                   $this->redirect(array('controller' => 'categories', 'action' => 'index', 'admin' => true));
           
         } 
    }

    function admin_saveOrder() {

        $this->autoRender = false;
        if (!empty($this->data)) {

            foreach ($this->data['Category']['order_rank'] as $key => $value) {
                $this->Category->id = $value;
                $this->Category->saveField('rank', $key);
            }
        }
        $this->redirect(array('action' => 'admin_index'));
    }


    function admin_saveProjects($category_id) {

        $this->autoRender = false;
        if (!empty($this->data)) {
            foreach ($this->data['Project']['order_rank'] as $key => $value) {
               
                $categoryproject = $this->Category->CategoryProject->find('first', array(
                    'recursive' => -1,
                    'conditions' => array('category_id' => $category_id, 'project_id' => $value)));

                $this->Category->CategoryProject->id = $categoryproject['CategoryProject']['id'];
                
                $this->Category->CategoryProject->saveField('rank', $key);
            }
        }
        $this->redirect(array('action' => 'admin_view', $category_id));
    }

    function admin_deleteProject($category_id,$project_id){
        $this->autoRender = false;
        $this->Category->CategoryProject->deleteAll(array('CategoryProject.category_id' => $category_id, 'CategoryProject.project_id' => $project_id),false);
        $this->redirect(array('action' => 'admin_view', $category_id));
    }

    function admin_delete($id = null) {
        $this->Category->delete($id, false);
        $this->redirect(array('action' => 'admin_index'));
    }


    function getCategoryAsJson($category_name) {
        $this->autoRender=false;
        $projects = array();
        $slides = array();
        $this->loadModel('CategoryProject');
        $this->loadModel('Slide');
        $data = $this->Category->find('first', array('conditions' => array('Category.name_en' => $category_name)));
        $cat_id = $data['Category']['id'];
        $data = $this->CategoryProject->find('all', array('conditions' => array('CategoryProject.category_id' => $cat_id)));
        foreach ($data as $key => $item) {
            $data = $this->Slide->find('first', array('conditions' => array('project_id' => $item['Project']['id'], 'active' => 1, 'is_cover' => 1, 'type' => 'image')));
            if ($data != false)           
                array_push($slides, $data);
        }
        $this->set('json_content',$slides);
        //$this->layout = NULL;
        $this->render('/json/default');

        //header("Content-type: application/javascript"); // not necessary
        //echo json_encode($slides);
    }

}

?>