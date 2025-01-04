<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Admin</title>

</head>

<body>
    <header>
        <?php
        include_once("includes/navbar.php");
        ?>
    </header>
    <main class="content-wrapper">

        <?php

        include_once("../util_classes/Admin.php");
        include_once("includes/response_modal.php");

        ?>
        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <buton type='button' class="btn-close" data-bs-dismiss='alert'></buton>
            <b>Warnings will be displayed Here</b><br>
            <?php
            if (isset($_POST['add_admin'])) {
                try {
                    $add_admin = new Admin($conn);
                    $add_admin->username = trim($_POST['username']);
                    $add_admin->name = $_POST['name'];
                    //$add_admin->password=base64_encode($_POST['password']);
                    $add_admin->password = $_POST['password'];
                    $add_admin->email = $_POST['email'];
                    $add_admin->role = $_POST['role'];
                    if ($add_admin->insert_admin())
                        echo "<script>modal_show('#responsemodal','Registered Successfully!');</script>";
                    else {
                        throw new Exception('Register Error! Some Error Occured');
                    }
                } catch (Exception $e) {
                    echo "<script>modal_show('#responsemodal','{$e->getMessage()}');</script>";
                }
            }
            if (isset($_POST['edit_admin'])) {
                try {
                    $pass_flag = false;
                    $edit_admin = new Admin($conn);
                    $edit_admin->username = trim($_POST['username']);
                    $edit_admin->name = $_POST['name'];
                    if (isset($_POST['password']) && !empty(trim($_POST['password']))) {
                        $edit_admin->password = $_POST['password'];
                        $pass_flag = true;
                    }
                    $edit_admin->email = $_POST['email'];
                    $edit_admin->role = $_POST['role'];
                    if ($pass_flag) {
                        if ($edit_admin->update_admin(trim($_POST['old_username'])))
                            echo "<script>modal_show('#responsemodal','Updated Successfully!');</script>";
                        else {
                            if ($edit_admin->error)
                                throw new Exception('Update Error! Some Error Occured');
                            echo "<script>modal_show('#responsemodal','Updated with no changes Successfully!');</script>";
                        }
                    } else {
                        if ($edit_admin->update_admin_no_pass(trim($_POST['old_username'])))
                            echo "<script>modal_show('#responsemodal','Updated Successfully!');</script>";
                        else {
                            if ($edit_admin->error)
                                throw new Exception('Update Error! Some Error Occured');
                            echo "<script>modal_show('#responsemodal','Updated with no changes Successfully!');</script>";
                        }
                    }
                } catch (Exception $e) {
                    echo "<script>modal_show('#responsemodal','{$e->getMessage()}');</script>";
                }
            }
            if (isset($_POST['delete']) && trim($_POST['delete'])) {
                try {

                    if ($admin->delete_admin(trim($_POST['delete'])))
                        echo "<script>modal_show('#responsemodal','Deleted Successfully!');</script>";
                    else
                        throw new Exception('Deletion Unsuccessful');
                } catch (Exception $e) {
                    echo "<script>modal_show('#responsemodal','{$e->getMessage()}');</script>";
                }
            }
            if (isset($_POST['edit']) && trim($_POST['edit'])) {
                if ($value = $admin->read_admin_one($_POST['edit'])) {
                    //$value['password']=base64_decode($value['password']);
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
                        <h5 class="modal-title" id="candidateLabel">Admin Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" id="add-edit-admin">

                            <div class="form-group">
                                <label for="username">
                                    User Name
                                </label>
                                <input type="text" name='username' value="<?php if (isset($value)) echo $value['username']; ?>" required id='username' class="form-control">
                                <?php if (isset($value)) echo "<input type='hidden' name='old_username' value='{$value['username']} ' />" ?>
                            </div>

                            <div class="form-group">
                                <label for="name">
                                    Name
                                </label>
                                <input type="text" name='name' value="<?php if (isset($value)) echo $value['name']; ?>" required id='name' class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">
                                    Email
                                </label>
                                <input type="text" name='email' value="<?php if (isset($value)) echo $value['email']; ?>" required id='email' class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">
                                    Password
                                </label>
                                <!-- <input type="password" name='password' maxlength="15" value="<?php if (isset($value)) echo $value['password']; ?>" required id='password' class="form-control"> -->
                                <input type="password" name='password' <?php if (!isset($value)) echo 'required' ?> maxlength="15" id='password' class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="role">Role</label>
                                <select name='role' id='role' class='form-control'>
                                    <!-- <option value='admin' <?php if (isset($value) && ($value['role'] == 'admin')) echo 'selected'; ?>>Admin</option> -->
                                    <option value='sub-admin' <?php if (isset($value) && ($value['role'] == 'sub-admin')) echo 'selected'; ?>>Sub-Admin</option>
                                    <option value='viewer' <?php if (isset($value) && ($value['role'] == 'viewer')) echo 'selected'; ?>>Viewer</option>
                                    <option value='restricted' <?php if (isset($value) && ($value['role'] == 'restricted')) echo 'selected'; ?>>Restricted</option>
                                </select>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit" form="add-edit-admin" <?php if (isset($value)) echo " name='edit_admin' value='edit_admin' >Update";
                                                                                            else echo " name='add_admin' value='add_admin' >Submit"; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <form id='form_temp' method="post">

        </form>
        <?php
        $result = $admin->read_admin_All();
        if ($data = $result['data']) {


            echo "<div class='table-responsive '>
        <table class='table my-2'>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th>Last Changed</th>
                   
             
                    <th colspan='2'>Actions</th>
                </tr>
                <caption>Admin Data Can't Be Manipulated</caption>
            </thead>
            <tbody>";

            // FOR SECURITY
            // <td id='password-column'>".$data[$i]['password']."</td>
            // Removed from the below Loop

            for ($i = 0; $i < count($data); $i++) {
                if ($data[$i]['role'] == 'admin')
                    continue;
                echo "<tr><td>{$data[$i]['username']}</td><td>{$data[$i]['name']}</td><td>{$data[$i]['role']}</td><td>{$data[$i]['email']}</td><td>{$data[$i]['updated_on']}</td>
                <td><button class='btn btn-warning' type='submit' name='edit' value='{$data[$i]['username']}' form='form_temp'>Edit</button></td><td><button class='btn btn-danger' type='submit' name='delete' value='{$data[$i]['username']}' form='form_temp'>Delete</button></td></tr>";


                /*            
    //ECHO BEFORE SHA256
         echo "<tr><td>{$data[$i]['username']}</td><td>{$data[$i]['name']}</td><td>{$data[$i]['role']}</td><td>{$data[$i]['email']}</td><td id='password-column'>".base64_decode($data[$i]['password'])."</td><td>{$data[$i]['updated_on']}</td>
                <td><button class='btn btn-warning' type='submit' name='edit' value='{$data[$i]['username']}' form='form_temp'>Edit</button></td><td><button class='btn btn-danger' type='submit' name='delete' value='{$data[$i]['username']}' form='form_temp'>Delete</button></td></tr>";
                */
            }

            echo "</tbody>
            <tfoot>

            </tfoot>
        </table>
        </div>";
        } else {
            echo "<center><b>No Data Available</b></center>";
        }
        ?>
    </main>

</body>
<script>
</script>

</html>