<html>
<head>
<title>Instant note taking and sharing app..</title>
<link href="css/opps_styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="header">
	<div class="logo">
	</div>
</div>
<?php
if($_GET['error']=="101")
{
	echo "<h3>Oops..!</h3><p><b>Error:</b> The only allowed special character is <b> - </b></p>";
}
if($_GET['error']=="102")
{
	echo "<h3>Oops..!</h3><p><b>Error:</b> Only <b>?p=</b> expression is allowed.</p>";
	
}
if($_GET['error']=="103" || $_GET['error']=="104")
{
	if($_GET['error']=="103")
	{	
		echo "<h3>Oops..!</h3><p>This link is password protected. Type your password..</p>";
	}
	if($_GET['error']=="104")
	{	
		echo "<h3>Oops..!</h3><p>Wrong password. Please enter the correct password..!</p>";
	}
	$html="<div class='form'><form name='passwd_form'><input type='password' id='ps' name='passwd' /><button onclick='redirect()'>Open</button></form></div>";
	echo $html;
}
?>

</body>

<script type="text/javascript">
function redirect()
{
	var x = document.forms["passwd_form"]["passwd"].value;
	if (x == null || x == "") {
        	alert("Type the passwd and click the botton");
    	}
    	else
    	{
    		var y = '<?php echo $_GET['lnk']; ?>';	
    		x = "http://xtnote.com/" + y + "?p=" + x; 
    		window.location = x;
    	}
      
}
document.getElementById('ps').onkeypress = function(e) {
    if (!e) e = window.event;
    var keyCode = e.keyCode || e.which;
    if (keyCode == '13')
    {
      redirect();
      return false;
    }
  }
</script>
</html>