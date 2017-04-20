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
if($_SERVER['REQUEST_METHOD']=="POST")
	{
		$f=0;
		
		$old_ps = $_POST['old_ps'];
		$new_ps = $_POST['new_ps'];
		$renew_ps = $_POST['renew_ps'];
		$ln = $_POST['lnk_wrd'];
		$rem_ps = $_POST['rem_ps'];
		$view_mode = $_POST['view-mode'];
		
		if(!empty($rem_ps))
		{
			$xml=simplexml_load_file("passwd.xml");
 			foreach($xml->children() as $itr)
 			{
 				if($itr->lnk==$ln && $itr->passwd==$rem_ps)
 				{
 				$f=1;
 				break;
 				}
 			}
 			if($f==0)
 			{
 				echo "<h3>Error</h3><p>Incorrect password.. Close this window and try again..!</p>";
				exit();
 			}
 			else if($f==1)
 			{
			$xmldoc=new DOMDocument();
			$xmldoc->load("passwd.xml");
			$root=$xmldoc->getElementsByTagName('shribc')->item(0);
			$arr_rec = $root->getElementsByTagName('pslink');
			foreach($arr_rec as $itr)
			{
				if($itr->getElementsByTagName('lnk')->item(0)->nodeValue == $ln)
				{
					$root->removeChild($itr);
					break;				
				}
				
			}
			$xmldoc->save("passwd.xml");
			echo "<h3>Done..!</h3><p>Password has been successfully removed.<br>
 			Close this window and just type in the URL of your browser<br><b>www.xtnote.com/<i>your_link_word</i></b><br></p>";
 			exit();
			
			}
			
		}
		
		if($new_ps!=$renew_ps)
		{
			echo "<h3>Error</h3><p>Password doesn't match.. Close this window and try again..!</p>";
			exit();
		}
		if(empty($old_ps) && empty($rem_ps))
		{
			$xmldoc=new DOMDocument();
 			$xmldoc->load("passwd.xml");
 			$root=$xmldoc->getElementsByTagName("shribc")->item(0);
 			$pslink=$xmldoc->createElement('pslink');
 			$lnk=$xmldoc->createElement('lnk');
 			$pass=$xmldoc->createElement('passwd');
 			$vm = $xmldoc->createElement('view_mode');
 			$strlnk=$xmldoc->createTextNode($ln);
 			$strpass=$xmldoc->createTextNode($new_ps);
 			if(empty($view_mode))
 				$strvm=$xmldoc->createTextNode('0');
			else
				$strvm=$xmldoc->createTextNode('1');
 			$pslink=$root->appendChild($pslink);
 			$lnk=$pslink->appendChild($lnk);
 			$pass=$pslink->appendChild($pass);
 			$vm = $pslink->appendChild($vm);
 			$strlnk=$lnk->appendChild($strlnk);
 			$strpass=$pass->appendChild($strpass);
 			$strvm=$vm->appendChild($strvm);
 			$xmldoc->save("passwd.xml");
 			echo "<h3>Done..!</h3><p>Password has been successfully assigned to your note.<br>
 			Close this window and type <b>?p=<i>ur_password</i></b> along with the link word.<br>
 			For help see the 'How to use' part of the home page.</p>";
 			exit();		
		}
		else if(!empty($old_ps))
		{
			$xml=simplexml_load_file("passwd.xml");
 			foreach($xml->children() as $itr)
 			{
 				if($itr->lnk==$ln && $itr->passwd==$old_ps)
 				{
 				$f=1;
 				break;
 				}
 			}
 			if($f==0)
 			{
 				echo "<h3>Error</h3><p>Incorrect old password.. Close this window and try again..!</p>";
				exit();
 			}
 			else if($f==1)
 			{
 				$xmldoc=new DOMDocument();
 				$xmldoc->load("passwd.xml");
 				$root=$xmldoc->getElementsByTagName("shribc")->item(0);
 				foreach($root->getElementsByTagName("pslink") as $itr)
 				{
 					$lnk=$itr->getElementsByTagName("lnk")->item(0);
 					$ps=$itr->getElementsByTagName("passwd")->item(0);
 					if($lnk->nodeValue == $ln)
 					{
 						$ps->nodeValue = $new_ps;
 						break;
 					}
 				}
 				$xmldoc->save("passwd.xml");
 				echo "<h3>Done..!</h3><p>Password has been successfully changed..!<br>
 				Close this window and type <b>?p=<i>new_password</i></b> along with the link word.<br>
 				For help see the 'How to use' part of the home page.</p>";
 				exit();
 			}
 			exit();
 				
		}	
	}
?>
</body>
</html>