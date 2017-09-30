<?php 

	class Category extends AppModel{

		public $hasMany = array('CategoryProject', 'Tab');


		function getAllCategories(){

			return $this->find('all', 
				array(
					'order' => array('rank', 'id'),
					'recursive' => -1,
				));
		}





	}


 ?>