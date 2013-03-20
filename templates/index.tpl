<?php SiteView::cache('header.tpl');?>
<h2>2 Content of user ID: <?php //echo $user->id ;?></h2>
<?php
foreach($users as $k=>$user) {
    if ($user->id%11 == 0) {
        unset($users[$k]);
    }
}
;?>
<?php 
SiteView::cache('footer.tpl', array("users" => $users));
?>
