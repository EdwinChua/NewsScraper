<?php
include 'connectioninformation.php';

$num = 0;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$title = mysqli_real_escape_string($conn, $_POST['headline']);
$article = mysqli_real_escape_string($conn, $_POST['articlebody']);
$href = mysqli_real_escape_string($conn, $_POST['href']);
$category = mysqli_real_escape_string($conn, $_POST['category']);

$date = mysqli_real_escape_string($conn, $_POST['date']);
$date = strtotime( $date );
$date = date( 'Y-m-d H:i:s', $date );

$sql = "SELECT * FROM `Articles` WHERE Hyperlink = '$href'";

$result = $conn->query($sql);
$num = $result->num_rows;

if($num <1)
{
  $sql = "INSERT INTO Articles (Title, TextBody, Hyperlink, ArticlePostTimeStamp, Category)
  VALUES ('$title','$article','$href','$date','$category')";

  if ($conn->query($sql) === TRUE)
  {
  	//echo $conn->insert_id;
    //echo "added";
  }
  else
  {
      echo json_encode("We encountered an error adding this article.");
      //echo $sql;
  }
}
else
{
  //echo "skipped";
}
$conn->close();

?>
