<html>
<head>
    <title>PHP刷题</title>
    <style type="text/css">
        label.red{
            color: #FF0000;}
        label.black{
            color: #000000;
        }
        label.hide { visibility: hidden}
    </style>
</head>
<body>

<form action="" method="post">
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

$sql =  "SELECT * FROM pmp order by rand() limit 5;";

$result=$db->query($sql);
$index = 1;
$answers = array();
$formname = "";
for ($i=1; $i<=5; $i++)
{
    echo $answers[$i];
}
while ($row=$result->fetch_row())
{
    $radioname = "radio".strval($index);
    $formname = "from".strval($index);
    $valueA = 0;
    $valueB = 0;
    $valueC = 0;
    $valueD = 0;
    $note = "";
    $labelanswerID = "label".strval($index);
    $labelnoteID = "labelnote".strval($index);

    if($row[2] == 'A')
        $valueA = 1;

    if($row[2] == 'B')
        $valueB = 1;

    if($row[2] == 'C')
        $valueC = 1;

    if($row[2] == 'D')
        $valueD = 1;
    echo <<<EOF
    <h4>$index.$row[1]</h4>
    <span style="line-height:24px;">

    <input type="radio" name="$radioname" value=$valueA onclick="getValue($labelanswerID,$labelnoteID,this.value)">A.$row[3]<br>
    <input type="radio" name="$radioname" value=$valueB onclick="getValue($labelanswerID,$labelnoteID,this.value)">B.$row[4]<br>
    <input type="radio" name="$radioname" value=$valueC onclick="getValue($labelanswerID,$labelnoteID,this.value)">C.$row[5]<br>
    <input type="radio" name="$radioname" value=$valueD onclick="getValue($labelanswerID,$labelnoteID,this.value)">D.$row[6]<br>

    <label id="$labelanswerID" class="hide">答案：$row[2]</label><br>
    <label id="$labelnoteID"  class="hide">$row[7]</label><br>
    
    </span>
EOF;
    $index++;
}
?>
<script>
    function getValue(labelid,labelnoteid,radiovalue){
        if(radiovalue == 1)
        {
            labelid.className = "black";
        }
        else
        {
            labelid.className = "red";
        };
        labelnoteid.className = "black";
    }
</script>
    <input type="submit" id="id_submit" name="the_submit" value="再出题" />
</form>
</body>
</html>