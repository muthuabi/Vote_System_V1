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
                    <th class="total_votes_th">Total Votes Polled - <b id="total_votes_polled">0</b></th>
                </tr>
            </thead>
            <tbody id="ballot_all">

            </tbody>

        </table>
    </main>
</body>
<script>
	// MY BASE CODE + GPT INTEGRATION FOR OPTIMIZATION
    let flag = 'initial';
    document.addEventListener("DOMContentLoaded", () => {
        const table_ballot_all = document.getElementById("ballot_all");
        const totalVotesElem = document.querySelector('#total_votes_polled');
        const liveElem = document.querySelector("#live");
        const liveBlinkElem = document.querySelector("#live-blink");

        // Elements that show/hide for unopposed/nocontest rows
        const unopposedElements = document.querySelectorAll('.unopposed, .nocontest');

        // Helper to toggle display via class instead of inline style
        function toggleDisplay(elements, show) {
            elements.forEach(el => {
                el.classList.toggle('hidden', !show);
            });
        }

        // Helper to handle play/pause animations on a set of elements
        function toggleAnimations(elements, play) {
            elements.forEach(el => {
                const animation = el.getAnimations()[0];
                if (animation) {
                    play ? animation.play() : animation.pause();
                }
            });
        }

        function fetch_ballot() {
            $.ajax({
                url: '../util_api/ballot_api.php?ballot=BALLOT_ALL',
                method: 'GET',
                dataType: 'json'
            })
            .done(function(data) {
                if (flag === 'failed') {
                    window.dispatchEvent(new Event('server-online'));
                    flag = 'initial';
                }

                const poll_status = data.poll_status;

                // Toggle visibility of unopposed/nocontest rows
                if (poll_status === "ended" || poll_status === "not_started") {
                    liveElem.textContent = ("Polling " + poll_status).toUpperCase();
                    toggleDisplay(unopposedElements, true);
                    toggleAnimations(document.querySelectorAll("#vote_status"), false);
                    if (liveBlinkElem) toggleAnimations([liveBlinkElem], false);
                } else {
                    liveElem.textContent = "LIVE";
                    toggleDisplay(unopposedElements, false);
                    toggleAnimations(document.querySelectorAll("#vote_status"), true);
                    if (liveBlinkElem) toggleAnimations([liveBlinkElem], true);
                }

                // Rebuild table
                if (poll_status === "started" || poll_status=="ended" || poll_status=="not_started") {
                    let html = '';
                    const pos_arr = [];
                    let total_votes = 0;

                    data.data.forEach(values => {
                        total_votes += values.vote || 0;
                    });
                    totalVotesElem.textContent = total_votes;

                    data.data.forEach(values => {
                        // Skip nocontest posts from table building as per original code logic
                        if (values.post_status === "nocontest") return;

                        // Add post header row once
                        if (!pos_arr.includes(values.post_id)) {
                            html += `
                                <br><tr class='common_post ${values.post_status}' id='post${values.post_id}'>
                                    <th id='common_post' style='text-align:left;text-transform:uppercase' colspan='4'>
                                        ${values.post} ${(values.post_shift === 'Both') ? '' : '(' + values.post_shift + ')'}
                                    </th>
                                </tr>
                                <tr class='${values.post_status}'>
                                    <th>PHOTO</th><th>NAME</th><th>REGNO</th><th>VOTES</th>
                                </tr>
                            `;
                            pos_arr.push(values.post_id);
                        }

                        const voteDisplay = (values.post_status === 'unopposed') ? 'unopposed' : (values.vote || 0);
                        const isMax = data.max_post_data[values.post_id] && (data.max_post_data[values.post_id].max_candidate_id === values.candidate_id);
                        const voteStatusClass = ((isMax || values.post_status === 'unopposed') ? 'up_vote' : 'down_vote') +" "+((poll_status!=="started")?"no-anime":"");
				
                        const voteStatusIcon = (poll_status === 'ended') 
                            ? (isMax || values.post_status === 'unopposed' ? 'Win' : '') 
                            : (isMax || values.post_status === 'unopposed' 
                                ? '<img src="../assets/icons/up-arrow.svg" class="svg-icon" />' 
                                : '<img src="../assets/icons/down-arrow.svg" class="svg-icon" />');

                        html += `
                            <tr class='${values.post_status}' id='can${values.candidate_id}'>
                                <td id='candidate_image'><img src='${values.image_url}' class='can_small_img'/></td>
                                <td id='candidate_name' style='text-transform:uppercase'>${values.name}</td>
                                <td id='regno'>${values.regno}</td>
                                <td id='vote_data'>
                                    <span id='vote'>${voteDisplay}</span>  
                                    <span id='vote_status' class='${voteStatusClass}'>${voteStatusIcon}</span>
                                </td>
                            </tr>
                        `;
                    });

                    table_ballot_all.innerHTML = html;
                }

            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                flag = 'failed';
                window.dispatchEvent(new Event('server-offline'));
            });
        }

        // Initial fetch and interval polling
        fetch_ballot();
        setInterval(fetch_ballot, 3000);
    });
</script>
</html>