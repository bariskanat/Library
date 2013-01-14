

<?php
require_once 'class/uri.php';
require_once 'class/request.php';
require_once 'class/route.php';
require_once 'class/router.php';
require_once 'class/response.php';
require_once 'class/func.php';



//--------GET------------------------//


get("task","author.index");


get("task/(any)",function($name){
    echo "helloo {$name}";
});

//-----------POST-------------------


post("task","author.create");
post("task/(any)","author.create");

//---------CONTROLLER----------------------------


controller("author");

controller("task","author");

//-----------------PUT--------------------



put("task/(any)","author.update");

//------------DELETE-------------------



delete("task/(any)","author.destroy");

//-----------------------REST---------------------------


rest("task", "author");



call();








?>


