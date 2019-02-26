<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Make Hash</title>
</head>
<body>
<?php echo sha1(md5($_GET["a"]));?>
</body>
</html>