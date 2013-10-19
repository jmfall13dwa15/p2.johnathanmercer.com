<div class="navbar navbar-inverse navbar-fixed-top" style="z-index: 10;">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="#">MercMicro Blog</a>

            <?php if(isset($user_name)): ?>
            <div class="nav-collapse collapse logged-in-menu">

                <ul class="nav">
                    <li class="add-menu"><a href="#users">Users</a></li> 
                </ul>

                <ul class="nav pull-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <?=$user_name?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#users/profile">Profile</a></li>
                            <li><a href="#users/logout">Log out</a></li>                            
                        </ul>
                    </li>
                </ul>
            </div>
            <?php else: ?>
            <div class="nav-collapse collapse logged-out-menu">

                <ul class="nav pull-right">                    
                    <li class="login-menu"><a href="#users/login">Log in</a></li>
                    <li class="register-menu"><a href="#users/signup">SignUp</a></li> 

                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
