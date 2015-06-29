<?php
    require_once "lib/database_class.php";
    require_once "lib/manage_class.php";

    $db = new DataBase();
    $manage = new Manage($db);
    if($_POST["reg"]){
        $r = $manage->regUser();
    }
    elseif($_POST["auth"]){
        $r = $manage->login();
    }
    elseif($_POST["rec"]) {
        $r = $manage->recPass();
    }
    elseif($_GET["logout"]) {
        $r = $manage->logout();
    }
    elseif($_POST["change"]){
        $r = $manage->changepass();
    }
    elseif($_POST["edit"]){
        $r = $manage->edit();
    }
    elseif($_POST["editsection"]){
        $r = $manage->editsection();
    }
    elseif($_POST["editarticle"]){
        $r = $manage->editarticle();
    }
    elseif($_POST["create"]){
        $r = $manage->create();
    }
    elseif($_POST["createsection"]){
        $r = $manage->createsection();
    }
    elseif($_POST["createarticle"]){
        $r = $manage->createarticle();
    }
    elseif($_POST["poll"]) {
        $r = $manage->poll();
    }
    elseif($_POST["comm"]){
        $r = $manage->comment();
    }

    else exit;
    $manage->redirect($r);

?>