<?php

class ProjectsController extends AppController {




    function view($category_slug = null, $json = false){



        $category = $this->Project->CategoryProject->Category->find('first',
            array(
                'recursive' => -1,
                'conditions' => array('Category.slug' => $category_slug)
            ));

        $projects = $this->Project->CategoryProject->find('all',
            array(
                'order' => array('CategoryProject.rank', 'CategoryProject.id'),
                'recursive' => 0,
                'conditions' => array(
                    'CategoryProject.category_id' => $category['Category']['id'],
                    'Project.active' => 1
                ),
                'fields' => array('Project.id')
            ));

        foreach ($projects as $key => &$project) {

            $slide = $this->Project->Slide->find('first', array(
                'conditions' => array(
                    'Slide.is_cover' => 1,
                    'Slide.project_id' => $project['Project']['id'],
                ),
                'recursive' => 1,
            ));

            if(is_array($slide)){
                $projects[$key] = array_merge($project,$slide);
            }

            else{
                unset($projects[$key]);

            }

        }

        $category['Project'] = array_values($projects);

        if($json == true){
            $this->autoRender = false;
            echo json_encode($category);
        }

        else{
            $this->set(compact('category'));
            $this->set('selected_menu', $category_slug);
            //debug($category);
        }
    }



    function admin_index() {

        $this->layout = 'admin';




        $this->set('left_menu', 'list');
        $this->set('projects', $this->Project->find('all',
            array( 'order' => array('Project.name_en','Project.id'),
            'recursive' => -1,
            )));


    }




    function admin_add() {
        $this->layout = 'admin';


        $categories = $this->Project->CategoryProject->Category->find('list',
                array(
                    'fields' => array('Category.id', 'Category.name_en'),
                    'order' => array('rank', 'id'),
                    'recursive' => -1,
                    'conditions' => array('Category.type' => 'projects'),
                ));


        $this->set('categories', $categories);

        if (!empty($this->data)) {
            if (!empty($this->data['Project']['name_en'])) {
                $this->request->data['Project']['slug'] = Inflector::slug($this->data['Project']['name_en'], $replacement = '-');
                $this->Project->save($this->data['Project']);

                $project_id = $this->Project->id;

                $category_project = array();
                foreach($this->data['Category']['id'] as $category_id){
                    $cat_proj['CategoryProject']['project_id'] = $project_id;
                    $cat_proj['CategoryProject']['category_id'] = $category_id;
                    $cat_proj['CategoryProject']['rank'] = 99;
                    $category_project[] = $cat_proj;
                }


                $this->Project->CategoryProject->saveAll($category_project);

                $this->redirect(array('controller' => 'projects', 'action' => 'index', 'admin' => true));
            }
        }



    }

    function admin_edit($id = null) {
        $this->layout = 'admin';

        $project =  $this->Project->findById($id);

        $this->set('project', $project);

        $s_categories = array();
        foreach($project['CategoryProject'] as $cat_proj){
            $s_categories[] = $cat_proj['category_id'];
        }


        $this->set(compact('s_categories'));

        $categories = $this->Project->CategoryProject->Category->find('list',
                array(
                    'fields' => array('Category.id', 'Category.name_en'),
                    'order' => array('rank', 'id'),
                    'recursive' => -1,
                    'conditions' => array('Category.type' => 'projects'),
                ));


        $this->set('categories', $categories);



        if (!empty($this->data)) {

                if (!empty($this->data['Project']['name_en'])) {
                    $this->request->data['Project']['slug'] = Inflector::slug($this->data['Project']['name_en'], $replacement = '-');
                }
                $this->Project->save($this->data['Project']);
                $project_id = $this->Project->id;
                $category_project = array();

                $old_categories = $s_categories;
                $new_categories = array();

                foreach($this->data['Category']['id'] as $category_id){
                    $new_categories[] = $category_id;
                    if(in_array($category_id, $s_categories)){
                        continue;
                    }
                    else{
                        $cat_proj = array();
                        $cat_proj['CategoryProject']['project_id'] = $project_id;
                        $cat_proj['CategoryProject']['category_id'] = $category_id;
                        $cat_proj['CategoryProject']['rank'] = 99;
                        $this->Project->CategoryProject->create();
                        $this->Project->CategoryProject->save($cat_proj);
                        $category_project[] = $cat_proj;
                    }

                }

                $delete_categories = array_diff($old_categories, $new_categories);


                $this->Project->CategoryProject->deleteAll(array('project_id' => $project_id, 'category_id' => $delete_categories), false);

                $this->redirect(array('controller' => 'projects', 'action' => 'index', 'admin' => true));

         }


    }


    function admin_projectActive($idProject = null) {

        $this->autoRender = false;
        $this->Project->id = $idProject;
        $this->Project->saveField('active', 1);
        $this->redirect(array('controller' => 'projects', 'action' => 'index', 'admin' => true));

    }

    function admin_projectInActive($idProject = null) {
        $this->autoRender = false;
        $this->Project->id = $idProject;
        $this->Project->saveField('active', 0);
        $this->redirect(array('controller' => 'projects', 'action' => 'index', 'admin' => true));
     }






    function admin_saveOrder() {

        $this->autoRender = false;
        if (!empty($this->data)) {
            foreach ($this->data['Project']['order_rank'] as $key => $value) {
                $this->Project->id = $value;
                $this->Project->saveField('rank', $key);
            }
        }

    }

    function admin_delete($id = null) {
        $this->autoRender = false;
        $this->Project->CategoryProject->deleteAll(array('CategoryProject.project_id' => $id), false);
        $this->Project->Slide->deleteAll(array('Slide.project_id' => $id), false);
        $this->Project->delete($id);
        $this->redirect(array('controller' => 'projects', 'action' => 'index', 'admin' => true));
    }

}

?>
