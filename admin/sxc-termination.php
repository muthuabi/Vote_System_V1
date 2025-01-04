<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletion</title>
   
</head>

<body>
    <header>
        <?php
        include_once("includes/navbar.php");
        ?>
    </header>
    <style>
          
        </style>
    <main class="content-wrapper">
    <?php 
    include_once("includes/confirm_modal.php");
    include_once("../util_classes/Admin.php");
    
    ?>
            <div class="container py-3">
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <!-- <buton type='button'  class='btn-close' data-bs-dismiss='alert'> </buton> -->
             Before deleting table data make sure that you have migrated the current data!
             <br><a href="sxc-migrate.php">Migrate</a>
            </div>
                <?php 
                try
                {
                    if(isset($_POST['delete_table']) && !empty(trim($_POST['delete_table'])))
                    {
                        if($_POST['delete_table']=='admin')
                            throw new Exception('No Access to Delete Admin table');
                        if($admin->delete_table_contents($_POST['delete_table']))
                        {
                            echo "
                            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <buton type='button'  class='btn-close' data-bs-dismiss='alert'> </buton>
                            Table `{$_POST['delete_table']}` Contents have been Deleted</div>";
                        }
                        else
                            throw new Exception("Table `{$_POST['delete_table']}` Deletion Failed");

                    }
                    if(isset($_POST['init_delete_table']))
                        echo "<script>confirm_modal_show('#confirm_modal','{$_POST['init_delete_table']}','Are you sure wanna delete this table Contents?')</script>";
                }
                catch(Exception $e)
                {
                    echo "  <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <buton type='button'  class='btn-close' data-bs-dismiss='alert'> </buton> {$e->getMessage()} </div>";
                }
                ?>

                <div class="row gap-2 gap-md-0 gap-lg-0 ">
                    <div class="col-md-4">
                       <form class="termination-card" method='post'>
                            <div class="termination-card-header">
                                <h2 class='text-uppercase fw-bold'>Votes</h2>
                            </div>
                            <div class="termination-card-bod">
                                    <button type="submit" class="btn btn-danger vote_btn" name='init_delete_table' value='votes'>Delete</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                       <form class="termination-card" method='post'>
                            <div class="termination-card-header">
                                <h2 class='text-uppercase fw-bold'>Candidates</h2>
                            </div>
                            <div class="termination-card-bod">
                                    <button type="submit" class="btn btn-danger vote_btn" name='init_delete_table' value='candidates'>Delete</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                       <form class="termination-card" method='post'>
                            <div class="termination-card-header">
                                <h2 class='text-uppercase fw-bold'>Positions</h2>
                            </div>
                            <div class="termination-card-bod">
                                    <button type="submit" class="btn btn-danger vote_btn" name='init_delete_table' value='position'>Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </main>

</body>
<script>
</script>

</html>