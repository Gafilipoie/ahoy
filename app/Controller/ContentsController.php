<?php 

	App::import('Vendor', 'AjaxUpload',array('file' => 'AjaxUpload' .DS . 'AjaxUpload.php'));
	App::uses('File', 'Utility');

	class ContentsController extends AppController{


    	public $components = array('Thumb');

		function beforeFilter(){
			parent::beforeFilter();
		}


		function view($project_slug){

			$this->autoRender = false;

			$project = $this->Slide->Project->find('first', array(
					'recursive' => -1,
					'conditions' => array('Project.slug' => $project_slug),
				));
			$slides = $this->Slide->find('all', array(
					'recursive' => -1,
					'conditions' => array(
						'Slide.project_id' => $project['Project']['id'], 
						'Slide.is_active' => 1
						),
					'order' => array('Slide.rank'),
				));
			//debug($slides);

			echo json_encode($slides);

		}


		function admin_index($tab_id){
			$this->layout = 'admin';

			$contents = $this->Content->find('all', array(

					'conditions' => array('Content.tab_id' => $tab_id),
					'order' => array('Content.rank'),
					'recursive' => -1,
				));

			$tab =  $this->Content->Tab->findById($tab_id);

			$this->set(compact('tab'));
			$this->set(compact('contents'));
		}

		function admin_save_image_seo() {
			$this->autoRender = false;
			if(!empty($this->data) && isset($this->data['slide_id'])) {
				$this->Content->id = $this->data['slide_id'];
				$this->Content->saveField('image_alt', $this->data['image_alt']);
				$this->Content->saveField('image_title', $this->data['image_title']);
			}
		}


		function admin_save_order(){

			$this->autoRender = false;

			if(!empty($this->data)){

				foreach ($this->data['Content']['rank'] as $key => $value) {
	                $this->Content->id = $value;
	                $this->Content->saveField('rank', $key);
	            }
			}
		}

		function admin_add($tab_id = null){
			$this->layout = 'admin';

			if(!empty($this->data)){
			
				$this->Content->save($this->data);
				$this->redirect(array('controller' => 'contents', 'action' => 'index', $this->data['Content']['tab_id'], 'admin' => true));

			}

			$tab =  $this->Content->Tab->findById($tab_id);

			$this->set(compact('tab'));

		}

	

		function admin_edit($content_id = null){
			$this->layout = 'admin';


			if(!empty($this->data)){
				$this->Content->save($this->data);
				$this->redirect(array('controller' => 'contents', 'action' => 'index', $this->data['Content']['tab_id'], 'admin' => true));

			}
		
			$this->Content->id = $content_id;
			$content = $this->Content->read();
			$this->set(compact('content'));

			$tab =  $this->Content->Tab->findById($content['Content']['tab_id']);
			
			$this->set(compact('tab'));
		}


		function add_image($tab_id,$filename){

			$this->autoRender = false;

			$suffix = '';
			$i = 1;
			$name = pathinfo($filename, PATHINFO_FILENAME);
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$new_name = Inflector::slug($name).'.'.$ext;
			$fileExists = $this->Content->find('first', array('conditions' => array('Content.image' => $new_name)));
			
			while ($fileExists) {
				$suffix = '_'.$i;
				$new_name = Inflector::slug($name).$suffix.'.'.$ext;
				$fileExists = $this->Content->find('first', array('conditions' => array('Content.image' => $new_name)));
				$i++;
			}

			$full_path = WWW_ROOT.'img/uploads/desktop/' . $filename;
			$result = $this->Thumb->doThumb($full_path, 699,469, $suffix);
			var_dump($result);
			//unlink(WWW_ROOT.'img/uploads/desktop/'.$filename);

			$content = array('Content' => array(
						'rank' => '99',
						'type' => 'image',
						'is_active' => 1,
						'image' => $result,
						'image_alt' => '',
						'image_title' => '',
						'tab_id' => $tab_id
				));

			$this->Content->save($content);

		}

		function admin_set_status($content_id){

			$this->Content->id = $content_id;
			$content = $this->Content->read();
			if($content['Content']['is_active'] == 1){
				$this->Content->saveField('is_active', 0);
				echo 'busy';

			}
			if($content['Content']['is_active'] == 0){
				$this->Content->saveField('is_active', 1);
				echo 'active';

			}
			$content = $this->Content->read('tab_id');

			$this->redirect(array('controller' => 'contents', 'action' => 'index', $content['Content']['tab_id'], 'admin' => true));

		}

		

		function admin_delete($content_id){
			$this->Content->id = $content_id;
			$content = $this->Content->read();

			$this->Content->delete($content_id,false);

			$this->redirect(array('controller' => 'contents', 'action' => 'index', $content['Content']['tab_id'], 'admin' => true));


		}


	}


 ?>