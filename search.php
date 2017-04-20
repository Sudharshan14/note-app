<?php
	function search($q) {
		$fq = "src/" . $q . "*.txt";
		$result = glob($fq);
		foreach($result as $filename) {
			echo "<br>" . substr($filename, 4, -4);
		}

	}
	
	$a = $_SERVER['REQUEST_URI'];
	$ll = strlen($a);
	echo $a[$ll-2];
	search("");
?>