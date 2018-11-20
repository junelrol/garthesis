<?php
try
{
	$bdd = new PDO('mysql:host=den1.mysql2.gear.host;dbname=garthesis;charset=utf8', 'root', '@garthesis');
	$connect = new PDO('mysql:host=den1.mysql2.gear.host;dbname=garthesis', 'root', '@garthesis');
	$mycon=mysqli_connect("den1.mysql2.gear.host","root","@garthesis","garthesis");
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
