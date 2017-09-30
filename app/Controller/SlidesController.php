<?php 

	App::import('Vendor', 'AjaxUpload',array('file' => 'AjaxUpload' .DS . 'AjaxUpload.php'));
	App::uses('File', 'Utility');

	class SlidesController extends AppController{


    	public $components = array('Thumb');

		function beforeFilter(){
			parent::beforeFilter();
		}


		function view($project_slug){

			$this->autoRender = false;

			$project = $this->Slide->Project->find('first', array(
					'recursive' => -1,
					'conditions' => array('LOWER(Project.slug)' => strtolower($project_slug)),
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


		function admin_index($project_id){
			if(!isset($project_id)) die("You haven't provided a project id. This URL is invalid.");
			
			$this->layout = 'admin';



			$slides = $this->Slide->find('all', array(

					'conditions' => array('Slide.project_id' => $project_id),
					'order' => array('Slide.rank'),
					'recursive' => -1,
				));

			$project =  $this->Slide->Project->findById($project_id);

			$this->set(compact('project'));

			$this->set(compact('slides'));
			$this->set('project_id', $project_id);
		}

		function admin_save_order(){

			$this->autoRender = false;

			if(!empty($this->data)){

				foreach ($this->data['Slide']['rank'] as $key => $value) {
	                $this->Slide->id = $value;
	                $this->Slide->saveField('rank', $key);
	            }

			}


		}

		function admin_save_image_seo() {
			$this->autoRender = false;
			//var_dump($this->data);
			if(!empty($this->data) && isset($this->data['slide_id'])) {
				$this->Slide->id = $this->data['slide_id'];
				$this->Slide->saveField('image_alt', $this->data['image_alt']);
				$this->Slide->saveField('image_title', $this->data['image_title']);
			}
		}

		function admin_add($project_id = null){
			$this->layout = 'admin';

			if(!empty($this->data)){
			
				if($this->Slide->save($this->data))
					$this->redirect(array('controller' => 'slides', 'action' => 'index', $this->data['Slide']['project_id'], 'admin' => true));

			}


			$project =  $this->Slide->Project->findById($project_id);

			$this->set(compact('project'));

			$this->set('project_id', $project_id);
		}

		function admin_addvideo($project_id = null){

			$this->layout =  'admin';

			if(!empty($this->data)){
				
				if(!empty($this->data['Slide']['flv'])){
					$full_path = WWW_ROOT.'img/uploads/videos/'.$this->data['Slide']['flv'];
					$file_info = pathinfo($full_path);
					$new_name = uniqid().'_'.Inflector::slug($file_info['filename'], '-').'.'.$file_info['extension'];
					$this->request->data['Slide']['flv'] = $new_name;
					rename($full_path, WWW_ROOT.'img/uploads/videos/'.$new_name);
				}
				else{
					unset($this->request->data['Slide']['flv']);
				}

				if(!empty($this->data['Slide']['mp4'])){
					$full_path = WWW_ROOT.'img/uploads/videos/'.$this->data['Slide']['mp4'];
					$file_info = pathinfo($full_path);
					$new_name = uniqid().'_'.Inflector::slug($file_info['filename'], '-').'.'.$file_info['extension'];
					$this->request->data['Slide']['mp4'] = $new_name;
					rename($full_path, WWW_ROOT.'img/uploads/videos/'.$new_name);
				}
				else{
					unset($this->request->data['Slide']['mp4']);
				}

				if(!empty($this->data['Slide']['ogv'])){
					$full_path = WWW_ROOT.'img/uploads/videos/'.$this->data['Slide']['ogv'];
					$file_info = pathinfo($full_path);
					$new_name = uniqid().'_'.Inflector::slug($file_info['filename'], '-').'.'.$file_info['extension'];
					$this->request->data['Slide']['ogv'] = $new_name;
					rename($full_path, WWW_ROOT.'img/uploads/videos/'.$new_name);
				}
				else{
					unset($this->request->data['Slide']['ogv']);
				}

				if(!empty($this->data['Slide']['webm'])){
					$full_path = WWW_ROOT.'img/uploads/videos/'.$this->data['Slide']['webm'];
					$file_info = pathinfo($full_path);
					$new_name = uniqid().'_'.Inflector::slug($file_info['filename'], '-').'.'.$file_info['extension'];
					$this->request->data['Slide']['webm'] = $new_name;
					rename($full_path, WWW_ROOT.'img/uploads/videos/'.$new_name);
				}
				else{
					unset($this->request->data['Slide']['webm']);
				}

				if(!empty($this->data['Slide']['img'])){

					$filename = $this->data['Slide']['img'];
					$desktop_path = WWW_ROOT.'img/uploads/desktop/'.$filename;
					$ext = end(explode('.', $filename));
					$file_info = pathinfo($desktop_path);
					$new_name = ''.Inflector::slug($file_info['filename'], '-').'.'.$file_info['extension'];

					$i=1;
					while (file_exists(WWW_ROOT.'img/uploads/desktop/'.$new_name)) {
						$ext = end(explode('.', $filename));
						$file_info = pathinfo($desktop_path);
						$new_name = ''.Inflector::slug($file_info['filename'], '-').'-'.$i.'.'.$file_info['extension'];
						$i++;
					}
					
					rename($desktop_path, WWW_ROOT.'img'.DS.'uploads'.DS.'desktop'.DS.$new_name);
					$this->request->data['Slide']['image'] = $new_name;

				}
				else{
					unset($this->request->data['Slide']['image']);
				}

				if($this->Slide->save($this->data))
					$this->redirect(array('controller' => 'slides', 'action' => 'index', $this->data['Slide']['project_id'], 'admin' => true));
				/*else
					$this->redirect(array('controller' => 'slides', 'action' => 'index', $this->data['Slide']['project_id'], 'admin' => true));*/
			}

			$project =  $this->Slide->Project->findById($project_id);

			$this->set(compact('project'));

			$this->set('project_id', $project_id);

		}


		function admin_editvideo($slide_id = null){

			$this->layout =  'admin';
			$slide =  $this->Slide->findById($slide_id);
			$project_id = $slide['Slide']['project_id'];

			$project =  $this->Slide->Project->findById($project_id);

			$this->set(compact('project'));
			$this->set(compact('slide'));
			$this->set('project_id', $project_id);

		}

		function admin_edit($slide_id = null){
			$this->layout = 'admin';


			if(!empty($this->data)){
				$this->Slide->save($this->data);
				$this->redirect(array('controller' => 'slides', 'action' => 'index', $this->data['Slide']['project_id'], 'admin' => true));

			}
		
			$this->Slide->id = $slide_id;
			$slide = $this->Slide->read();
			$this->set(compact('slide'));

			$project =  $this->Slide->Project->findById($slide['Slide']['project_id']);
			
			$this->set(compact('project'));
		}

		function load($type = 'image'){

			$this->autoRender = false;

			// list of valid extensions, ex. array("jpeg", "xml", "bmp")
			$allowedExtensions = array();
			// max file size in bytes
			$sizeLimit = 10 * 1024 * 1024;

			$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);

			if ($type == 'video')
				$result = $uploader->handleUpload(WWW_ROOT.'img/uploads/videos/');
			else
				$result = $uploader->handleUpload(WWW_ROOT.'img/uploads/desktop/');
			// to pass data through iframe you will need to encode all html tags
			echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);	
		}

		function add_image($project_id,$filename){
			$this->autoRender = false;
			$desktop_path = WWW_ROOT.'img/uploads/desktop/'.$filename;
			$ext = end(explode('.', $filename));
			$file_info = pathinfo($desktop_path);

			$new_name = ''.Inflector::slug($file_info['filename'], '-').'.'.$file_info['extension'];

			$i=1;
			while (file_exists(WWW_ROOT.'img/uploads/desktop/'.$new_name)) {
				$ext = end(explode('.', $filename));
				$file_info = pathinfo($desktop_path);
				$new_name = ''.Inflector::slug($file_info['filename'], '-').'-'.$i.'.'.$file_info['extension'];
				$i++;
			}
			
			rename($desktop_path, WWW_ROOT.'img'.DS.'uploads'.DS.'desktop'.DS.$new_name);
			$desktop_path = WWW_ROOT.'img/uploads/desktop/'.$new_name;
			copy($desktop_path, WWW_ROOT.'img'.DS.'uploads'.DS.'mobile'.DS.$new_name);

			if($ext != 'gif'){
				$mobile_path = WWW_ROOT.'img/uploads/mobile/'.$new_name;
				$result = $new_name;
				$this->make_thumb($desktop_path, $mobile_path, 250);
			} else {
				$result = $new_name;
			}
			
			$slide = array('Slide' => array(
				'rank' => '99',
				'type' => 'image',
				'image' => $result,
				'is_active' => 1,
				'project_id' => $project_id
			));

			$this->Slide->save($slide);
		}

		function admin_set_status($slide_id){

			$this->autoRender = false;

			$this->Slide->id = $slide_id;
			$slide = $this->Slide->read();
			if($slide['Slide']['is_active'] == 0){
				$this->Slide->saveField('is_active', 1);
				echo 'active';
			}
			else{
				$this->Slide->saveField('is_active', 0);
				echo 'busy';
			}
			
		//	$this->redirect(array('controller' => 'slides', 'action' => 'index', $slide['Slide']['project_id'], 'admin' => true));
		}

		function admin_set_cover($slide_id, $project_id){
			$this->Slide->updateAll(
			    array('Slide.is_cover' => 0),
			    array('Slide.project_id' => $project_id)
			);	
			$this->Slide->id = $slide_id;
			$this->Slide->saveField('is_cover', 1);
			$this->redirect(array('controller' => 'slides', 'action' => 'index', $project_id, 'admin' => true));

		}

		function admin_delete($slide_id){

			$this->Slide->id = $slide_id;
			$slide = $this->Slide->read();
			if($slide['Slide']['type'] == 'image'){
				if($file = new File(WWW_ROOT ."/img/uploads/desktop/".$slide['Slide']['image']))
					$file->delete();
				if($file = new File(WWW_ROOT ."/img/uploads/mobile/".$slide['Slide']['image']))
					$file->delete();
			}

			$slide = $this->Slide->read('project_id');
			$this->Slide->delete($slide_id,false);
			$this->redirect(array('controller' => 'slides', 'action' => 'index', $slide['Slide']['project_id'], 'admin' => true));
		}

		function make_thumb($src, $dest, $desired_width) {

			/* read the source image */
			$source_image = imagecreatefromjpeg($src);
			$width = imagesx($source_image);
			$height = imagesy($source_image);
			
			/* find the "desired height" of this thumbnail, relative to the desired width  */
			$desired_height = floor($height * ($desired_width / $width));
			
			/* create a new, "virtual" image */
			$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
			
			/* copy source image at a resized size */
			imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
			
			/* create the physical thumbnail image to its destination */
			imagejpeg($virtual_image, $dest, 100);
		}


	}


 ?>