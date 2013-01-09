<?php 


require_once 'query.php';
require_once 'connection.php';
require_once 'update_builder.php';
require_once 'delete_builder.php';
require_once 'insert_builder.php';
require_once 'select_builder.php';
require_once 'where_builder.php';

//-------query method without json result
Db::query("select * from authors where id = ? ",array(3));
//------query method with json result
Db::query("select * from authors where id = ? ",array(5),true);

//------first method with json result
Db::first("select * from authors",true);
Db::first("select * from authors where id < ?",array(10),true);

//------------first method without json result
Db::first("select * from authors");
Db::first("select * from authors where id < ?",array(10));

//--------------SELECT----------------
Db::open("authors")->select("id,name,lastname")->where("name","=","baris")->or_where("name","=","baris")->get();
Db::open("authors")->where("name","=","baris")->where_notin("id",[1,2,3,4,5])->get();
Db::open("authors")->where_notin("id",[1,2,3,4,5])->get();
Db::open("authors")->group_by("name")->get();
Db::open("authors")->group_by("name")->order_by("id")->get();
Db::open("authors")->select("id,name,lastname")->where("name","=","baris")->order_by("name","desc")->limit(5)->get();
Db::open("authors")->select("id,name,lastname")->where("name","=","baris")->where_in("id",[1,2,3,4,5])->get();
Db::open("authors")->select("id,name,lastname")->where("name","=","baris")->or_where_notin("id",[1,2,3,4,5])->get();
Db::open("authors")->get();
 
//--------------INSERT--------------------
Db::open("authors")->insert(["firstname"=>"baris","lastname"=>"kanat","username"=>"bariskanat"]);



//----------DELETE--------------
Db::open("authors")->delete(5);
Db::open("authors")->delete("name","=","baris");
Db::open("authors")->where("id","<",5)->delete();
Db::open("authors")->where("name","=","baris")->or_where("name","=","ali")->delete();


//--------------UPDATE------------------------------
Db::open("authors")->update(5,["firstname"=>"baris","lastname"=>"kanat"]);
Db::open("authors")->where("id","=",9)->update(["firstname"=>"bariskanat"]);



?>
