<?php
try
{
	//$bdd = new PDO('mysql:host=localhost;dbname=gart;charset=utf8', 'root', '');
	$mycon=mysqli_connect("den1.mysql2.gear.host","root","@garthesis","garthesis");
	$connect = new PDO('mysql:host=den1.mysql2.gear.host;dbname=garthesis', 'root', '@garthesis');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
