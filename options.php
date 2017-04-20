<html>
<head>
<title>Instant note taking and sharing app..</title>
<link href="css/help_styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="header">
	<div class="logo">
	</div>
</div>
<?php
	$ln=$_GET['lnk'];
	$f=0;
	$xml=simplexml_load_file("passwd.xml");
 			foreach($xml->children() as $itr)
 			{
 				if($itr->lnk==$ln)
 				{
 					$f=1;
 					break;
 				}
 			}
 				
 	if($f==0)
 	{
 	echo "<div class='form'><form name='psset_form' method='post' action='ps_chg.php'>
 	<h3 style='text-align: left;'>Set password</h3>
	<input type='hidden' name='lnk_wrd' value='" . $_GET['lnk'] . "' />
	<h5>New Password</h5><input type='password' id='pss_new_ps' name='new_ps' /><br>
	<h5>Confirm Password</h5><input type='password' id='pss_renew_ps' name='renew_ps' /><br><br>
	<input type='checkbox' name='view-mode' value='1'/>Allow others to read the content [Read-Only mode]<br><br>
	<button onclick='pss_save()'>Save</button>
	</form></div>";
 	}
 	else if($f==1)
 	{
 	
 	echo "<div class='form'><form name='viewchg_form' method='post' action='vw_chg.php'>
 	<h3 style='text-align: left;'>Change the view</h3>
	<input type='hidden' name='lnk_wrd' value='" . $_GET['lnk'] . "' />
	<input type='radio' name='view-mode' value='1'/>Allow others to read the content [Read-Only mode]<br>
	<input type='radio' name='view-mode' value='0' default />Do not allow others to read the content<br><br>	
	<button type='submit'>Change</button>
	</form></div>";
 	
 	echo "<div class='form'><form name='pschg_form' method='post' action='ps_chg.php'>
 	<h3 style='text-align: left;'>Change the password</h3>
	<input type='hidden' name='lnk_wrd' value='" . $_GET['lnk'] . "' />
	<h5>Old Password</h5><input type='password' id='psc_old_ps' name='old_ps' /><br>
	<h5>New Password</h5><input type='password' id='psc_new_ps' name='new_ps' /><br>
	<h5>Confirm Password</h5><input type='password' id='psc_renew_ps' name='renew_ps' /><br><br>
	<button onclick='psc_save()'>Change</button>
	</form></div>";
	
	echo "<div class='form'><form name='psrem_form' method='post' action='ps_chg.php'>
	<h3 style='text-align: left;'>Remove password</h3>	
	<input type='hidden' name='lnk_wrd' value='" . $_GET['lnk'] . "' />
	<h5>Password</h5><input type='password' id='psr_rem_ps' name='rem_ps' /><br><br>
	<button onclick='psr_save()'>Remove</button>
	</form></div>";
	
 	}


?>
</body>

<script>
function psc_save()
{
	var ps1 = document.getElementById('pss_new_ps').value;
	document.pschg_form.submit();
}

function pss_save()
{
	var ps1 = document.getElementById('pss_new_ps').value;
	var ps2 = document.getElementById('pss_renew_ps').value;
	if(ps1 && ps2) {
		document.psset_form.submit();
		return true;
	}
	else { return false; }
}

function psr_save()
{
  document.psrem_form.submit();
}
</script>
</html>