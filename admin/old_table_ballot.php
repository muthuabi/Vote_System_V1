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
                <img src="../assets/images/other_images/logo2.png" class="sxc-header-icon-print">
            </div>
            <div class="sxc-header-body">
                <h3>St. Xavier's College (Autonomous)</h3>
                    <small>
                    (Recognized as “College with Potential for Excellence” by UGC
                    <br>
                    Accredited by NACC at A++ Grade with a CGPA of 3.66 out of 4 in IV Cycle)<br>
                    <b>Palayamkottai - 627 002</b>
                </small>
            </div>
        </div>
        <div class="hr pr-only"></div>
        <button class="btn btn-dark pr-not mt-2" type='button' id="print_btn" onclick="print_doc()" >Print &#x1F5B6;</button>
        
        <div id="ballot_head">

            <b>Student Council Election (2024-25)</b>
            <div class="pr-not">
                <strong id="live-blink"></strong><strong id="live"><img src="../assets/icons/live-icon.svg" width="40px" height="40px"/></strong>
            </div>
        </div>
  
        <table class="table" id="dyn_ballot">
         
            <thead class="pr-not">
                <tr><th >Total Votes Polled - <b id="total_votes_polled"></b></th></tr>
            </thead>
            <tbody id="ballot_all">

            </tbody>

        </table>
    </main>
</body>
<script>
    document.addEventListener("DOMContentLoaded", (main) => {
        const table_ballot_all = document.getElementById("ballot_all");
        function fetch_ballot() {
            $.ajax({
                url: '../util_classes/Ballot.php?ballot=BALLOT_ALL',
                method: 'GET',
                dataType: 'json'
            })
                .done(function (data) {
                    const pos_arr=[];
                    let total_votes=0;
                    data.data.forEach(values => {
                        total_votes+=values.vote;
                        values.vote = (values.vote ? values.vote : 0);
                        document.querySelector('#total_votes_polled').innerHTML=total_votes;
                        if (document.querySelector(`#can${values.candidate_id}`)) {
                            // document.querySelector(`#can${values.candidate_id} #candidate_id`).innerHTML=values.candidate_id;
                            // document.querySelector(`#can${values.candidate_id} #candidate_name`).innerHTML=values.name;
                            // document.querySelector(`#can${values.candidate_id} #post_name`).innerHTML=values.post;
                            document.querySelector(`#can${values.candidate_id} #vote`).innerHTML = values.vote;
                            if(data.max_post_data[values.post_id].max_candidate_id==values.candidate_id)
                            {
                                document.querySelector(`#can${values.candidate_id} #vote_status`).innerHTML = '<img src="../assets/icons/up-arrow.svg" class="svg-icon" />';
                                document.querySelector(`#can${values.candidate_id} #vote_status`).classList.add('up_vote');
                                document.querySelector(`#can${values.candidate_id} #vote_status`).classList.remove('down_vote');

                                
                            }
                            else
                            {
                                document.querySelector(`#can${values.candidate_id} #vote_status`).innerHTML = '<img src="../assets/icons/down-arrow.svg" class="svg-icon" />';
                                document.querySelector(`#can${values.candidate_id} #vote_status`).classList.add('down_vote');
                                document.querySelector(`#can${values.candidate_id} #vote_status`).classList.remove('up_vote');
                            }
                            
                        }
                        else {
                            if(!pos_arr.includes(values.post_id)){
                                table_ballot_all.innerHTML+=`<br><tr class='common_post'><th id='common_post' style='text-align:left;text-transform:uppercase' colspan='4'>${values.post} ${(values.post_shift=='Both')?'':'('+values.post_shift+')'}</th><th id='common_post_vote'></th></tr>`;
                                pos_arr.push(values.post_id);
                            }
                            table_ballot_all.innerHTML += `
            <tr class='' id=${'can' + values.candidate_id}><td id='candidate_id' class='pr-not' >${values.candidate_id}</td><td id='candidate_image'><img src='${values.image_url}' class='can_small_img'/></td><td id='candidate_name' style='text-transform:uppercase'>${values.name}</td><td id='regno'>${values.regno}</td><td id='vote_data'><b id='vote'>${values.vote}</b>  <span id='vote_status'${(data.max_post_data[values.post_id].max_candidate_id==values.candidate_id)?' class=up_vote ><img src="../assets/icons/up-arrow.svg" class="svg-icon" />':' class=down_vote><img src="../assets/icons/down-arrow.svg" class="svg-icon" />'}</span></td></tr>
         
            `;
                        }
                    })
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    console.error("Request failed:", textStatus, errorThrown);
                })
        }

        fetch_ballot();
        setInterval(() => {
            fetch_ballot()
        }, 3000);
    });
</script>

</html>