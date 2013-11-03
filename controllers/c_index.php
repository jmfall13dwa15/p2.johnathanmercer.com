<?php

class index_controller extends base_controller {
	
	/*-------------------------------------------------------------------------------------------------

	-------------------------------------------------------------------------------------------------*/
	public function __construct() {
		parent::__construct();
	} 
		
	/*-------------------------------------------------------------------------------------------------
	Accessed via http://localhost/index/index/
	-------------------------------------------------------------------------------------------------*/
	public function index() {
		
		# Any method that loads a view will commonly start with this
		# First, set the content of the template with a view file

		#if the user is logged in then go directly to the posts
		#otherwise instantiate the index page.
	    if($this->user){
    	 	$this->template->content = View::instance('v_posts_index');
    	 	$this->template->title = "Posts";
    	}else{
    		$this->template->content = View::instance('v_index_index');
    		$this->template->title = "Home";
    	}

		#$this->template->content = View::instance('v_index_index');
	
		# Now set the <title> tag
	
		# CSS/JS includes
			/*
			$client_files_head = Array("");
	    	$this->template->client_files_head = Utils::load_client_files($client_files);
	    	
	    	$client_files_body = Array("");
	    	$this->template->client_files_body = Utils::load_client_files($client_files_body);   
	    	*/
	      					     		
		# Render the view
			echo $this->template;

	} # End of method
	
	
} # End of class
