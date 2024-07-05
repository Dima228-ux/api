<?php

require_once 'Hellpers/Request.php';
require_once 'Hellpers/Response.php';

/**
 * Class Controller
 */
abstract class Controller
{
    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return Request::i();
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return Response::i();
    }

    /**
     * @return GroupService
     */
    public function getGroupService()
    {
        return new GroupService();
    }
}