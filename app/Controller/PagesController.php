<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Pages';

/**
 * Default helper
 *
 * @var array
 */
	public $helpers = array('Html', 'Session');

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();


	function _bot_detected() {
		if(!isset($_SERVER['HTTP_USER_AGENT'])) return TRUE;
	  if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/bot|crawl|slurp|spider/i', $_SERVER['HTTP_USER_AGENT'])) {
	    return TRUE;
	  }
	  else {
	    return FALSE;
	  }

	}

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 */
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		} else {
			$subpage = '';
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		//$this->render(implode('/', $path));
		$isRobot = $this->_bot_detected();
		$this->set('isRobot', $isRobot);
    
		if(isset($subpage) && $isRobot) {
	    if($subpage == '' && $page == 'home') {
	    	$this->loadModel('Tab');
		    $tabs = $this->Tab->find('all');
		    $this->set('tabs_robot', $tabs);
		  } else {
		    $this->loadModel('CategoryProject');
		    $this->loadModel('Slide');
		  	$categories = $this->Category->find('all');
		    foreach ($categories as $value) {
		    	$nameurl = str_replace(' & ', '_', $value['Category']['name_en']);
		    	$nameurl = str_replace(' ', '_', $nameurl);
		    	if($nameurl == $subpage) {
		    		$cat_id = $value['Category']['id'];
		   	 		$data = $this->CategoryProject->find('all', array('conditions' => array('CategoryProject.category_id' => $cat_id)));
		   	 		foreach ($data as &$item) {
		   	 			$slide = $this->Slide->find('all', array('conditions' => array('project_id' => $item['Project']['id'])));
		   	 			$item['Project']['Slides'] = $slide;
		   	 		}
		   	 		$this->set('data_robot', $data);
		    	}
		    }		  	
		  }

	  }
		$this->render('/Pages/home');
	}
}
