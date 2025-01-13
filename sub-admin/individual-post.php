<?php
ob_start();
?>
<!DOCTYPE html>
<htnl lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Individual Post</title>
<!--     <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <script src='../assets/bootstrap/js/jquery.min.js'></script>
    <script src='../assets/bootstrap/js/bootstrap.bundle.min.js'></script>
    <link rel="stylesheet" href="../assets/css-js/styles.css">
    <script src='../assets/css-js/script.js'></script>
    <script src="../assets/css-js/head_script.js"></script> -->
</head>
<?php if(isset($_GET['post_id']) && !empty(trim($_GET['post_id'])))
        {
           $post_id=$_GET['post_id']; 
      
?>
<body>
    <header>
            <?php include_once('includes/navbar.php'); ?>
    </header>
    <main class="content-wrapper">
        <div class='candidates-container individual-card-container' id="ballot_post_id">

        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", (main) => {
            const url='../util_classes/Ballot.php?ballot=BALLOT_POST_ID&post_id=<?php echo $post_id; ?>';
            const ballot_post = document.getElementById("ballot_post_id");
            function fetch_ballot() {
                $.ajax({
                    url:url,
                    method: 'GET',
                    dataType: 'json'
                })
                    .done(function (data) {
                        let max_candidate_id=data.max_candidate_id;
                        data.data.forEach(values => {
                            
                            values.vote = (values.vote ? values.vote : 0);
                            if (document.querySelector(`#can${values.candidate_id}`)) {
                                // document.querySelector(`#can${values.candidate_id} #candidate_id`).innerHTML=values.candidate_id;
                                // document.querySelector(`#can${values.candidate_id} #candidate_name`).innerHTML=values.name;
                                // document.querySelector(`#can${values.candidate_id} #post_name`).innerHTML=values.post;
    
                                document.querySelector(`#can${values.candidate_id} #vote #vote_number `).innerHTML =values.vote;
                                document.querySelector(`#can${values.candidate_id} #vote #vote_status `).innerHTML =`${(max_candidate_id==values.candidate_id)?'&uarr;':'&darr;'}`;
                            }
                            else {
                                 ballot_post.innerHTML += `
                  <div class='card candidate-card individual-card' id='can${values.candidate_id}' >
                    <h5 class='card-header' id='post_name'>${values.post} ${(values.post_shift=='Both')?'':'- '+values.post_shift}</h5>
                    <div class='card-img-container'>
                    <img src='${values.image_url}' class='card-img-top' alt=''>
                    </div>
                    <div class='card-body '>
                      <h5 class='card-title d-flex align-items-center gap-1' id='candidate_name'><small>#${values.candidate_id}</small> ${values.name}</h5>
                      <b class='card-text' id='candidate_regno'>${values.regno}</b>
                    </div>
                    <ul class='list-group list-group-flush'>
                      <li class='list-group-item' id='candidate_course'>${values.course}</li>
                      <li class='list-group-item  text-center' id='vote' style='overflow:hidden'><span id='vote_number'>${values.vote}</span><span id='vote_status'${(max_candidate_id==values.candidate_id)?' class=up_vote > &uarr;':' class=down_vote> &darr;'}</span> </li>
                    </ul>
                </div>
                
                `;
                            }
                        })
                    })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                        console.error("Request failed:", textStatus, errorThrown);
                    })
            }
            fetch_ballot();
            setInterval(() => { fetch_ballot() }, 5000);
        });
    </script>
</body>
<?php 

        }
        else
        {
            echo "<center><b>Invalid Request</b></center>";
        }

?>

</html>