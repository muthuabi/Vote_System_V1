    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <script src='../assets/bootstrap/js/jquery.min.js'></script>
    <script src='../assets/bootstrap/js/bootstrap.bundle.min.js'></script>
    <link rel="stylesheet" href="../assets/css-js/styles.css">
    <script src='../assets/css-js/script.js'></script>
    <script src="../assets/css-js/head_script.js"></script>
<?php 
    //error_reporting(E_ALL && ~E_WARNING);
    session_start();
    if(isset($_SESSION['admin']) && !empty($_SESSION['admin']) && (isset($_SESSION['admin_role']) && $_SESSION['admin_role']=='sub-admin'))
    {
        $admin=$_SESSION['admin'];
    }
    else
    {
        header('HTTP/1.1 403 Access Forbidden');
        http_response_code(403);
        echo "<center><b>Access Forbidden<br>
            <a href='../admin/login.php'class='btn btn-link opacity-hover'>Login to Access</a>
        </b></center>";
        exit();
    }
    if(isset($_POST['admin_logout']))
    {
        session_destroy();
        header("Location:../admin/login.php");
    }

?>
<?php 
include_once("../util_classes/Admin.php");
if(isset( $_POST["admin_change_pass"]))
    echo "<style>#change_pass_container{display:flex}</style>";
else
    echo "<style>#change_pass_container{display:none}</style>";

if(isset($_POST['change_pass']))
{
    try{
    $admin->change_admin_password($_POST['new_pass'],$_SESSION['admin']);
    echo "<script>init_toast_head('Password Changed');</script>";
    }
    catch(Exception $e)
    {
        echo "<script>alert('Password Change Failed');</script>";
    }
  
}
?>
<div id="change_pass_container" class=" position-fixed justify-content-center align-items-center" style="z-index:10000;height:85vh;width:100%">
    <form action='' method='post' class="bg-light d-flex flex-column gap-2" style="padding:1.5rem 1rem;width:350px">
    <h4 class="text-center">Change Password</h4>    
    <div class="form-group">
            <label for="old_pass">New Password</label>
            <input type="password" name="new_pass" id="new_pass" required class="form-control">
        </div>
        <div class="form-group">
            <label for="new_pass">Confirm Password</label>
            <input type="password" name="confirm_new_pass" id="confirm_pass" required class="form-control">
        </div>
        <button class="btn btn-primary" type="submit" id="change_pass" name="change_pass">Change</button>
        <button class="btn btn-link" type="submit" id="change_pass" formnovalidate name="cancel_change_pass">Cancel</button>
    </form>
</div>


<script>
    const old_pass=document.getElementById('new_pass');
    const new_pass=document.getElementById('confirm_pass');
    const change=document.getElementById('change_pass');
    new_pass.addEventListener("keyup",(e)=>{
        if(e.target.value==old_pass.value)
        {
            change.disabled=false;
        }
        else
        {
            change.disabled=true;
        }
    })

</script>
<div class="toast bg-light" role="alert" id="my_toast_offline">
      <div class="toast-header">
        <i class="fa fa-bell me-2"></i>
        <strong class="me-auto" style="color:rgb(66, 64, 64)">SXC</strong>
        <small> </small>
        <button class="btn-close" data-bs-dismiss="toast"></button>
      </div>
      <div class="toast-body">
        <b style="color:rgb(99, 96, 96)" id="message"></b>
      </div>
    </div>
<nav class="navbar navbar-expand">

    <div class="container-fluid">
        <div class="brand d-flex align-items-center gap-1 ">
            <button class="navbar-toggler btn btn-secondary d-flex d-md-none  d-lg-none " type="button" data-bs-toggle="offcanvas" data-bs-target="#maincanvas" aria-controls="maincanvas">
                &#9776;
            </button>
            <img src="../assets/images/other_images/logo2.png" class="sxc-header-icon" alt="">
            <div>
            <b class="d-none d-md-block d-lg-block">St. Xavier's College (Autonomous), Palayamkottai - 627002</b>
            <b class='d-block d-md-none d-lg-none'>SXC</b>
            <!-- <small class="d-none d-md-block d-lg-block">Student Council Election (2024-25)</small>
            <small class='d-block d-md-none d-lg-none'>2024-25</small> -->
            </div>
        </div>
        <div class="profile-card">
            <img src="../assets/images/other_images/bg1.jpg" class="icon">
            <div>
                <span class="d-none d-md-block d-lg-block"><?php echo $_SESSION['admin_name']; ?></span>
                <span id='on_off' style='display:flex;align-items:center;gap:0.5rem;'><small style='background-color:green;border-radius:50%;width:10px;height:10px;'></small><small class="d-none d-md-block d-lg-block">Online</small></span>
            </div>
            <form method="post" id="change_pass_temp_form">
                <button class="btn btn-dark" type='submit' name='admin_logout'>SignOut</button>
                
            </form>
        </div>
    </div>
</nav>
<section class="main-sidebar offcanvas offcanvas-start" tabindex="-1" id="maincanvas" aria-labelledby="maincanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="maincanvasLabel">SXC Elections</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
        </button>
    </div>
    <div class="offcanvas-body ">
       
        <div class="sidebar-card">
            <ul class="nav navbar-nav">
                <li class="nav-item"><a href="dashboard.php" class="nav-link <?php if(basename($_SERVER['REQUEST_URI'])=='dashboard.php')  echo 'nav-active'  ?>">Dashboard</a></li>
                <li class="nav-item"><a href="sxc-positions.php" class="nav-link <?php if(basename($_SERVER['REQUEST_URI'])=='sxc-positions.php')  echo 'nav-active'  ?>">Add Positions</a></li>
                <li class="nav-item"><a href="sxc-candidates.php" class="nav-link <?php if(basename($_SERVER['REQUEST_URI'])=='sxc-candidates.php')  echo 'nav-active'  ?>">Add Candidates</a></li>
                <?php if(str_contains($_SERVER['REQUEST_URI'],'individual-post.php'))  echo "<li class='nav-item'><a href='#' class='nav-link nav-active'>Individual Candidates</a></li>";?>
                <li class="nav-item"><a href="dyn_ballot.php" class="nav-link <?php if(basename($_SERVER['REQUEST_URI'])=='dyn_ballot.php')  echo 'nav-active'  ?>">Ballot Table</a></li>
                <li class="nav-item"><button   type='submit' name="admin_change_pass" style="width:100%;text-align:left" class="btn btn-link  nav-link <?php if(isset($_POST['admin_change_pass'])) echo 'nav-active'; ?> " form="change_pass_temp_form" >Change Password</button> </li>
            </ul>

        </div>
    </div>
</section>
