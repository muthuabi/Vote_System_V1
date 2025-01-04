<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Dashboard</title>
    <!-- <link rel='stylesheet' href='../assets/bootstrap/css/bootstrap.min.css'>
    <script src='../assets/bootstrap/js/jquery.min.js'></script>
    <script src='../assets/bootstrap/js/bootstrap.bundle.min.js'></script>
    <link rel='stylesheet' href='../assets/css-js/styles.css'>
    <script src='../assets/css-js/script.js'></script>
    <script src='../assets/css-js/head_script.js'></script> -->
</head>

<body>
   <header>
        <?php include_once('includes/navbar.php'); ?>
   </header>
    <main class='content-wrapper'>
        <div class='dashboard-post-cards' id="dashboard_post_cards">
           
        </div>
    </main>
</body>
<script>
    document.addEventListener("DOMContentLoaded", (main) => {
        const ballot_post = document.getElementById("dashboard_post_cards");
        function fetch_ballot() {
            $.ajax({
                url: '../util_classes/Ballot.php?ballot=BALLOT_POSITION_GROUP',
                method: 'GET',
                dataType: 'json'
            })
                .done(function (data) {
                    //console.log(data);
                    data.data.forEach(values => {
                        if (document.querySelector(`#post${values.post_id}`)) {
                            document.querySelector(`#post${values.post_id} #total_votes`).innerHTML=values.total_votes||0;
                        }
                        else {
                            ballot_post.innerHTML += `
           <div class='dashboard-post-card' id='post${values.post_id}' >
                <div class='dashboard-post-card-icon'>
                    <img src='../assets/images/other_images/logo2.png' width='100px' height='100px' alt='icon' />
                </div>
                <div class='dashboard-post-card-content'>
                    <div class='dash-head-post'>
                        <h4 id='post_name'>${values.post} ${(values.post_shift=='Both')?'':'('+values.post_shift+')'}</h4>
                    </div>
                    <div class='dash-body-post'>
                        <div class='dash-data-content'>
                            <div class='dash-data'>
                                <b>Total Candidates </b>
                                <small id='total_candidates'>${values.candidate_count}</small>
                            </div>
                            <div class='dash-data'>
                                <b>Total Votes </b>
                                  <small id='total_votes'>${values.total_votes==null?0:values.total_votes}</small>
                            </div>
                        </div>
                        <div>
                            <a href='individual-post.php?post_id=${values.post_id}' class='btn btn-primary rounded-circle'>&rarr;</a>
                        </div>
                    </div>
                </div>
                 
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

</html>