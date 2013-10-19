<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
    } 

    public function index() {
        echo "This is the index page";
    }

    public function signup() {
       
       # Set up the view
       #$this->template->content = View::instance('v_users_signup');
       
       
       # Render the view
       #echo $this->template;

       # Set up view
		$this->template->content = View::instance('v_users_signup');

		# Innocent until proven guilty
		$error = false;
		
		# Initiate error
		$this->template->content->error = '<br>';
		
		# If we have no post data (i.e. the form was not yet submitted, just display the View with the signup form and be done
		if(!$_POST) {
			echo $this->template;
			return;
		}
		
		//sanitize the form data
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);
		
		# Loop through the POST data
		foreach($_POST as $field_name => $value) {
			//echo $value."<br>";
			# If a field was blank, add a message to the error View variable
			if($value == "") {
				$this->template->content->error .= $field_name.' is blank.<br>';
				$error = true;
			}

		}	
		
		#now check if the email was already taken 
		$email_that_was_entered = $_POST['email'];

		//define the query
		$q = 'SELECT * FROM users'; 

		# Run the query, echo what it returns
		//$all_emails_in_db = DB::instance(DB_NAME)->select_rows($q,'array');

		$all_emails_in_db = DB::instance(DB_NAME)->select_column($q,'email');
		ChromePhp::log($all_emails_in_db);
		ChromePhp::log($email_that_was_entered);

		foreach ($all_emails_in_db as $value) {
		    //echo $value['first_name'];
		}

		$email_already_exists = FALSE;
 
		foreach($all_emails_in_db as $value) {
			//$this_email = $value['email'];
			//echo $email_that_was_entered ."  ".$this_email;
			//ChromePhp::log($value);
			//echo $this_email."<br>";
			# If a field was blank, add a message to the error View variable
			if($email_that_was_entered == $value) {
				//echo "same";
				ChromePhp::log("$email_that_was_entered == $value");
				//$this->template->content->error = $this_email.' has already been taken, are you sure you are not registered?! <br>';
				$error = TRUE;
				break;
			}
			//echo "<br>";

		}	

		ChromePhp::log('i never get here');
		# Passed
		if(!$error) {
			
			#echo "No errors! At this point, you'd want to enter their info into the DB and redirect them somewhere else...";
			
			$_POST['created']  = Time::now();
	    	$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
	    	$_POST['token']    = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());
	    
			//define the new user array(the form elements have already been sanitized)
			$new_user = Array(
								'first_name' => $_POST['first_name'],
								 'last_name' => $_POST['last_name'],
								   'created' => $_POST['created'],
								  'password' => $_POST['password'],
								     'token' => $_POST['token'],
								     'email' => $email_that_was_entered,
							);
		
			DB::instance(DB_NAME)->insert('users',$new_user);
		
			//now redirect to index page of a logged in user
			Router::redirect('/users/login');
		}
		else {
			echo $this->template;
		}
    }
    
    public function p_signup() {
	    	    
	    $_POST['created']  = Time::now();
	    $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
	    $_POST['token']    = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());
	    
	    echo "<pre>";
	    print_r($_POST);
	    echo "<pre>";
	    
	    DB::instance(DB_NAME)->insert_row('users', $_POST);
	    
	    # Send them to the login page
	    //Router::redirect('/users/login');
	    
    }

    public function login() {
    
    	$this->template->content = View::instance('v_users_login');    	
    	echo $this->template;   
       
    }
    
    public function p_login() {
	   	   
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
		
		//echo "<pre>";
	    //print_r($_POST);
	    //echo "</pre>";

		$q = 
			'SELECT token 
			FROM users
			WHERE email = "'.$_POST['email'].'"
			AND password = "'.$_POST['password'].'"';
			
		//echo $q;
		$token = DB::instance(DB_NAME)->select_field($q);
		
		# Success
		if($token) {
			setcookie('token',$token, strtotime('+1 year'), '/');
			//echo "You are logged in!";
			ChromePhp::log('Login Successful, redirecting to profile');
			ChromePhp::log($user);
			//$user_name = $_POST['email'];
			Router::redirect('/users/profile/'.$_POST['email']);

		}
		# Fail
		else {
			//echo "Login failed!";
			ChromePhp::log('Login failed!');
		}
	   
    }

    public function logout() {
        echo "This is the logout page";
    }

    public function profile($user_name = NULL) {
		
		# Set up the View

		//ChromePhp::log($this->template->user_name);

		$this->template->content = View::instance('v_users_profile');
		$this->template->title = "Profile";
		
		/**
		# Load client files
		$client_files_head = Array(
			'/css/profile.css',
			);
		
		$this->template->client_files_head = Utils::load_client_files($client_files_head);
		
		$client_files_body = Array(
			'/js/profile.js'
			);
		
		$this->template->client_files_body = Utils::load_client_files($client_files_body);
		**/

		# Pass the data to the View
		$this->template->content->user_name = $user_name;
		
		# Display the view
		echo $this->template;
			
		//$view = View::instance('v_users_profile');
		//$view->user_name = $user_name;		
		//echo $view;
		
    }

} # end of the class










