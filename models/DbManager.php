<?php

require_once './models/tables/Users.php';
require_once './models/tables/Groups.php';

/**
 * Class DbManager
 */
class DbManager
{
    public $Users;
    public $Groups;

    /**
     * DbManager constructor.
     * @param $Users
     * @param $Groups
     */
    public function __construct()
    {
        $this->Users = new Users();
        $this->Groups = new Groups();
    }
}