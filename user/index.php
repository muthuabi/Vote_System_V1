<?php
    ob_start();
?>
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
<!--         <div class='warn-box'>
            <b>Invalid Booth Name</b>
        </div>
        <style>
            .warn-box
            {
                position:fixed;
                bottom:5rem;
                left:-15rem;
                padding:1rem 3rem;
                background-color:wheat;
                border-radius:10px;
            }
        </style> -->
    </header>
    <main class="container footer-up">
        <?php 
            session_start();
            include_once("../util_classes/VBooth.php");
            if(!isset($_SESSION['user_select']))
            {
                if(isset($_POST['user_login']))
                {
                    $name=trim($_POST['vb_name']);
                    $data=$vb->get_status(0,$name);
                    if($data)
                    {
                        $status=$data['vb_status'];
                        if($status=='restricted')
                            echo "<script>window.alert('Booth Is Restricted');</script>";
                        if(isset($_COOKIE['vb_active']) && $_COOKIE['vb_active']==$name && $status!='restricted')
                            header("Location:cast_vote.php?shift=".base64_encode($_POST['shift'])."&vote_gender=".base64_encode($_POST['vote_gender']));
                        if($status=='active')
                            echo "<script>window.alert('Booth Already Active');</script>";
                        if($status=='inactive')
                        {
                            if(setcookie('vb_active',$name,0,'/Vote_System'))
                            {
                                $vb->update_status('active',0,$name);
                                $_SESSION['user_select']='Session Lost';
                                header("Location:cast_vote.php?shift=".base64_encode($_POST['shift'])."&vote_gender=".base64_encode($_POST['vote_gender']));
                            }
                        }

                    }
                    else
                        echo "<script>window.alert('No Such Booth Exists');</script>";
                    // $_SESSION['user_select']='Session Lost';
                    // header("Location:cast_vote.php?shift=".base64_encode($_POST['shift'])."&vote_gender=".base64_encode($_POST['vote_gender']));
                } 
        ?>
        <div class="form-container">
            <form action="" method="post" id="user_login" class="login_form criteria_form">
                <h2 class="text-center">Criteria Selection</h2>
                <div class="form-group">
                    <label for="vb_name">Booth Name</label>
                    <input type="text" style='text-transform: lowercase;' name="vb_name" id="vb_name" required class='form-control' value='<?php 
                    if(isset($_COOKIE['vb_active']) && !empty(trim($_COOKIE['vb_active']))) 
                        echo $_COOKIE['vb_active']."' readonly/>"; 
                    else if(isset($_POST['vb_name']))
                        echo $_POST['vb_name']."'/>";
                    else
                        echo "'/>";
                    ?>
                </div>
            <div style='display: flex;justify-content: space-between;'>
                <div class="form-group" style="width:100%">
                    <label for="shift">Shift</label>
                    <select name="shift" id="shift" class='form-control'>
                        <option value='Shift-I'>Shift - I</option>
                        <option value='Shift-II'>Shift - II</option>
                    </select>
                </div>
                <div class="form-group" style="width:100%">
                    <label for="vote_gender">Gender</label>
                    <select name="vote_gender" id="vote_gender" class="form-control">
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select> 
                </div>
            </div>
                <button type="submit" class="btn btn-dark my-2 vote_btn w-100" id="user_login_btn" name="user_login">Select</button>
            </form>
        </div>
        <?php 
            }
            else
            {
                die("<center><b>Access Lost!</b><br>
                <a  href='cast_vote.php' class='btn btn-dark opacity-hover'>Go to Cast Vote</a>
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
