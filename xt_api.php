<?php 
	//----------config-------------//
	//HTTP GET doesn't need ID and KEY - for retrieving data
	//HTTP POST need ID and KEY - for storing data

	$api_id =  'sidX349notE';
	$api_key = '#$Enter14';

	//-----------config-END---------//

	if($_SERVER["REQUEST_METHOD"]=="POST") {
		$data=$_POST["data"];
		$lnk = $_POST["lnk"];
		$passwd = $_POST["pass"];
		
		$appID = $_POST["appID"];
		$appKey = $_POST["appKey"];
		
		
		if(strcmp($appID, $api_id)!=0 OR strcmp($appKey, $api_key)!=0) {
			echo "\n Unautherized app..";
			exit();
		}
			
		
		$fn = "src/" . $lnk . ".txt";	
		$status = "";
		
		if(!empty($data) && !empty($lnk)) {
			postContentManager($fn, $lnk, $passwd, $data);
		}
		
		else {
			echo "00";
		}
		
	}			
	
	else if($_SERVER["REQUEST_METHOD"]=="GET") {
		$lnk=$_GET['lnk'];
		$passwd=$_GET['pass'];
	
		$fn="src/" . $lnk . ".txt";
		
		if(!empty($lnk))
			getContentManager($fn, $lnk, $passwd);
	}		
	
	
//----------------------------Functions------------------------------------//

	function addPasswdEntry($lnk, $passwd)
	{
		// function to add the link_word-password entry in the XML file.
		$xmldoc=new DOMDocument();
 		$xmldoc->load("passwd.xml");
 		$XMLroot=$xmldoc->getElementsByTagName("shribc")->item(0);
 		$XMLpslink=$xmldoc->createElement('pslink');
 		$XMLlnk=$xmldoc->createElement('lnk');
 		$XMLpass=$xmldoc->createElement('passwd');
 		$XMLstrlnk=$xmldoc->createTextNode($lnk);
 		$XMLstrpass=$xmldoc->createTextNode($passwd);
 		$XMLpslink=$XMLroot->appendChild($XMLpslink);
 		$XMLlnk=$XMLpslink->appendChild($XMLlnk);
 		$XMLpass=$XMLpslink->appendChild($XMLpass);
 		$XMLstrlnk=$XMLlnk->appendChild($XMLstrlnk);
 		$XMLstrpass=$XMLpass->appendChild($XMLstrpass);
 		$xmldoc->save("passwd.xml");
	}
	
	function getPasswd($lnk)
	{
		// function returns actual passwd if it exits - otherwise it returns empty string
		$passwd="";
		$xml=simplexml_load_file("passwd.xml");
 			foreach($xml->children() as $itr)
 			{
 				if($itr->lnk==$lnk)
 				{	
 					$passwd= $itr->passwd;
 					break;
 				}
 			}
 		return $passwd;
	}
	
	function getViewMode($lnk)
	{
		// function returns the view-mode of the file
		$vm="";
		$xml=simplexml_load_file("passwd.xml");
 			foreach($xml->children() as $itr)
 			{
 				if($itr->lnk==$lnk)
 				{	
 					$vm= $itr->view_mode;
 					break;
 				}
 			}
 		return $vm;
	}
	
	function getContentManager($file_name, $lnk, $typedPasswd)
	{
		// function checks whether the file exists or not. 
		// If file exists, then gets the actual password, compares it with typed password and takes neccessary action.
		// If file doesn't exit, then creates the file and if password is given, updates the XML.
		
		$status = "";
		$content = "";
		
		
		if(file_exists($file_name))
		{
			$actualPasswd = getPasswd($lnk);
			
			if(empty($typedPasswd) && empty($actualPasswd)) {
				$status = "11";
				$content = file_get_contents($file_name);
			}
			elseif(!empty($typedPasswd) && !empty($actualPasswd)) {
				if($typedPasswd!=$actualPasswd) {
					$status = "10";
				}
				else {
					$status = "11";
					$content = file_get_contents($file_name);
				}
			}
			elseif(empty($typedPasswd) && !empty($actualPasswd))
			{
				$view_mode = getViewMode($lnk);
				if($view_mode=="1")
				{
					$status = "101";
					$content = file_get_contents($file_name);
				}
				else {
				 	$status = "10";
				}
			}
			elseif(!empty($typedPasswd) && empty($actualPasswd))
			{
				addPasswdEntry($lnk, $typedPasswd);
				$status = "11";
				$content = file_get_contents($file_name);
			}
			else {}
		}
		else
 		{
 			$status = "00";
 		}
 		
 		echo $status . "\r\n" . $content;
	}	
	
	
	
	function postContentManager($file_name, $lnk, $typedPasswd, $data) {
		
		$status = "";
		
		$actualPasswd = getPasswd($lnk);
		
		if(empty($typedPasswd) && empty($actualPasswd)) {
			$content = file_put_contents($file_name, $data);
			$status = "11";
		}
		
		elseif(!empty($typedPasswd) && !empty($actualPasswd)) {
			if($typedPasswd!=$actualPasswd) {
				$status = "10";
			}
			else {
				$content = file_put_contents($file_name, $data);
				$status = "11";
			}
		}
		
		elseif(!empty($typedPasswd) && empty($actualPasswd))
		{
			addPasswdEntry($lnk, $typedPasswd);
			$content = file_put_contents($file_name, $data);
			$status = "11";
			
		}
		
 		
		echo $status;
			
	}

//----------------------------END - Functions------------------------------------//
?>