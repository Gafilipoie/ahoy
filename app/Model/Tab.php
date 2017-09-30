<?php 

	class Tab extends AppModel{

		public $belongsTo = array('Category');
		public $hasMany = array('Content');



	}


 ?>