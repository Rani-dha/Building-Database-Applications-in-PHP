<?php
try 
{    
    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc', 'fred', 'zap');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // set the PDO error mode to exception
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>
  