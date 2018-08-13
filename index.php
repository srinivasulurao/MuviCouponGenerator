<?php

//##########################################################
//Include the library
//##########################################################
require_once("MuviCouponGenerator.php");

//##########################################################
//Start Insertion Operation
//##########################################################
try {
    $muvi_coupons_generator = new MuviCouponGenerator();
    $muvi_coupons_generator->insertCouponCodes();
    echo "Coupons Inserted Successfully !";
}
catch(Exception $e){
    echo "Error:".$e->getMessage()." @ ".$e->getLine();
}


?>