<html>
<head>
<title>Instant note taking and sharing app..</title>
<link href="css/pschg_styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="header">
	<div class="logo">
	</div>
</div>
<?php
if($_SERVER['REQUEST_METHOD']=="POST") {
	

	$vm = $_POST['view-mode'];
	$ln = $_POST['lnk_wrd'];
	
	$xmldoc=new DOMDocument();
	$xmldoc->load("passwd.xml");
	$root=$xmldoc->getElementsByTagName("shribc")->item(0);
	foreach($root->getElementsByTagName("pslink") as $itr)
	{
		$lnk=$itr->getElementsByTagName("lnk")->item(0);
		$view_mode=$itr->getElementsByTagName("view_mode")->item(0);
		if($lnk->nodeValue == $ln)
		{
			$view_mode->nodeValue = $vm;
			break;
		}
	}
	$xmldoc->save("passwd.xml");
	echo "<h3>Done..!</h3><p>View of your node has been successfully changed..!<br>
	Close this window to access the note taking window.";
	exit();
}
?>
</body>
</html>