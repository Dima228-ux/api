<?php

/**
 * Class Response
 */
class Response
{

    const STATUS_OK = 200;
    const METHOD_NOT_ALLOWED = 405;
    const NOT_FOUND = 404;
    const BAD_REQUEST = 400;
    const ERROR_REQUEST = 500;

    /**
     * @var static
     */
    protected static $instance;

    /**
     * @return self
     */
    public static function i()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param $data
     * @param int $code
     * @return false|string
     */
    public function formedResponse($data, int $code)
    {
        header('Content-type: application/json');
        http_response_code($code);
        return json_encode($data);
    }
}