<?php

session_start();

if(isset($_POST['adminuser']) && isset($_POST['password'])){
    $adminUser = ($_POST['adminUser']);
    $password = ($_POST['password']);
    if(empty($adminUser)){
        die("Empty or invalid AdminUser ");
    }
    if(empty($password)){
        die("Enter your password");
    }

     //database configuration
     require 'vendor/autoload.php'; 
     // Creating Connection  
        $client = new MongoDB\Client("mongodb://localhost:27017");
    // access Database
    if($client)
     {
    $db=$client->foodblog;
     // access Collection
     $coll=$db->admin;
    $data=array("adminUser"=>$adminUser, "password"=>$password);
     $result = $coll->findOne($data);
   if(!empty($result)){
    header('Location:index.php');
      }
   else
    { echo "unsuccessful";
    }

     } else { 
     die("Mongo DB not connected");
     } 
       }
     ?>