<?php

require_once 'service/GroupService.php';
require_once 'controllers/Controller.php';

/**
 * Class GroupController
 */
class GroupController extends Controller
{
    /**
     *
     */
    public function index()
    {
        echo json_encode(['status' => 200, 'message' => 'You are welcome to API']);
    }

    public function getUserAction()
    {
        if (!$this->getRequest()->checkMethod("GET")) {
            $data = ['status' => 'error', 'message' => 'Method Not Allowed'];
            echo $this->getResponse()->formedResponse($data, Response::METHOD_NOT_ALLOWED);
            exit();
        }

        $id = $this->getRequest()->getInt('id');
        $data = $this->getGroupService()->getUser($id);
        echo $this->getResponse()->formedResponse($data[1], $data[0]);
    }


    /**
     *
     */
    public function getGroupsAction()
    {
        if (!$this->getRequest()->checkMethod("GET")) {
            $data = ['status' => 'error', 'message' => 'Method Not Allowed'];
            echo $this->getResponse()->formedResponse($data, Response::METHOD_NOT_ALLOWED);
            exit();
        }
        $data = $this->getGroupService()->getGroups();
        echo $this->getResponse()->formedResponse($data[1], $data[0]);
    }

    /**
     *
     */
    public function insertUserAction()
    {
        if (!$this->getRequest()->checkMethod("POST")) {
            $data = ['status' => 'error', 'message' => 'Method Not Allowed'];
            echo $this->getResponse()->formedResponse($data, Response::METHOD_NOT_ALLOWED);
            exit();
        }

        $data = $this->getRequest()->getBodyParams(true);
        $answer = $this->getGroupService()->insertUserGroup($data);
        echo $this->getResponse()->formedResponse($answer[1], $answer[0]);
    }

    /**
     *
     */
    public function deleteUserAction()
    {
        if (!$this->getRequest()->checkMethod("DELETE")) {
            $data = ['status' => 'error', 'message' => 'Method Not Allowed'];
            echo $this->getResponse()->formedResponse($data, Response::METHOD_NOT_ALLOWED);
        }
        $id_user = $this->getRequest()->getInt('id_user');
        $id_group = $this->getRequest()->getInt('id_group');
        $data = ['id_user' => $id_user, 'id_group' => $id_group];


        $data = $this->getGroupService()->deleteUser($data);
        echo $this->getResponse()->formedResponse($data[1], $data[0]);
    }

}