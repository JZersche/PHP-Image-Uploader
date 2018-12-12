<?php

$host = 'localhost'; 
$dbname = 'database'; 
$charset = 'utf8'; 
$options = [
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		   ];

try {
$dbconn = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", 'root', '', $options);
?> 

<!-- Begin HTML -->
<span id="span1" style="color: #0f0; margin-bottom: 25px; display:block;">
	 Connected to 
	<?php echo $dbname; ?>
</span>
<!-- End HTML -->

<!-- Resume PHP -->
<?php
}
catch(Exception $e) {
	echo ('The Exception code is '.$e->getCode().'<br />');
	echo ('The Exception message is '.$e->getMessage());
}
?>
<!-- End PHP -->