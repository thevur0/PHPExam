<?php
header("Content-Type: text/html;charset=utf-8");
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=yes" />
    <title>PMP练习</title>
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
<a href="./test.html">Home</a>
<form action="" method="post">
<?php
//ini_set('display_errors',1);
$isModble = isMobile();
if ($isModble)
{
    //echo "手机";
}
//$dbhost = "144.202.62.208";
$dbhost = "localhost";
$username = "root";
$userpass = "Lhy19850924";
$dbdatabase = "exam";
$table = strval($_GET['type']);

$db=new mysqli($dbhost,$username,$userpass,$dbdatabase);
if(mysqli_connect_error()){
    echo 'Could not connect to database.';
    exit;
}
$db->query('SET NAMES UTF8');
$sql =  "SELECT * FROM $table order by rand() limit 5;";
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

    $note = htmlspecialchars($row[7]);
    $title = nl2br($row[1],true);
    $note =  str_replace("\r\n","",$note);

    echo <<<EOF
    <span style="line-height:24px;">
    <h3>$index.$title</h3>
    <label style="font-size: 12pt"><input type="radio" name="$radioname" value=$valueA onclick="getValue($labelanswerID,$labelnoteID,this.value,'$note')">A.$row[3]</label><br>
    <label style="font-size: 12pt"><input type="radio" name="$radioname" value=$valueB onclick="getValue($labelanswerID,$labelnoteID,this.value,'$note')">B.$row[4]</label><br>
    <label style="font-size: 12pt"><input type="radio" name="$radioname" value=$valueC onclick="getValue($labelanswerID,$labelnoteID,this.value,'$note')">C.$row[5]</label><br>
    <label style="font-size: 12pt"><input type="radio" name="$radioname" value=$valueD onclick="getValue($labelanswerID,$labelnoteID,this.value,'$note')">D.$row[6]</label><br>
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
<script src="https://code.jquery.com/jquery.js"></script>
<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootmetro.js"></script>
</body>
</html>
<?php
function isMobile() {
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset($_SERVER['HTTP_VIA'])) {
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高。其中'MicroMessenger'是电脑微信
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile','MicroMessenger');
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
}
?>