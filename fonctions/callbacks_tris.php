<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

function comparaisonAscendante(mixed $a,mixed $b) {
    $val_a = $a->getValeurDeColonne(LIB_Table_s::$tablonne_tri);
    $val_b = $b->getValeurDeColonne(LIB_Table_s::$tablonne_tri);

    return strcmp($val_a, $val_b);
}

function comparaisonDescendante(mixed $a,mixed $b) {
    $val_a = $a->getValeurDeColonne(LIB_Table_s::$tablonne_tri);
    $val_b = $b->getValeurDeColonne(LIB_Table_s::$tablonne_tri);

    return strcmp($val_b, $val_a);
}
