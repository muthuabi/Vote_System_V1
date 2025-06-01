<?php
    ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Old Ballot</title>
    <script src="../assets/css-js/SearchTool.js"></script>
</head>
<body>

        <header>
            <?php include_once('includes/navbar.php'); ?>
        </header>

        <main class="content-wrapper">
        <?php include_once('../util_classes/Admin.php'); ?>
        <div class='container my-2'>
      
            <?php
            $result = $admin->read_migrate_data();
                if ($data = $result['data']) {
                   
              
       echo "
         <div class='search-box d-flex  justify-content-center' >
                <div class='form-group d-flex gap-2 w-75'  style='z-index:20001'>
                    <input type='text' name='input-search' id='input-search' class='form-control'>
                    <button type='button' id='search-btn'  class='btn btn-primary'>Search</button>
                </div>
        </div>
       <div class='table-responsive'>
        <table class='table'>
            <thead>
                <tr>
                    <th>Regno</th>
                    <th>Post</th>
                    <th>Votes</th>
                    <th>Election Year</th>

                </tr>
             
            </thead>
            <tbody id='ballot_table'>";
			 for ($i = 0; $i < count($data); $i++) {
                        echo "<tr><td>{$data[$i]['regno']}</td><td>{$data[$i]['post_with_shift']}</td><td>{$data[$i]['votes']}</td><td>{$data[$i]['election_year']}</td></tr>";
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
        </div>
        </main>
  
</body>
</html>
