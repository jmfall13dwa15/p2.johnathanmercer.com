<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
    } 

    public function index() {
    	ChromePhp::log('users/index');
    }

    public function signup() {
       
       # Set up the view
       $this->template->content = View::instance('v_users_signup');
       $this->template->title = "SignUp";
       
       # Render the view
       echo $this->template;

       # Set up the view
       #$this->template->content = View::instance('v_users_signup');
       
       
       # Render the view
       #echo $this->template;

       # Set up view
	   #$this->template->content = View::instance('v_users_signup');
       /**
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
		**/
    }
    
    public function p_signup() {
	    	    
	    # Mark the time
	    $_POST['created']  = Time::now();
	    
	    # Hash password
	    $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
	    
	    # Create a hashed token
	    $_POST['token']    = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());
	    
	    # Insert the new user    
	    DB::instance(DB_NAME)->insert_row('users', $_POST);
	    
	    # Send them to the login page
	    Router::redirect('/users/login');
	    
    }

    public function login() {
    
    	$this->template->content = View::instance('v_users_login');
    	$this->template->title = "Login";    	
    	echo $this->template;   
       
    }
    
    public function p_login() {
	   	   
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
		
		$q = 
			'SELECT token 
			FROM users
			WHERE email = "'.$_POST['email'].'"
			AND password = "'.$_POST['password'].'"';
			

		//echo $q;
		$token = DB::instance(DB_NAME)->select_field($q);
		
		# Success
		if($token) {
			//this is the key to logging in!
			setcookie('token',$token, strtotime('+1 year'), '/');
			//echo "You are logged in!";
			ChromePhp::log('Login Successful, redirecting to profile');
			ChromePhp::log($user->first_name);
			//$user_name = $_POST['email'];
			//Router::redirect('/users/profile/'.$_POST['email']);
			Router::redirect('/posts');
		}
		# Fail
		else {
			//echo "Login failed!";
			echo "Login failed! <a href='/users/login'>Try again?</a>";
			ChromePhp::log('Login failed!');
		}
	   
    }

    public function logout() {
        
       ChromePhp::log('In the logout controller');

	   ChromePhp::log($user->first_name);
       # Generate a new token they'll use next time they login
       # this is extra security 
       $new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());
       
       # Update their row in the DB with the new token
       $data = Array(
       	'token' => $new_token
       );

       DB::instance(DB_NAME)->update('users',$data, 'WHERE user_id ='. $this->user->user_id);
       
       # Delete their old token cookie by expiring it ( this is a trick to delete it)
       setcookie('token', '', strtotime('-1 year'), '/');
       
       # Send them back to the homepage
       Router::redirect('/');

    }

    public function profile($user_name = NULL) {
		
		# Only logged in users are allowed...
		if(!$this->user) {
			# print to the page and stop doing anything else
			die('You have requested a members only page. Please <a href="/users/login">Login</a>');
		}
		
		# Set up the View
		$this->template->content = View::instance('v_users_profile');
		$this->template->title   = "Profile";
				
		# Pass the data to the View
		$this->template->content->user_name = $user_name;
		
		# Display the view
		echo $this->template;
		
    }

} # end of the class










