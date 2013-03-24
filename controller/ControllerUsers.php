<?php 
class ControllerUsers extends CuoreController{
	
	function show($page)
    {
		echo "page = " . $page . " | ";
		die(__FUNCTION__);
		
	}
	
	function users()
    {
       $user = new ModelUsers();
       $users = $user->fetchAllAssoc();//$db->fetchAll("select * from users");
       //echo $user->noTotal();
       //$users[1]->name = "Superman";
       //$users[1]->save();
       //CuoreDebug::printr($users);
        
        //$user = ModelUsers::getById(30);
        //echo $user->name;
        SiteView::load('index.tpl', array('users' => $users));
		
	}
}

