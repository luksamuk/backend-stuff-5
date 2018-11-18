<?php

// Este arquivo não tem exatamente propósito algum, e pode ser ignorado.

require "requires.php";

$db = new DB();

echo "Testing DB opening\n";
$db->open();

var_dump($db->fetch("SELECT * FROM users"));

$usr = new User(0, "Lucas Vieira", "alchemist@sdf.org", "Rua...", "12345");
var_dump($usr);

echo "Testing DB closing\n";
$db->close();

?>
