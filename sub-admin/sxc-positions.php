<?php
    ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Positions</title>
   
</head>

<body>
    <header>
        <?php
        include_once("includes/navbar.php");
        ?>
    </header>
    <main class="content-wrapper" >
	
        <?php
      
        include_once("../util_classes/Position.php");
        include_once("includes/response_modal.php");
      
        ?>
        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <buton type='button'  class="btn-close" data-bs-dismiss='alert'></buton>
            <b>Warnings will be displayed Here</b><br>

        <?php
        if (isset($_POST['add_position'])) {
            try {
                $add_position=new Position($conn);
                $add_position->post=$_POST['post'];
                $add_position->post_shift=$_POST['post_shift'];
                $add_position->post_status=$_POST['post_status'];
                $add_position->description=$_POST['description'];
                $add_position->who_can_vote=$_POST['who_can_vote'];
                if ($add_position->insert())
                    echo "<script>modal_show('#responsemodal','Registered Successfully!');</script>";
                else {
                    throw new Exception('Register Error! Some Error Occured');
                }
            } catch (Exception $e) {

                echo "<script>modal_show('#responsemodal','{$e->getMessage()}');</script>";
            }
        }
        if (isset($_POST['edit_position'])) {
            try {
                $edit_position = new Position($conn);
                $edit_position->post=$_POST['post'];
                $edit_position->post_shift=$_POST['post_shift'];
                $edit_position->post_status=$_POST['post_status'];
                $edit_position->description=$_POST['description'];
                $edit_position->who_can_vote=$_POST['who_can_vote'];
                // $edit_candidate->post_id = $_POST['post_id'];
                if ($edit_position->update($_POST['post_id']))
                    echo "<script>modal_show('#responsemodal','Updated Successfully!');</script>";
                else 
                {
                    if($edit_position->error)
                        throw new Exception('Update Error! Some Error Occured');
                    echo "<script>modal_show('#responsemodal','Updated with no changes Successfully!');</script>";
                }
            } catch (Exception $e) {
                echo "<script>modal_show('#responsemodal','{$e->getMessage()}');</script>";
            }
        }
        if (isset($_POST['delete']) && trim($_POST['delete'])) {
            try {
                if ($pos->deleteOne($_POST['delete']))
                    echo "<script>modal_show('#responsemodal','Deleted Successfully!');</script>";
                else
                    throw new Exception('Deletion Unsuccessful');
            } catch (Exception $e) {
                echo "<script>modal_show('#responsemodal','{$e->getMessage()}');</script>";
            }
        }
        if (isset($_POST['edit']) && trim($_POST['edit'])) {
            if ($value = $pos->readOne($_POST['edit'])) {
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
                        <h5 class="modal-title" id="candidateLabel">Position Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" id="add-edit-position" >
       
                            <div class="form-group">
                                <label for="post">
                                    Post Name
                                </label>
                                <input type="text" name='post' value="<?php if (isset($value)) echo $value['post']; ?>" required id='post' class="form-control">
                                <?php if (isset($value)) echo "<input type='hidden' name='post_id' value='{$value['post_id']} ' />" ?>
                                <small>Type the valid Post Name</small>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea  name='description' id='description' required class="form-control"><?php if (isset($value)) echo $value['description'];else echo 'Serves'; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="post_shift">Shift</label>
                                <select name='post_shift' id='post_shift' class='form-control'>
                                    <option value='Both' <?php if (isset($value) && ($value['post_shift'] == 'Both')) echo 'selected'; ?>>Both Shifts</option>
                                    <option value='Shift-I' <?php if (isset($value) && ($value['post_shift'] == 'Shift-I')) echo 'selected'; ?>>Shift - I</option>
                                    <option value='Shift-II' <?php if (isset($value) && ($value['post_shift'] == 'Shift-II')) echo 'selected'; ?>>Shift - II</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="who_can_vote">Who can vote</label>
                                <select name='who_can_vote' id='who_can_vote' class='form-control'>
                                    <option value='MF' <?php if (isset($value) && ($value['who_can_vote'] == 'MF')) echo 'selected'; ?>>Male & Female</option>
                                    <option value='M' <?php if (isset($value) && ($value['who_can_vote'] == 'M')) echo 'selected'; ?>>Male</option>
                                    <option value='F' <?php if (isset($value) && ($value['who_can_vote'] == 'F')) echo 'selected'; ?>>Female</option>
                                </select>
                            </div>
                           

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit" form="add-edit-position" <?php if (isset($value)) echo " name='edit_position' value='edit_position' >Update";
                                                                                                else echo " name='add_position' value='add_position' >Submit"; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <form id='form_temp' method="post">

        </form>
		<?php
                $result = $pos->readAll();
                if ($data = $result['data']) {
                   
              
       echo "<div class='table-responsive '>
        <table class='table my-2 sxc-positions '>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Position</th>
                    <th>Description</th>
                    <th>Shift</th>
                    <th>Who Can Vote</th>
                   
             
                    <th colspan='2'>Actions</th>
                </tr>
            </thead>
            <tbody>";
			 for ($i = 0; $i < count($data); $i++) {
                        echo "<tr><td>{$data[$i]['post_id']}</td><td>{$data[$i]['post']}</td><td>{$data[$i]['description']}</td><td>{$data[$i]['post_shift']}</td><td>{$data[$i]['who_can_vote']}</td>
                <td><button class='btn btn-warning' type='submit' name='edit' value={$data[$i]['post_id']} form='form_temp'>Edit</button></td><td><button class='btn btn-danger' type='submit' name='delete' value={$data[$i]['post_id']} form='form_temp'>Delete</button></td></tr>";
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
