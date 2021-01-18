<?php

session_start();
require_once "pdo.php";

if ( ! isset($_SESSION['name']) ) {
	die('Not logged in');
}

// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: logout.php');
    return;
}

$status = false;

if ( isset($_SESSION['status']) ) {
	$status = $_SESSION['status'];
	$status_color = $_SESSION['color'];

	unset($_SESSION['status']);
	unset($_SESSION['color']);
}

$name = htmlentities($_SESSION['name']);

$_SESSION['color'] = 'red';

// Check to see if we have some POST data, if we do process it
if (isset($_POST['mileage']) && isset($_POST['year']) && isset($_POST['make'])) 
{
    if ( !is_numeric($_POST['mileage']) || !is_numeric($_POST['year']) ) 
    {
        //$status = "Mileage and year must be numeric";
        $_SESSION['status'] = "Mileage and year must be numeric";
        header("Location: add.php");
		return;
    } 
    else if (strlen($_POST['make']) < 1)
    {
        //$status = "Make is required";
        $_SESSION['status'] = "Make is required";
        header("Location: add.php");
		return;
    }
    else 
    {
        $make = htmlentities($_POST['make']);
        $year = htmlentities($_POST['year']);
        $mileage = htmlentities($_POST['mileage']);

        $stmt = $pdo->prepare("
            INSERT INTO autos (make, year, mileage) 
            VALUES (:make, :year, :mileage)
        ");

        $stmt->execute([
            ':make' => $make, 
            ':year' => $year,
            ':mileage' => $mileage,
        ]);

        $_SESSION['status'] = 'Record inserted';
        $_SESSION['color'] = 'green';

        header('Location: view.php');
    	return;
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Dharani T's Autos</title>
        <!-- Css only -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <h1>Tracking Autos for <?php echo $name; ?></h1>
            <?php
                if ( $status !== false ) 
                {
                    // Look closely at the use of single and double quotes
                    echo(
                        '<p style="color: ' .$status_color. ';" class="col-sm-10 col-sm-offset-2">'.
                            htmlentities($status).
                        "</p>\n"
                    );
                }
            ?>
            <form method="post" class="form-horizontal">
                <div class="form-group row">
                    <label class="col-form-label col-sm-2" for="make">Make:</label>
                    <div class="col-sm-3">
                        <input class="form-control" type="text" name="make" id="make">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-2" for="year">Year:</label>
                    <div class="col-sm-3">
                        <input class="form-control" type="text" name="year" id="year">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-2" for="mileage">Mileage:</label>
                    <div class="col-sm-3">
                        <input class="form-control" type="text" name="mileage" id="mileage">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm">
                        <input class="btn btn-primary" type="submit" value="Add">
                        <input class="btn" type="submit" name="logout" value="Cancel">
                    </div>
                </div>
            </form>

        </div>
    </body>
</html>
