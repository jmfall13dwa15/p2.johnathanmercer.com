<?php

class posts_controller extends base_controller {
	
	/*-------------------------------------------------------------------------------------------------
	
	-------------------------------------------------------------------------------------------------*/
	public function __construct() {
		
		# Make sure the base controller construct gets called
		parent::__construct();
		
		# Only let logged in users access the methods in this controller
		if(!$this->user){

			#direct them to the login page and have a custom error
			Router::redirect('/users/oops');

			#die("Members only");
		}
		
	} 
	 
	/*-------------------------------------------------------------------------------------------------
	Display a new post form
	-------------------------------------------------------------------------------------------------*/
	public function add() {
		
		#first get all the user's posts
		$my_posts_query = 'SELECT *
							FROM posts 
							WHERE user_id = '.$this->user->user_id;
		
		# Run query	
		$posts = DB::instance(DB_NAME)->select_rows($my_posts_query);

		$this->template->content = View::instance("v_posts_add");
		
		$this->template->content->my_posts = $posts;
		echo $this->template;
		
	}	

	public function delete($uid, $pid) {
		
		//ChromePhp::log($uid);
		//ChromePhp::log($pid);

		if($uid != $this->user->user_id){
			//$this->template->content = View::instance("v_users_oops_general");
			//$error_message = "Not Allowed To Delete Others Posts.";
			//$this->template->content->error_message = $error_message;
			//echo $this->template;
			Router::redirect('/users/general_oops');
		}else{

			$where_condition = 'WHERE user_id='.$this->user->user_id.' AND post_id='.$pid;
			
			ChromePhp::log($where_condition);
			DB::instance(DB_NAME)->delete('posts',$where_condition);
			
			Router::redirect('/posts/add');
		}
	}	
	
	/*-------------------------------------------------------------------------------------------------
	Process new posts
	-------------------------------------------------------------------------------------------------*/
	public function p_add() {
		
		$_POST['user_id']  = $this->user->user_id;
		$_POST['created']  = Time::now();
		$_POST['modified'] = Time::now();
		
		#we don't need to sanitize bc insert already sanitizes
		DB::instance(DB_NAME)->insert('posts',$_POST);
		
		Router::redirect('/posts/add');
		
	}
	
	
	/*-------------------------------------------------------------------------------------------------
	View all posts
	-------------------------------------------------------------------------------------------------*/
	public function index() {
		
		# Set up view
		$this->template->content = View::instance('v_posts_index');
		
		# Set up query
		$q = 'SELECT 
			    posts.content,
			    posts.created,
			    posts.user_id AS post_user_id,
			    users_users.user_id AS follower_id,
			    users.first_name,
			    users.last_name
			FROM posts
			INNER JOIN users_users 
			    ON posts.user_id = users_users.user_id_followed
			INNER JOIN users 
			    ON posts.user_id = users.user_id
			WHERE users_users.user_id = '.$this->user->user_id;
		
		# Run query	
		$posts = DB::instance(DB_NAME)->select_rows($q);
		
		#query for the array of people the user is following
		#so I can count how many people they are following
		$f_cnt = 'SELECT *  
				   FROM users_users 
				   WHERE user_id = '.$this->user->user_id;

		# Run query	
		$posts = DB::instance(DB_NAME)->select_rows($q);

		# run the query for the followees
		$following_cnt = DB::instance(DB_NAME)->select_rows($f_cnt , $type = 'array'); #query($f_cnt);

		# Pass $posts array to the view
		$this->template->content->posts = $posts;
		# Pass the number of posts to the view
		$this->template->content->num_of_posts = count($posts);
		# Pass the number of followees to the view
		$this->template->content->following_cnt = count($following_cnt);

		# Render view
		echo $this->template;
		
	}
	
	
	/*-------------------------------------------------------------------------------------------------
	
	-------------------------------------------------------------------------------------------------*/
	public function users() {
		
		# Set up view
		$this->template->content = View::instance("v_posts_users");
		
		# Set up query to get all users
		$q = 'SELECT *
			FROM users';
			
		# Run query
		$users = DB::instance(DB_NAME)->select_rows($q);
		
		# Set up query to get all connections from users_users table
		$q = 'SELECT *
			FROM users_users
			WHERE user_id = '.$this->user->user_id;
			
		# Run query
		$connections = DB::instance(DB_NAME)->select_array($q,'user_id_followed');
		
		ChromePhp::log('hi');

		# Pass data to the view
		$this->template->content->users       = $users;
		$this->template->content->connections = $connections;
		
		# Render view
		echo $this->template;
		
	}
	
	
	/*-------------------------------------------------------------------------------------------------
	Creates a row in the users_users table representing that one user is following another
	-------------------------------------------------------------------------------------------------*/
	public function follow($user_id_followed) {
	
	    # Prepare the data array to be inserted
	    $data = Array(
	        "created"          => Time::now(),
	        "user_id"          => $this->user->user_id,
	        "user_id_followed" => $user_id_followed
	        );
	
	    # Do the insert
	    DB::instance(DB_NAME)->insert('users_users', $data);
	
	    # Send them back
	    Router::redirect("/posts/users");
	
	}
	
	
	/*-------------------------------------------------------------------------------------------------
	Removes the specified row in the users_users table, removing the follow between two users
	-------------------------------------------------------------------------------------------------*/
	public function unfollow($user_id_followed) {
	
	    # Set up the where condition
	    $where_condition = 'WHERE user_id = '.$this->user->user_id.' AND user_id_followed = '.$user_id_followed;
	    
	    # Run the delete
	    DB::instance(DB_NAME)->delete('users_users', $where_condition);
	
	    # Send them back
	    Router::redirect("/posts/users");
	
	}
	
	
	
} # eoc
