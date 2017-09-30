<?php


class AppController extends Controller {
  
  	public $components = array(
	    'Auth' => array(
	        'loginAction' => array(
	            'controller' => 'users',
	            'action' => 'login',
	            'admin' => false
	        ),
	        'authError' => 'Please login!',
	        'authenticate' => array(
	            'Form' 
	        ),
	        'loginRedirect' => array('controller' => 'categories', 'action' => 'index', 'admin' => true),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
	        'authorize' => 'Controller'
	    ),
	    'Session',
	);



    public function isAuthorized($user = null) {
        // Any registered user can access public functions
        if (empty($this->request->params['admin'])) {
            return true;
        }

        // Only admins can access admin functions
        if (isset($this->request->params['admin'])) {

            return (bool)($user);
        }

        // Default deny
        return false;
    }


	function beforeFilter(){

		parent::beforeFilter();

		$user_agent = env('HTTP_USER_AGENT');

		$is_iPhone = 0;
        $is_iPad = 0;
        if (preg_match('/iphone/i', $user_agent)) {
         	$is_iPhone = 1;  
        }
        else{
         	if (preg_match('/ipad/i', $user_agent)) {
	        	$is_iPad = 1;  
	        }
        }
        $this->set(compact('is_iPad'));
        $this->set(compact('is_iPhone'));

		$this->set('selected_menu', '');

		if(empty($this->request->params['prefix']) || $this->request->params['prefix'] != 'admin'){
			$this->Auth->allow();
		}

		$this->LoadModel('Option');
		try{
		$options = $this->Option->find('list', array(
					'fields' => array('Option.slug', 'Option.value')
			));

	}catch(Exception $e){var_dump($e);die;}
		$this->set('options', $options);

		


		$this->LoadModel('Setting');

		$settings = Cache::read('');

		if($settings === false){
			$settings = $this->Setting->find('list', array(
					'fields' => array('Setting.slug', 'Setting.value'),
				));
			Cache::write('settings',$settings);
		}

		$this->set('json_settings', json_encode($settings));

	

		$this->loadModel('Category');
		$this->set('admin_categories', $this->Category->getAllCategories());




	    $categories = $this->Category->find('all',
            array(
                'recursive' => '-1',
                'conditions' => array('Category.active' => 1),
                'order' => array('Category.rank', 'Category.name_en' )
            )
        );

        $this->loadModel('Project');
        $this->loadModel('CategoryProject');
	   
	    /*
        $catProjects = $this->Project->CategoryProject->Category->find('list', 
                array(
                    //'fields' => array('Category.id', 'Category.name_en'),
                    'order' => array('rank', 'id'),
                    'recursive' => -1,
                    'conditions' => array('Category.type' => 'projects'),
                ));
		$this->set(compact('catProjects'));
		*/
		$catProjects = array();
		foreach ($categories as $c) {
			$ci = $c['Category']['id'];
			$catProjects[$ci] = $this->Project->CategoryProject->find('all', 
	            array( 
	                'order' => array('CategoryProject.rank', 'CategoryProject.id'), 
	                'recursive' => 0,
	                'conditions' => array(
	                    'CategoryProject.category_id' => $ci,
	                    'Project.active' => 1
	                ),
	                'fields' => array('Project.id', 'Project.name_en', 'Project.slug')
	            ));
		}
    

        $this->set(compact('categories'));
        $this->set(compact('catProjects'));

		//$this->CategoryProject->find('all', array('conditions' => array('CategoryProject.category_id' => $cat_id)));

	}


}
