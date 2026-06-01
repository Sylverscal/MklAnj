<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

include_once $_SERVER['DOCUMENT_ROOT'] . "/classes/CLA_inclusions.php";

$i = new CLA_inclusions();
$i->inclut();

$is = new LIB_infos_systeme();
$is->affiche();

