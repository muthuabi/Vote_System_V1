<?php
    ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Canditate</title>
   
</head>

<body>
    <header>
        <?php
        include_once("includes/navbar.php");
        ?>
    </header>
    <main class="content-wrapper" >
	
        <?php
        include_once("../util_classes/Candidates.php");
        include_once("../util_classes/Position.php");
        include_once("../util_classes/Can_Pos_Join.php");
        include_once("includes/response_modal.php");
        include_once("../util_classes/Vote.php");
        $types = ['image/jpeg', 'image/png', 'image/jpg','image/webp','image/jfif'];
        ?>
     <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <buton type='button'  class="btn-close" data-bs-dismiss='alert'></buton>
            <b>Warnings will be displayed Here</b><br>
        <?php
        if (isset($_POST['add_candidate'])) {
            try {
                $add_candidate = new Candidate($conn);
                $add_candidate->regno = $_POST['regno'];
                $add_candidate->name = $_POST['name'];
                $add_candidate->shift = $_POST['shift'];
                $add_candidate->post_id = $_POST['post_id'];
                $add_candidate->year = $_POST['year'];
                $add_candidate->course = $_POST['course'];
                $add_candidate->election_year=$_POST['election_year'];
                if (isset($_FILES['image_url'])) {
                   
                    if (!in_array($_FILES['image_url']['type'], $types))
                        throw new Exception('File Should be Png,Jpg,Webp,Jfif or Jpeg');
                    if ($_FILES['image_url']['size'] > (500 * 1024))
                        throw new Exception('File Size should be less than 500kb');
                    if ($add_candidate->fileUpload($_FILES['image_url'])) {
                        echo "File Upload Sucess" . $add_candidate->image_url;
                    } else
                        throw new Exception('File Upload Failed');
                } else {
                    throw new Exception('No File Uploaded');
                }
                if ($add_candidate->insert())
                {
                    echo "<script>modal_show('#responsemodal','Registered Successfully!');</script>";
                }
                else {
                    throw new Exception('Register Error! Some Error Occured');
                }
            } catch (Exception $e) {

                echo "<script>modal_show('#responsemodal','{$e->getMessage()}');</script>";
            }
        }
        if (isset($_POST['edit_candidate'])) {
            try {
                $edit_candidate = new Candidate($conn);
                $edit_candidate->regno = $_POST['regno'];
                $edit_candidate->name = $_POST['name'];
                $edit_candidate->shift = $_POST['shift'];
                $edit_candidate->post_id = $_POST['post_id'];
                $edit_candidate->year = $_POST['year'];
                $edit_candidate->course = $_POST['course'];
                $edit_candidate->election_year=$_POST['election_year'];
                $edit_candidate->candidate_id = $_POST['candidate_id'];
                if (isset($_FILES['image_url']) && !$_FILES['image_url']['error']) {
                   
                    if (!in_array($_FILES['image_url']['type'], $types))
                        throw new Exception('File Should be Png,Jpg,Webp,Jfif or Jpeg');
                    if ($_FILES['image_url']['size'] > (1024 * 1024))
                        throw new Exception('File Size should be less than 1mb');
                    if ($edit_candidate->fileUpdate($_FILES['image_url'])) {
                        echo "File Upload Success";
                    } else
                        throw new Exception('File Upload Failed');
                } else {
                    //throw new Exception('No File Uploaded');
                    if(isset($_POST['image_update_url']))
                    $edit_candidate->image_url=$_POST['image_update_url'];
                }
                if ($edit_candidate->update($_POST['candidate_id']))
                    echo "<script>modal_show('#responsemodal','Updated Successfully!');</script>";
                else {
                    if($edit_candidate->error)
                        throw new Exception('Update Error! Some Error Occured');
                    echo "<script>modal_show('#responsemodal','Updated with no changes Successfully!');</script>";
                }
            } catch (Exception $e) {
                echo "<script>modal_show('#responsemodal','{$e->getMessage()}');</script>";
            }
        }
        if (isset($_POST['delete']) && trim($_POST['delete'])) {
            try {
                if ($can->deleteOne($_POST['delete']))
                    echo "<script>modal_show('#responsemodal','Deleted Successfully!');</script>";
                else
                    throw new Exception('Deletion Unsuccessful');
            } catch (Exception $e) {
                echo "<script>modal_show('#responsemodal','{$e->getMessage()}');</script>";
            }
        }
        if (isset($_POST['edit']) && trim($_POST['edit'])) {


            if ($value = $can->readOne($_POST['edit'])) {
                echo "<script>modal_show('#candidate');</script>";
            }
        }
        ?>
        </div>
        <button type="button" name='new' class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#candidate">
            + New
        </button>
        <div class="modal fade" id="candidate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="candidateLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="candidateLabel">Candidate Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" id="add-edit-candidate" enctype="multipart/form-data">
       
                            <div class="form-group">
                                <label for="regno">
                                    Register Number
                                </label>
                                <input type="text" name='regno' value="<?php if (isset($value)) echo $value['regno']; ?>" required id='regno' placeholder="Eg:21UCS107" class="form-control">
                                <?php if (isset($value)) echo "<input type='hidden' name='candidate_id' value='{$value['candidate_id']} ' />" ?>
                            </div>

                            <div class="form-group">
                                <label for="regno">
                                    Candidate Photo
                                </label>
                                <input type="file" name='image_url' <?php if(!isset($value)) echo 'required'; ?> id='image_url' class="form-control">
                                <?php if (isset($value)){ echo "<input name='image_update_url' type='hidden' value='{$value['image_url']}' /><small >"; echo basename($value['image_url']); echo "</small>";} ?>
                                <small>File should be of type png | jpeg | jpg | webp | jfif</small>
                                <small>File size should be below 500kb</small>
                            </div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name='name' id='name' value="<?php if (isset($value)) echo $value['name']; ?>" required class='form-control'>
                                <small>Name should be legit</small>
                            </div>
                            <div class="form-group">
                                <label for="course">Course</label>
                                <input type="text" name='course' placeholder="Eg:BSC COMPUTER SCIENCE" id='course' value="<?php if (isset($value)) echo $value['course']; ?>" required class="form-control">
                               
                            </div>
                            <div class="form-group">
                                <label for="shift">Candidate's Shift</label>
                                <select name='shift' id='shift' class='form-control'>
                                    <option value='Shift-I' <?php if (isset($value) && ($value['shift'] == 'Shift-I')) echo 'selected'; ?>>Shift - I</option>
                                    <option value='Shift-II' <?php if (isset($value) && ($value['shift'] == 'Shift-II')) echo 'selected'; ?>>Shift - II</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="year">Year</label>
                                <input type="text" name='year' id='year' value="<?php if (isset($value)) echo $value['year'];
                                                                                else echo '3'; ?>" readonly class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="election_year">Election Year</label>
                                <input type="text" name='election_year' id='election_year' value="<?php if (isset($value)){ echo $value['election_year']; }else{ echo date('Y').'-'.(((int)date('y'))+1); }?>" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="post">Position</label>
                                <select name='post_id' class="form-control" id='post_id'>
                                    <?php
                                    $pos_result = $pos->readAll();
                                    if ($pos_data = $pos_result['data']) {
                                        for ($i = 0; $i < count($pos_data); $i++) {
                                            echo "<option value='{$pos_data[$i]['post_id']}'";
                                            if (isset($value) && ($value['post_id'] == $pos_data[$i]['post_id']))
                                                echo 'selected';
                                            echo "> ";
                                            echo "{$pos_data[$i]['post_shift']} - {$pos_data[$i]['post']}  </option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit" form="add-edit-candidate" <?php if (isset($value)) echo " name='edit_candidate' value='edit_candidate' >Update";
                                                                                                else echo " name='add_candidate' value='add_candidate' >Submit"; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <form id='form_temp' method="post">

        </form>
		<?php
                $candidateposition = new CandidateAndPosition($conn);
                $result = $candidateposition->readJoinAll();
                if ($data = $result['data']) {
                   
              
       echo "<div class='table-responsive '>
        <table class='table my-2 sxc-candidates'>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Candidate Photo</th>
                    <th>Name</th>
                    <th>Reg No</th>
                    <th>Post</th>
                    <th>Shift</th>
                    <th>Course</th>
                    <th>Election Year</th>
             
                    <th colspan='2'>Actions</th>
                </tr>
            </thead>
            <tbody>";
			 for ($i = 0; $i < count($data); $i++) {
                        echo "<tr><td>{$data[$i]['candidate_id']}</td><td style='text-align:center'><img src='{$data[$i]['image_url']}' class='can_small_img' /></td><td>{$data[$i]['name']}</td><td>{$data[$i]['regno']}</td><td>{$data[$i]['post']}</td><td>{$data[$i]['post_shift']}</td><td>{$data[$i]['course']} ({$data[$i]['shift']})</td><td>{$data[$i]['election_year']}</td>
                <td><button class='btn btn-warning' type='submit' name='edit' value={$data[$i]['candidate_id']} form='form_temp'>Edit</button></td><td><button class='btn btn-danger' type='submit' name='delete' value={$data[$i]['candidate_id']} form='form_temp'>Delete</button></td></tr>";
                    }
                
            echo "</tbody>
            <tfoot>

            </tfoot>
        </table>
        </div>";
				}
				else
				{
					echo "<center><b>No Data Available</b></center>";
				}
				?>
    </main>

</body>
<script>
</script>

</html>
