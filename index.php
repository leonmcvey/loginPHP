<?php


require_once ('lib/PageTemplate.php');
require_once "./Models/DatabaseInitializer.php";
require_once "./Models/UserDatabase.php";

require_once "./Models/Database.php";

$database = new Database();
$pdo = $database->getPdo();

$databaseInitializer = new DatabaseInitializer($pdo);
$databaseInitializer->setupUsersTable();





# trick to execute 1st time, but not 2nd so you don't have an inf loop
if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = "My Title";
    $TPL->ContentBody = __FILE__;
    include "layout.php";
    exit;
}



?>
<p>
<div class="row">


    <div class="col-md-4 col-xs-6">
        <div class="shop">
            <div class="shop-img">
                <img src="/img/shop01.png" alt="Beverages" />
            </div>
            <div class="shop-body">
                <h3>Computers<br>Collection</h3>
                <a class="cta-btn" href="">Shop now <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-xs-6">
        <div class="shop">
            <div class="shop-img">
                <img src="/img/shop02.png" alt="Condiments" />
            </div>
            <div class="shop-body">
                <h3>Cameras<br>Collection</h3>
                <a class="cta-btn" href="">Shop now <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-xs-6">
        <div class="shop">
            <div class="shop-img">
                <img src="/img/shop03.png" alt="Confections" />
            </div>
            <div class="shop-body">
                <h3>Sound<br>Collection</h3>
                <a class="cta-btn" href="">Shop now <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
</div>


</p>