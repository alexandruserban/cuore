<?php
class ControllerDefault extends CuoreController {
    function main() {
        SiteView::assign('users', CuoreDb::fetchAllAsooc("select * from users", 'id'));
        SiteView::assign('test', 'TEST');
        SiteView::load('index.tpl');
    }
}

 