<?php



function get($uri="/",$action=null){
    Route::get($uri,$action);
}

function post($uri="/",$action=null){
    Route::post($uri,$action);
}

function delete($uri="/",$action=null){
    Route::delete($uri,$action);
}

function put($uri="/",$action=null){
    Route::put($uri,$action);
}

function controller($uri="/",$action=null){
    Route::controller($uri, $action);
}

function rest($uri="/",$action=null){
    Route::rest($uri,$action);
}

function call(){
    Route::call();
}
