<?php
    ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Booths</title>

</head>

<body>
    <header>
        <?php
        include_once("includes/navbar.php");
        ?>
    </header>
    <main class="content-wrapper">

        <?php

        include_once("../util_classes/VBooth.php");
        include_once("includes/response_modal.php");

        ?>
        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <buton type='button' class="btn-close" data-bs-dismiss='alert'></buton>
            <b>Warnings will be displayed Here</b><br>

            <?php
            if (isset($_POST['add_vbooth'])) {
                try {
                    //print_r($_POST);
                    $add_vbooth = new VBooth($conn);
                    $add_vbooth->vb_name = $_POST['vb_name'];
                    $add_vbooth->vb_location = $_POST['vb_location'];
                    $add_vbooth->vb_incharge= $_POST['vb_incharge'];
                    $add_vbooth->vb_status = $_POST['vb_status'];
                    if ($add_vbooth->insert_booth())
                        echo "<script>modal_show('#responsemodal','Registered Successfully!');</script>";
                    else {
                        throw new Exception('Register Error! Some Error Occured');
                    }
                } catch (Exception $e) {

                    echo "<script>modal_show('#responsemodal','{$e->getMessage()}');</script>";
                }
            }
            if (isset($_POST['edit_vbooth'])) {
                try {
                    $edit_vbooth = new VBooth($conn);
                    $edit_vbooth->vb_name=$_POST['vb_name'];
                    $edit_vbooth->vb_location = $_POST['vb_location'];
                    $edit_vbooth->vb_incharge= $_POST['vb_incharge'];
                    $edit_vbooth->vb_status = $_POST['vb_status'];
                    if ($edit_vbooth->update_booth_byid($_POST['vb_id']))
                        echo "<script>modal_show('#responsemodal','Updated Successfully!');</script>";
                    else {
                        if ($edit_vbooth->error)
                            throw new Exception('Update Error! Some Error Occured');
                        echo "<script>modal_show('#responsemodal','Updated with no changes Successfully!');</script>";
                    }
                } catch (Exception $e) {
                    echo "<script>modal_show('#responsemodal','{$e->getMessage()}');</script>";
                }
            }
            if (isset($_POST['delete']) && trim($_POST['delete'])) {
                try {
                    if ($vb->delete_booth_id($_POST['delete']))
                        echo "<script>modal_show('#responsemodal','Deleted Successfully!');</script>";
                    else
                        throw new Exception('Deletion Unsuccessful');
                } catch (Exception $e) {
                    echo "<script>modal_show('#responsemodal','{$e->getMessage()}');</script>";
                }
            }
            if (isset($_POST['edit']) && trim($_POST['edit'])) {
                if ($value = $vb->readOne($_POST['edit'])) {
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
                        <h5 class="modal-title" id="candidateLabel">Voting Booth Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" id="add-edit-vbooth">

                            <div class="form-group">
                                <label for="vb_name">
                                    Booth Name
                                </label>
                                <input type="text" placeholder="Eg:booth_01" style="text-transform: lowercase;" name='vb_name' value="<?php if (isset($value)) echo $value['vb_name']; ?>" required id='vb_name' class="form-control">
                                <?php if (isset($value)) echo "<input type='hidden' name='vb_id' value='{$value['vb_id']} ' />" ?>
                                <small>Type the valid Booth Name</small>
                            </div>
                            <div class="form-group">
                                <label for="vb_location">Location</label>
                                <textarea name='vb_location' id='vb_location' required class="form-control"><?php if (isset($value)) echo $value['vb_location'];
                                     else echo "St Xavier's College"; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="vb_incharge">
                                    Booth Incharge
                                </label>
                                <input type="text" name='vb_incharge' value="<?php if (isset($value)) echo $value['vb_incharge']; ?>" required id='vb_incharge' class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="vb_status">Status</label>
                                <select name='vb_status' id='vb_status' class='form-control'>
                                    <option value='inactive' <?php if (isset($value) && ($value['vb_status'] == 'inactive')) echo 'selected'; ?>>InActive</option>
                                    <option value='active' <?php if (isset($value) && ($value['vb_status'] == 'active')) echo 'selected'; ?>>Active</option>
                                    <option value='restricted' <?php if (isset($value) && ($value['vb_status'] == 'restricted')) echo 'selected'; ?>>Restricted</option>
                                    <option value='suspended' <?php if (isset($value) && ($value['vb_status'] == 'suspended')) echo 'selected'; ?>>Suspended</option>

                                </select>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit" form="add-edit-vbooth" <?php if (isset($value)) echo " name='edit_vbooth' value='edit_vbooth' >Update";
                            else echo " name='add_vbooth' value='add_vbooth' >Submit"; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <form id='form_temp' method="post">

        </form>
        <?php
        $result = $vb->readAll();
        if ($data = $result['data']) {


            echo "<div class='table-responsive '>
        <table class='table my-2 sxc-positions '>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Booth Name</th>
                    <th>Location</th>
                    <th>Incharge</th>
                    <th>Status</th>
                    <th>Updated On</th>
                    <th colspan='2'>Actions</th>
                </tr>
            </thead>
            <tbody>";
            for ($i = 0; $i < count($data); $i++) {
                echo "<tr><td>{$data[$i]['vb_id']}</td><td style='text-transform:uppercase'>{$data[$i]['vb_name']}</td><td>{$data[$i]['vb_location']}</td><td>{$data[$i]['vb_incharge']}</td><td>{$data[$i]['vb_status']}</td><td>{$data[$i]['updatedOn']}</td>
                <td><button class='btn btn-warning' type='submit' name='edit' value={$data[$i]['vb_id']} form='form_temp'>Edit</button></td><td><button class='btn btn-danger' type='submit' name='delete' value={$data[$i]['vb_id']} form='form_temp'>Delete</button></td></tr>";
            }

            echo "</tbody>
            <tfoot>

            </tfoot>
        </table>
        </div>";
        } else {
            echo "<center><b>No Data Available</b></center>";
        }
        $dir="./loc_vs";
        if(is_dir($dir))
        {
            $files=scandir($dir);
            $f_count=count($files);
            if(($f_count-2)>0)
            {
            echo "<br><b>Local Vote Booth Files</b>";
            echo "<div class='table-responsive'><table class='table my-2 sxc-positions'>
            <thead><tr><th>SNo</th><th>File Name</th><th>File Type</th><th>File Modified</th><th colspan='2'>File Actions</th></tr></thead><tbody>";
            for($i=2;$i<$f_count;$i++)
            {
                $floc=$dir.'/'.$files[$i];
                $fname=pathinfo($floc,PATHINFO_FILENAME);
                $fext=pathinfo($floc,PATHINFO_EXTENSION);
                $mtime=filemtime($floc);
                $sno=$i-1;
                echo "<tr><td>$sno</td><td>$fname</td><td>$fext</td><td>".date('d-m-Y h:i:s',$mtime)."</td><td><a class='btn btn-success' target='blank' href='$floc'>View</a></td><td><a class='btn btn-warning' href='$floc' download>Download</a></td></tr>";
            }
            echo "</tbody></table></div>";
            }
            else
            {
                echo "<center><b>No Files Available</b></center>";
            }   
        }

        ?>
    </main>

</body>
<script>
</script>

</html>
