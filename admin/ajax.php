<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action=="add_room")
{
	$saveRoom=$crud->saveRoom();
	echo $saveRoom;
}
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == 'update_account'){
	$save = $crud->update_account();
	if($save)
		echo $save;
}
if($action == "save_settings"){
	$save = $crud->save_settings();
	if($save)
		echo $save;
}
if($action == "save_category"){
	$save = $crud->save_category();
	if($save)
		echo $save;
}

if($action == "delete_category"){
	$delete = $crud->delete_category();
	if($delete)
		echo $delete;
}
if($action == "save_transmission"){
	$save = $crud->save_transmission();
	if($save)
		echo $save;
}
if($action == "delete_transmission"){
	$save = $crud->delete_transmission();
	if($save)
		echo $save;
}

if($action == "save_engine"){
	$save = $crud->save_engine();
	if($save)
		echo $save;
}
if($action == "delete_engine"){
	$save = $crud->delete_engine();
	if($save)
		echo $save;
}
if($action == "save_apartment"){
	$save = $crud->save_apartment();
	if($save)
		echo $save;
}
if($action == "delete_car"){
	$save = $crud->delete_car();
	if($save)
		echo $save;
}

if($action == "save_book"){
	$save = $crud->save_book();
	if($save)
		echo $save;
}
if($action == "delete_book"){
	$save = $crud->delete_book();
	if($save)
		echo $save;

}

if($action == "get_booked_details"){
	$save = $crud->get_booked_details();
	if($save)
		echo $save;
}
if($action == "save_movement"){
	$save = $crud->save_movement();
	if($save)
		echo $save;
}
if($action == "delete_movement"){
	$save = $crud->delete_movement();
	if($save)
		echo $save;
}	
if($action == "participate"){
	$save = $crud->participate();
	if($save)
		echo $save;
}
if($action == "get_venue_report"){
	$get = $crud->get_venue_report();
	if($get)
		echo $get;
}
if($action == "save_art_fs"){
	$save = $crud->save_art_fs();
	if($save)
		echo $save;
}
if($action == "delete_art_fs"){
	$save = $crud->delete_art_fs();
	if($save)
		echo $save;
}
if($action == "get_pdetails"){
	$get = $crud->get_pdetails();
	if($get)
		echo $get;
}
ob_end_flush();
?>
