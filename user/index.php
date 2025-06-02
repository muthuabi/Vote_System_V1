<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Index </title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css-js/styles.css">
    <script src="../assets/bootstrap/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/css-js/script.js"></script>
    <script src="../assets/css-js/head_script.js"></script>
</head>

<body>
<header class="persistent-navbar d-flex flex-column align-items-center">
        <nav class="sxc-header">
            <img src="../assets/images/other_images/logo2.png" class="sxc-header-icon" alt="">
            <h5>St. Xavier's College (Autonomous), Palayamkottai - 627002</h5>
        </nav>
        <nav class="sxc-council-header">
            <h5>Students Council Election 2024-25</h5>
        </nav>
    </header>
    <main class="container footer-up">
        <?php 
            session_start();
            if(!isset($_SESSION['user_select']))
            {
                if(isset($_POST['user_login']))
                {
                    $_SESSION['user_select']='Session Lost';
                    header("Location:cast_vote.php?shift=".base64_encode($_POST['shift'])."&vote_gender=".base64_encode($_POST['vote_gender']));
                } 
        ?>
        <div class="form-container">
            <form action="" method="post" id="user_login" class="login_form criteria_form">
                <h2 class="text-center">Criteria Selection</h2>
                <div class="form-group">
                    <label for="username">Shift</label>
                    <select name="shift" id="shift" class='form-control'>
                        <option value='Shift-I'>Shift - I</option>
                        <option value='Shift-II'>Shift - II</option>
                    </select>
                </div>
                <div class="form-group ">
                    <label for="password">Gender</label>
                    <select name="vote_gender" id="vote_gender" class="form-control">
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select> 
                </div>
                <button type="submit" class="btn btn-dark my-2 vote_btn w-100" id="user_login_btn" name="user_login">Select</button>
            </form>
        </div>
        <?php 
            }
            else
            {
                die("<center><b>Access Lost! Go to Cast Vote Page</b><br>
                <a  href='cast_vote.php' class='btn btn-dark opacity-hover' style='opacity:0.3'>Cast Vote Page</a>
                </center>");
            }
        ?>
    </main>
    <footer>
            <div class="footer-head">
                <b>Designed & Maintained by SXC Web Team | © 2022 St. Xavier's College. All rights reserved.</b><a class="nav-link text-white" href="../index.php"><b>Home</b></a>
            </div>
    </footer>
</body>

</html>
