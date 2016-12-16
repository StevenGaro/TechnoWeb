<?php
	class View
	{
		private $model;
		private $controller;
		private $view
		
		public function __construct( $model,$view)
		{
			//$this->controller = $controller;
			$this->model = $model ;
			$his->view = $view;
		}	
		
		public function Output()
		{
			include ($this>view);
		}
	}
?>