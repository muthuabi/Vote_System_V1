<?php
    ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cast Vote</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css-js/styles.css">
    <script src="../assets/bootstrap/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/css-js/script.js"></script>
    <script src="../assets/css-js/head_script.js"></script>

</head>

<body class="need-color">
    <!-- id="my_toast_offline" -->
<!--     <div class="toast bg-light" role="alert" id="my_toast_offline_user">
        <div class="toast-header">
            <i class="fa fa-bell me-2"></i>
            <strong class="me-auto" style="color:rgb(66, 64, 64)">SXC</strong>
            <small> </small>
            <button class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            <b style="color:rgb(99, 96, 96)" id="message"></b>
        </div>
    </div> -->
    <header class="persistent-navbar d-flex flex-column align-items-center">
        <nav class="sxc-header">
            <img src="../assets/images/other_images/logo2.png" class="sxc-header-icon" alt="">
            <h5>St. Xavier's College (Autonomous), Palayamkottai - 627002</h5>
        </nav>
        <nav class="sxc-council-header" style="position: relative;">
            <b style='position: absolute;top:0;left:5px'><?php if(isset($_COOKIE['vb_active'])) echo $_COOKIE['vb_active']; ?></b>
            <h5>Students Council Election 2024-25</h5>
        </nav>
    </header>

    <header>
        <?php
   
        session_start();
        if (isset($_POST['rechoose']) || !isset($_COOKIE['vb_active']) ) {
            session_destroy();
            header('location:index.php');
        }
        try {

            if(isset($_GET['loc_vs']) && !empty($_GET['loc_vs']))
            {
                $vfname='vs_'.$_COOKIE['vb_active'].$_SERVER['REMOTE_ADDR'].date("_d_m_y_").substr(time(),-3).'.JSON';
                $vs_val=$_GET['loc_vs'];
                $vs_val=base64_decode($vs_val);
                $vs_val=json_decode($vs_val);
                $loc="../admin/loc_vs/";
                $loc_file="../admin/loc_vs/$vfname";
                if(!file_exists($loc))
                    mkdir($loc,0775);
                file_put_contents($loc_file,json_encode($vs_val,JSON_PRETTY_PRINT));
                die("<center><b>Poll Ended</b></center>");
            }

            $valid_gender = ['M', 'F'];
            $valid_shift = ['Shift-I', 'Shift-II'];
            if (!isset($_SESSION['user_select'])) {
                $_SESSION['user_select'] = 'Session_Over';
            }
            if (isset($_GET['shift']) && !empty(trim($_GET['shift'])) && in_array(trim(base64_decode($_GET['shift'])), $valid_shift)) {
                $shift = base64_decode($_GET['shift']);
            } else {
                throw new Exception('Invalid Shift Paramater');
            }
            if (isset($_GET['vote_gender']) && !empty(trim($_GET['vote_gender'])) && in_array(trim(base64_decode($_GET['vote_gender'])), $valid_gender)) {
                $vote_gender = base64_decode($_GET['vote_gender']);
            } else {
                throw new Exception('Invalid Gender Paramater');
            }
            include_once("../util_classes/Position.php");
            include_once("../util_classes/Candidates.php");
            include_once("../util_classes/Vote.php");
            include_once("../util_classes/Polls.php");
          
            try {
				echo "<form method='post' style='width:fit-content;position:fixed;top:0;'><button type='submit' class='btn btn-secondary opacity-hover'  name='rechoose'>rechoose</button></form>";

                if($data=$poll->get_status($academic_year))
                {
                    
                    if($data['poll_status']=='ended')
                    {
                        echo "
                        <script>
                        var vd=localStorage.getItem('vote_data');
                        window.location.href='cast_vote.php?loc_vs='+btoa(vd);
                        </script>";

                        die("<center><b>Poll Ended</b></center>");
                    }
                }
                else
                    die("<center><b>Poll Not Started Yet! Refresh After Announcement from Officials</b></center>");



                if ($data = $pos->readShiftGenderAll($shift, $vote_gender)) {
                    $post_array = $data['data'];
					if(count($post_array)<=0)
						die("<center><b>No Contestants Found</b><br><b>Rechoose After Announcement from Admin Don't Refresh</b></center>");
                } else
                    throw new Exception('No Positions Found');
            } catch (Exception $e) {
                die($e->getMessage());
            }
            
        ?>
    </header>

    <main class="main-card-container ">


    <?php
            if (isset($_POST['add_vote'])) {
                try {
                    if($_POST['post_status']=='opposed')
                    {
                    if (!$vote->addVote($_POST['candidate_id']))
                        throw new Exception('Some Error has Occured');
                    }
                    $_SESSION[$_POST['post_name']] = ['candidate_id' => $_POST['candidate_id'], 'candidate_name' => $_POST['candidate_name'], 'candidate_regno' => $_POST['regno']];
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }
            for ($i = 0; $i < count($post_array); $i++) {
                $post_id_name[] = ['post_id' => $post_array[$i]['post_id'], 'post' => $post_array[$i]['post'], 'post_shift' => $post_array[$i]['post_shift'],'post_status'=>$post_array[$i]['post_status'] ];
            }


            if (!isset($_SESSION['init'])) { //Problem Here!
                for ($i = 0; $i < count($post_array); $i++) {
                    $_SESSION[$post_array[$i]['post']] = 'Not_Voted';
                }
                $_SESSION['init'] = 'init';
            }
            
            $voted = false;
            for ($i = 0; $i < count($post_id_name); $i++) {
                $voted = true;

                if (isset($_SESSION[$post_id_name[$i]['post']]) && $_SESSION[$post_id_name[$i]['post']] == 'Not_Voted') {
                    $voted = false;
                    echo " <div class='card-container-head'><h2 class=''>{$post_id_name[$i]['post']}  ";
                    echo ($post_id_name[$i]['post_shift'] == 'Both') ? '' : '(' . $post_id_name[$i]['post_shift'] . ')';
                    echo "</h2></div>";
                    $post_id = $post_id_name[$i]['post_id'];
                    if ($res = $can->readAllbyPost($post_id)) {

                        $candidates = $res['data'];
                        $count = count($candidates);
                        if($count<=0)
                            echo "<center><b>Contact Admin!</b><br><b>This Post should be nocontest if no candidates.</b></center>";
                        echo "<div class='candidates-container' style='grid-template-columns:repeat({$count},1fr);' >";
                        for ($j = 0; $j < count($candidates); $j++) {
                            echo "<form class='card candidate-card' action='' method='post' id='can{$candidates[$j]['candidate_id']}' >
                                <div class='card-img-container'>
                                <img src='{$candidates[$j]['image_url']}' class='card-img-top' alt=''>
                                </div>
                                <div class='card-body '>
                                <h5 class='text-uppercase' id='candidate_name'>{$candidates[$j]['name']}</h5>
                                <b class='card-text' id='candidate_regno'>{$candidates[$j]['regno']}</b>
                                </div>
                                <input type='hidden' name='candidate_name' value='{$candidates[$j]['name']}' />
                                <input type='hidden' name='regno' value='{$candidates[$j]['regno']}' />
                                <input type='hidden' name='candidate_id' value='{$candidates[$j]['candidate_id']}'/>
                                <input type='hidden' name='post_name' value='{$post_id_name[$i]['post']}'/>
                                <input type='hidden' name='post_status' value='{$post_id_name[$i]['post_status']}'/>
                                <center>
                                <button class='btn btn-success vote_btn'  type='submit' name='add_vote'>"; 
                                echo ($post_id_name[$i]['post_status']=='opposed')?'Vote':'Next';
                                echo "</button>
                               </center>
                               
                               
                            </form>";
                        }
                        echo "<div>";
                    } else {
                        echo "No Candidates Available";
                    }
                    break;
                }
            }
            echo "";

            if ($voted) {

                echo "<div class='modal fade result-modal' style='display:block;z-index:10000;opacity:100%'  data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='responsemodalLabel' aria-hidden='true'>
                            <div class='modal-dialog modal-dialog-centered '>
                            <div class='modal-content'>
                                <div class='modal-header mt-2'>
                                <h3 >SXC Vote System</h3>
                                <h3 class='modal-title'>Thank You for Voting!</h3>
                               
                                </div>
                                <div class='modal-body d-flex flex-column align-items-center'>
                                    <span id='icon' class='my-2'><img src='../assets/images/other_images/vote-success-ballot.gif' width='250px' height='150px' /></span>
                                    <table style='width:fit-content'>
                                        ";

                foreach ($_SESSION as $key => $value) {
                    if ($key == "user_select" || $key == "init" || $key == "admin" || $key == "admin_name" || $key == "admin_role" || $key == "admin_email")
                        continue;
                    echo "<tr><th style='text-align:left'>{$key}</th><td style='width:20px'></td><td>{$value['candidate_name']} ({$value['candidate_regno']})</td></tr>";
                }
                echo "</table>
                                    
                                </div>
                                <div class='modal-footer d-flex justify-content-center'>
                               
                                </div>
                            </div>
                            </div>
                        </div><br>";
                session_destroy();
                header("Refresh:5");
            }
        } catch (Exception $e) {
            die("<center><b>{$e->getMessage()}</b><br>
            <form method='post'><button type='submit' class='btn btn-secondary opacity-hover' name='rechoose'>rechoose</button></form>
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
<script>
    let ldata=<?php echo json_encode($_SESSION);?>;
    if(!localStorage.getItem("vote_data"))
        localStorage.setItem("vote_data",JSON.stringify({}));
    Object.keys(ldata).forEach(el=>{
        if(!(el=="user_select" || el=="init" || el=="admin" || el=="admin_name" || el=="admin_role" || el=="admin_email"))
        {
           if(ldata[el]!="Not_Voted")
           {
                sdata=JSON.parse(localStorage.getItem("vote_data"));
                if(!sdata[el])
                    sdata[el]={};
                if(!sdata[el][ldata[el].candidate_regno])
                    sdata[el][ldata[el].candidate_regno]=1;
                else
                    sdata[el][ldata[el].candidate_regno]+=1;
                localStorage.setItem("vote_data",JSON.stringify(sdata));

           }
        }

    })
</script>
</html>
