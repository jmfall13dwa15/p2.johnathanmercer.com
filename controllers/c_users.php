<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
    } 

    public function index() {
    	ChromePhp::log('users/index');
    }

    public function oops() {
	
		ChromePhp::log('users/index');
		
		$this->template->content = View::instance("v_users_oops");
		
		echo $this->template;
		
	}	

    public function signup() {
       
       # Set up the view
       $this->template->content = View::instance('v_users_signup');
       $this->template->title = "SignUp";

       # Render the view
       echo $this->template;

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
			
		//get token
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










