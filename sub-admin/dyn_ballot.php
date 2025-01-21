<?php
    ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Council Election Ballot</title>
    <!-- <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <script src='../assets/bootstrap/js/jquery.min.js'></script>
    <script src='../assets/bootstrap/js/bootstrap.bundle.min.js'></script>
    <link rel="stylesheet" href="../assets/css-js/styles.css">
    <script src='../assets/css-js/script.js'></script>
    <script src="../assets/css-js/head_script.js"></script> -->
</head>

<body>
    <header>
        <?php include_once('includes/navbar.php') ?>
    </header>
    <style>

    </style>
    <main class="content-wrapper">
        <div class="sxc-header-print pr-only">
            <div>
                <img src="../assets/images/other_images/print-logo.png" class="sxc-header-icon-print">
            </div>
            <div class="sxc-header-body">
                <h3>St. Xavier's College (Autonomous)</h3>
                <small>
                    (Recognized as “College with Potential for Excellence” by UGC
                    <br>
                    Accredited by NAAC at A++ Grade with a CGPA of 3.66 out of 4 in IV Cycle)<br>
                    <b>Palayamkottai - 627 002</b>
                </small>
            </div>
        </div>
        <div class="hr pr-only"></div>
        <button class="btn btn-dark pr-not mt-2" type='button' id="print_btn" onclick="window.print()">Print &#x1F5B6;</button>

        <div id="ballot_head">

            <b>Student Council Election (2024-25)</b>
            <div class="pr-not">
                <strong id="live-blink"></strong><img src="../assets/icons/live-icon.svg" width="20px" height="20px" /><strong id="live">LIVE</strong>

            </div>
        </div>

        <table class="table" id="dyn_ballot">

            <thead >
                <tr>
                    <th>Total Votes Polled - <b id="total_votes_polled"></b></th>
                </tr>
            </thead>
            <tbody id="ballot_all">

            </tbody>

        </table>
    </main>
</body>
<script>
    let flag = 'initial';
    document.addEventListener("DOMContentLoaded", (main) => {
        const table_ballot_all = document.getElementById("ballot_all");

        function fetch_ballot() {
            $.ajax({
                    url: '../util_classes/Ballot.php?ballot=BALLOT_ALL',
                    method: 'GET',
                    dataType: 'json'
                })
                .done(function(data) {
                    if (flag == 'failed') {
                        const on_event = new Event('online');
                        window.dispatchEvent(on_event);
                        flag = 'initial';
                    }

                    let poll_status = data.poll_status;
                    document.querySelectorAll('.unopposed,.nocontest').forEach(element => {
                        element.style.display = 'none';
                    })
                    if (poll_status == "ended" || poll_status=="not_started") {
                        document.querySelector("#live").innerHTML=("Polling "+poll_status).toUpperCase();
                        document.querySelectorAll('.unopposed,.nocontest').forEach(element => {
                            element.style.display = 'table-row';
                        })
                        document.querySelectorAll("#vote_status").forEach(element => {
                            if (element.getAnimations()[0])
                                element.getAnimations()[0].pause();
                        })
                        if (document.querySelector("#live-blink").getAnimations()[0])
                            document.querySelector("#live-blink").getAnimations()[0].pause();
                       

                    } else {
                        document.querySelector("#live").innerHTML="LIVE";
                        document.querySelectorAll("#vote_status").forEach(element => {
                            if (element.getAnimations()[0])
                                element.getAnimations()[0].play();
                        })
                        if (document.querySelector("#live-blink").getAnimations()[0])
                            document.querySelector("#live-blink").getAnimations()[0].play();

                    }


                    let total_votes = 0;
                    data.data.forEach(values => {

                        total_votes += values.vote;
                        values.vote = (values.vote ? values.vote : 0);
                        document.querySelector('#total_votes_polled').innerHTML = total_votes;
                        if (document.querySelector(`#can${values.candidate_id}`)) {
                            // document.querySelector(`#can${values.candidate_id} #candidate_id`).innerHTML=values.candidate_id;
                            // document.querySelector(`#can${values.candidate_id} #candidate_name`).innerHTML=values.name;
                            // document.querySelector(`#can${values.candidate_id} #post_name`).innerHTML=values.post;
                            document.querySelector(`#can${values.candidate_id} #vote`).innerHTML = values.post_status == 'unopposed' ? 'unopposed' : values.vote;
                            if (data.max_post_data[values.post_id] && (data.max_post_data[values.post_id].max_candidate_id == values.candidate_id) || values.post_status == 'unopposed') {
                                document.querySelector(`#can${values.candidate_id} #vote_status`).innerHTML = (poll_status == 'ended') ? 'Win' : '<img src="../assets/icons/up-arrow.svg" class="svg-icon" />';
                                document.querySelector(`#can${values.candidate_id} #vote_status`).classList.add('up_vote');
                                document.querySelector(`#can${values.candidate_id} #vote_status`).classList.remove('down_vote');
                            } else {
                                document.querySelector(`#can${values.candidate_id} #vote_status`).innerHTML = (poll_status == 'ended') ? '' : '<img src="../assets/icons/down-arrow.svg" class="svg-icon" />';
                                document.querySelector(`#can${values.candidate_id} #vote_status`).classList.add('down_vote');
                                document.querySelector(`#can${values.candidate_id} #vote_status`).classList.remove('up_vote');
                            }

                        } else {
                            let pos_arr = [];
                            if (!pos_arr.includes(values.post_id)) {
                                if (!document.querySelector(`#post${values.post_id}`))
                                    table_ballot_all.innerHTML += `<br><tr class='common_post ${values.post_status}' id='post${values.post_id}'><th id='common_post' style='text-align:left;text-transform:uppercase' colspan='3'>${values.post} ${(values.post_shift=='Both')?'':'('+values.post_shift+')'}</th><th id='common_post_vote'></th></tr>
                                <tr class='${values.post_status}'><th>PHOTO</th><th>NAME</th><th>REGNO</th><th>VOTES</th></tr>
                                `;
                                pos_arr.push(values.post_id);
                            }

                            table_ballot_all.innerHTML += `
            <tr class='${values.post_status}' id=${'can' + values.candidate_id}><td id='candidate_image'><img src='${values.image_url}' class='can_small_img'/></td><td id='candidate_name' style='text-transform:uppercase'>${values.name}</td><td id='regno'>${values.regno}</td><td id='vote_data'><span id='vote'>${values.vote}</span>  <span id='vote_status'${(data.max_post_data[values.post_id] && (data.max_post_data[values.post_id].max_candidate_id==values.candidate_id))?' class=up_vote ><img src="../assets/icons/up-arrow.svg" class="svg-icon" />':' class=down_vote><img src="../assets/icons/down-arrow.svg" class="svg-icon" />'}</span></td></tr>
         
            `;
                        }
                    })
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    flag = 'failed';
                    const offline = new Event('offline');
                    window.dispatchEvent(offline);
                    // console.error("Request failed:", textStatus, errorThrown);
                })
        }

        fetch_ballot();
        setTimeout(()=>{
            fetch_ballot();
        }
        ,700);
        setInterval(()=>{
            fetch_ballot();
        },3000);
        // setInterval(()=>{
        //     location.reload();
        // },60000);
    });
</script>

</html>
