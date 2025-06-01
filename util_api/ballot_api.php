<?php 
    require_once('../util_classes/Ballot.php');
    $ballot=new Ballot($conn);
    //print_r($ballot->showBallotAll());
    if(isset($_GET['ballot']) && !empty(trim($_GET['ballot'])))
    {
        $ballot_case=$_GET['ballot'];
        switch($ballot_case)
        {
            case 'BALLOT_ALL':
                $result=$ballot->showBallotAll();
                $result['poll_status']='not_started';
                if($data=$poll->get_status($academic_year))
                    $result['poll_status']=$data['poll_status'];
                echo json_encode($result);
                break;
            case 'BALLOT_POST_ID':
                if(isset($_GET['post_id']) && !empty(trim($_GET['post_id'])))
                {
                    $post_id=$_GET['post_id'];
                    echo json_encode($ballot->showBallotAllbyPost($post_id));
                }
                else
                {
                    echo json_encode(['data'=>[],'num_rows'=>'0']);
                    http_response_code(404);
                }
                break;
            case 'BALLOT_POSITION_GROUP':
                echo json_encode($ballot->totalVotesCandidatesbyPost());
                break;
            default:
                echo json_encode(['data'=>[],'num_rows'=>'0']);
                http_response_code(404);
        }
    }
?>