<?php
date_default_timezone_set("Asia/Kolkata");

$file = "chat.txt";

/* Disable cache (important for Opera Mini) */
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");

/* Save message */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user = trim(strip_tags($_POST["user"]));
    $msg  = trim(strip_tags($_POST["msg"]));

    if ($user != "" && $msg != "") {
        $time = date("d M H:i"); // Mumbai time
        $line = "[$time] $user: $msg\n";
        file_put_contents($file, $line, FILE_APPEND | LOCK_EX);
    }

    // Safe refresh after send
    echo "<meta http-equiv='refresh' content='0;url=index.php'>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Mini Chat</title>

<style>
body {
  font-family: Arial;
  background:#f2f2f2;
  margin:0;
  padding:5px;
}
.chat {
  background:#fff;
  border:1px solid #ccc;
  height:200px;
  overflow:auto;
  font-size:12px;
  padding:5px;
}
.msg { margin-bottom:4px; }

.form-box {
  margin-top:5px;
  background:#fff;
  border:1px solid #ccc;
  padding:5px;
}
input {
  font-size:12px;
  width:95%;
  margin-bottom:3px;
}
.refresh {
  display:inline-block;
  padding:4px 6px;
  background:#007bff;
  color:#fff;
  text-decoration:none;
  font-size:12px;
  margin-bottom:4px;
}
</style>
</head>

<body>

<a class="refresh" href="index.php">🔄 Refresh</a>

<div class="chat">
<?php
if (file_exists($file)) {
    $lines = file($file);
    $lines = array_slice($lines, -10000000000);
    foreach ($lines as $l) {
        echo "<div class='msg'>".htmlspecialchars($l)."</div>";
    }
} else {
    echo "No messages yet";
}
?>
</div>

<div class="form-box">
<form method="post">
<input type="text" name="user" placeholder="Your name"><br>
<input type="text" name="msg" placeholder="Type message"><br>
<input type="submit" value="Send">
</form>
</div>

</body>
</html>