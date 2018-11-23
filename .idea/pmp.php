<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PHP刷题</title>
    <style type="text/css">
        label.red{
            color: #FF0000;}
        label.green{
            color: #007700;}
        label.black{
            color: #000000;
        }
        label.hide { visibility: hidden}
    </style>
</head>
<body>

<form action="" method="post">
<?php
header('Content-Type:text/html;charset=utf-8');
//echo "1234";
$dbhost = "localhost";
$username = "root";
$userpass = "Lhy19850924";
$dbdatabase = "exam";

$db=new mysqli($dbhost,$username,$userpass,$dbdatabase);
if(mysqli_connect_error()){
    echo 'Could not connect to database.';
    exit;
}

$sql =  "SELECT * FROM pmp order by rand() limit 5;";
mysql_query("SET NAMES UTF8");
$result=$db->query($sql);
$index = 1;
$formname = "";

static $row;
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
    <span style="line-height:24px;">
    <h3>$index.$row[1]</h3>
    <label style="font-size: 12pt"><input type="radio" name="$radioname" value=$valueA onclick="getValue($labelanswerID,$labelnoteID,this.value,'$row[7]')">A.$row[3]</label><br>
    <label style="font-size: 12pt"><input type="radio" name="$radioname" value=$valueB onclick="getValue($labelanswerID,$labelnoteID,this.value,'$row[7]')">B.$row[4]</label><br>
    <label style="font-size: 12pt"><input type="radio" name="$radioname" value=$valueC onclick="getValue($labelanswerID,$labelnoteID,this.value,'$row[7]')">C.$row[5]</label><br>
    <label style="font-size: 12pt"><input type="radio" name="$radioname" value=$valueD onclick="getValue($labelanswerID,$labelnoteID,this.value,'$row[7]')">D.$row[6]</label><br>
    <label id="$labelanswerID" class="hide" style="font-size: 12pt">答案：$row[2]</label><br>
    <label id="$labelnoteID"  class="black" style="font-size: 12pt"></label><br>
    </span>
EOF;
    $index++;
}
?>
    <HR><input type="submit" id="id_submit" name="the_submit" value="再出题" style="width:200px;height:60px; font-size: 30px" />
<script>
    function getValue(labelid,labelnoteid,radiovalue,test){
        if(radiovalue == 1)
        {
            labelid.className = "green";
        }
        else
        {
            labelid.className = "red";
        }
        labelnoteid.textContent = test;
    }
</script>

</form>
</body>
</html>