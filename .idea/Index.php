<?php
//echo "1234";
$dbhost = "localhost";
$username = "root";
$userpass = "123456";
$dbdatabase = "exam";

$db=new mysqli($dbhost,$username,$userpass,$dbdatabase);
if(mysqli_connect_error()){
    echo 'Could not connect to database.';
    exit;
}
$result=$db->query("SELECT ID,Question,Answer,A,B,C,D,Note FROM pmp");
$index = 1;
while ($row=$result->fetch_row())
{
    $radioname = $index + "radio";
    echo <<<EOF
    <h4>$index.$row[1]</h4>
    <span style="line-height:24px;">
    <input type="radio" name=$radioname value="A">A.$row[3]<br>
    <input type="radio" name=$radioname value="B">B.$row[4]<br>
    <input type="radio" name=$radioname value="C">C.$row[5]<br>
    <input type="radio" name=$radioname value="D">D.$row[6]<br>
    </span>
EOF;
    $index++;
}



?>
