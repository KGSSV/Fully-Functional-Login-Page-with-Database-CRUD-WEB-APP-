<?php
session_start();
echo "<h1>Welcome to the Automobiles Database</h1>";
if ( isset($_SESSION['success']) ) 
{
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}
if ( isset($_SESSION['error']) ) 
{
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
$count = 0;
require_once "pdo.php";
$sql = "SELECT make , model , year , mileage , autos_id FROM autos";
$stmt = $pdo -> query($sql);
$true = TRUE;
while( $row = $stmt -> fetch(PDO::FETCH_ASSOC))
{
   
    if($true)
    {
        echo "<table border ='1'>";
        echo"<th>Make</th>";
        echo "<th>Model</th>";
        echo "<th>Year</th>";
        echo "<th>Mileage</th>";
        echo "<th>Action</th>";
        $true = FALSE;
    }
    if($row)
    {
        echo "<tr><td>";
        echo (htmlentities($row['make']));
        echo "</td><td>";
        echo (htmlentities($row['model']));
        echo "</td><td>";
        echo (htmlentities($row['year']));
        echo "</td><td>";
        echo (htmlentities($row['mileage']));
        echo "</td><td>";
        echo "<a href='edit.php?autos_id=".$row['autos_id']."'>Edit</a> / "; 
        echo "<a href='delete.php?autos_id=".$row['autos_id']."'>Delete</a>"; 
        echo "</td></tr>\n";
        $count = $count+1;
    }
   
}

echo "</table>";
if($count == 0)
{
    echo "No rows found";
}
?>

<html>
    <head>
        <title>KGSSV AKHIL KUMAR</title>
    <style>
        a:link{
            text-decoration: none;
        }
        a:hover
        {
            text-decoration: underline;
        }
    </style>
    </head>
    <body>
        <p><a href="add.php">Add New Entry</a></p>
        <p><a href="logout.php">Logout</a></p>
    </body>
</html>
