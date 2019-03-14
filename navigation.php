<nav class="navbar navbar-dark sticky-top navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand text-center" href="index.php">Barangay Salitran II</a>
        <!-- Brand and toggle get grouped for better mobile display -->
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#mainNavigation" aria-expanded="false" aria-controls="mainNavigation" aria-label="Toggle Navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Contain links, forms  and other data for toggling -->
        <div class="collapse navbar-collapse" id="mainNavigation">
            <ul class="navbar-nav mr-md-auto">
                <li class="nav-item active"><a class="nav-link" href="index.php"><span class="fas fa-home"></span> Home<span class="sr-only">(current)</span> </a> </li>
                <li class="nav-item"><a class="nav-link" id="viewNews" href="index.php#news"><span class="fas fa-newspaper"></span> News</a> </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false"><span class="fas fa-download"></span> Forms</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="docs/barangay clearance.pdf">Barangay Clearance</a>
                        <a class="dropdown-item" href="docs/barangay certification.pdf">Barangay Certificate</a>
                        <a class="dropdown-item" href="docs/barangay endorsement.pdf">Barangay Endorsement</a>
                        <a class="dropdown-item" href="docs/barangay business.pdf">Business Clearance </a>
                        <a class="dropdown-item" href="docs/barangay indigency.pdf">Indigency Certificate</a>
                        <!--pre wala daw barangay id at cedula sa salitran-->
                        <!-- <div class="dropdown-divider"></div> -->
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="viewContactUs" href="#contactUs"><span class="fas fa-comments"></span> Contact us</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <?php if(isset($_SESSION['Username'])){ ?>
                    <li class="navbar-nav dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;"><span class="fas fa-user-alt"></span> <?php echo $_SESSION['Username'];?></a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a href="profile.php#titleProfile" class="dropdown-item">Profile</a>
                            <a href='update.resident.php' class="dropdown-item">Account Settings</a>
                            <a href='security.settings.php' class="dropdown-item">Security Settings</a>
                            <div class="dropdown-divider"></div>
                            <a href='includes/logout.inc.php' class="dropdown-item">Sign Out</a>
                        </div>
                    </li>
                <?php } else { ?>
                        <a role='button' class='btn btn-primary btn-sm' style="margin-right: 10px;" href="login.php#signIn" id="btnForSignIn"><span class="fas fa-user"></span> Login</a>
                        <a role='button' class='btn btn-outline-secondary btn-sm' href="register.php#register"><span class="fas fa-user-plus"></span> Register</a>
                <?php } ?>
            </form>
        </div>
    </div>
</nav>