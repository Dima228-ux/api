<?php

require_once './models/DbManager.php';
require_once 'Hellpers/Response.php';

/**
 * Class GroupService
 */
class GroupService
{
    private $dbManager;

    /**
     * GroupService constructor.
     */
    public function __construct()
    {
        $this->dbManager = new DbManager();
        BasePdo::initial();
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return Response::i();
    }

    /**
     * @param $id
     * @return array
     */
    public function getUser($id)
    {
        if (!is_numeric($id)) {
            return $this->formedAnswer(Response::BAD_REQUEST, 'Error parameters', 'message');
        }

        if (!$this->dbManager->Users->checkUser($id)) {
            return $this->formedAnswer(Response::NOT_FOUND, 'User not found', 'message');
        }

        $data = $this->dbManager->Users->getUser($id);
        return $this->formedAnswer(Response::STATUS_OK, $data, 'data');
    }

    /**
     * @param $code
     * @param null $data
     * @param null $name
     * @return array
     */
    private function formedAnswer($code, $data = null, $name = null)
    {
        $status = ($code == Response::STATUS_OK) ? 'success' : 'error';
        if ($data == null) {
            return [$code, ['status' => $status]];
        }

        if ($name == null) {
            $name = 'data';
        }

        return [$code, ['status' => $status, $name => $data]];
    }

    /**
     * @return array
     */
    public function getGroups()
    {
        $data = $this->dbManager->Groups->getGroups();
        return $this->formedAnswer(Response::STATUS_OK, $data, 'data');
    }

    /**
     * @param $data
     * @return array
     */
    public function insertUserGroup($data)
    {
        $result = Request::checkRequestGroup($data);

        if (!is_bool($result)) {
            return $this->formedAnswer(Response::BAD_REQUEST, $result, 'message');
        }

        $id_group = $data['id_group'];
        $id_user = $data['id_user'];

        if ($this->dbManager->Users->checkUserGroup($id_group, $id_user)) {
            return $this->formedAnswer(
                Response::BAD_REQUEST,
                'The user with this ID is already a member of the group',
                'message'
            );
        }
        $answer = $this->dbManager->Users->insertUserGroup($id_group, $id_user);
        $code = ($answer) ? Response::STATUS_OK : Response::ERROR_REQUEST;

        return $this->formedAnswer($code);
    }

    /**
     * @param $data
     * @return array
     */
    public function deleteUser($data)
    {
        $result = Request::checkRequestGroup($data);

        if (!is_bool($result)) {
            return $this->formedAnswer(Response::BAD_REQUEST, $result, 'message');
        }

        $id_group = $data['id_group'];
        $id_user = $data['id_user'];

        if (!$this->dbManager->Users->checkUserGroup($id_group, $id_user)) {
            return $this->formedAnswer(
                Response::BAD_REQUEST,
                'The user with this ID is not a member of the group',
                'message'
            );
        }

        $answer = $this->dbManager->Users->deleteUserGroup($id_group, $id_user);
        $code = ($answer) ? Response::STATUS_OK : Response::ERROR_REQUEST;

        return $this->formedAnswer($code);
    }
}