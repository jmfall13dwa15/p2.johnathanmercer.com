<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($title)) echo $title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
					
	<!-- JS/CSS File we want on every page -->
	<script type="text/javascript" src="/js/jquery-1.8.2.min.js"></script>				
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>             
    
	<!-- CSS I want on every page  -->
	<link href="/css/bootstrap.css" rel="stylesheet">

    <style>
        body { padding-top: 60px;}
    </style>
    <link href= "/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="/css/styles.css" rel="stylesheet">
    <link href="/css/demo_page.css" rel="stylesheet">
    <link href="/css/demo_table.css" rel="stylesheet">
    
    <script src="http://use.edgefonts.net/andika.js"></script>
    <script src="http://use.edgefonts.net/arvo.js"></script>

</head>

<body>	

	<div class="navbar navbar-inverse navbar-fixed-top" style="z-index: 10;">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <a class="brand" href= <?php if($user){ echo '/posts';}else{ echo '/' ;}?> >
                MercMicro Blog
            </a>

            <?php if($user): ?>
                <div class="nav-collapse collapse logged-in-menu">

                    <ul class="nav"> 
                        <li class="add-menu"><a href="/posts/add">Manage My Posts</a></li> 
                        <li class="add-menu"><a href="/posts">Post Feed</a></li> 
                        <li class="add-menu"><a href="/posts/users">Follow </a></li> 

                    </ul>

                    <ul class="nav pull-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown"> 
                                <?php if(isset($user->first_name)) echo $user->first_name; ?>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href='/users/profile'>Profile</a></li>
                                <li><a href='/users/logout'>Log out</a></li>                            
                            </ul>
                        </li>
                    </ul>
                </div>
            <?php else: ?>
                <div class="nav-collapse collapse logged-out-menu">

                    <ul class="nav pull-right">                    
                        <li class="login-menu"><a href="/users/login">Log in</a></li>
                        <li class="register-menu"><a href="/users/signup">Sign up</a></li> 

                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="container">
	<div class="page">
        
		<?php if(isset($content)) echo $content; ?>

		<?php if(isset($client_files_body)) echo $client_files_body; ?>
	</div>
</div>
</body>
</html>