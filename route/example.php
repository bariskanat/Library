

<?php
require_once 'class/uri.php';
require_once 'class/request.php';
require_once 'class/route.php';
require_once 'class/router.php';
require_once 'class/response.php';
require_once 'class/func.php';



//--------GET------------------------//
Route::get("task","author.index");
Route::get("task/(any)","author.index");

get("task","author.index");

Route::get("task/(any)",function($name){
    echo "helloo {$name}";
});

get("task/(any)",function($name){
    echo "helloo {$name}";
});

//-----------POST-------------------

Route::post("task","author.create");
Route::post("task/(any)","author.create");
post("task","author.create");

//---------CONTROLLER----------------------------

Route::controller("author");
controller("author");
Route::controller("task","author");
controller("task","author");

//-----------------PUT--------------------

Route::put("task/(any)","author.update");

put("task/(any)","author.update");

//------------DELETE-------------------

Route::delete("task/(any)","author.destroy");

delete("task/(any)","author.destroy");

//-----------------------REST---------------------------

Route::rest("task", "author");
rest("task", "author");


Route::call();

call();








?>


