<?php

/**
 * Class Request
 */
class Request
{
    const METHOD_GET = 1;

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
     * @return bool|string
     */
    public static function checkRequestGroup($data)
    {
        $dbManager = new DbManager();

        if (!$data || count($data) != 2) {
            return 'Error data';
        }

        if (!array_key_exists('id_user', $data) || !array_key_exists('id_group', $data)) {
            return 'Error data';
        }

        if (!is_numeric($data['id_user']) || !is_numeric($data['id_group'])) {
            return 'Error parameters';
        }

        if (!$dbManager->Users->checkUser($data['id_user'])) {
            return 'User with this id does not exist';
        }

        if (!$dbManager->Groups->checkGroup($data['id_group'])) {
            return 'Group with this id does not exist';
        }

        return true;
    }

    /**
     * @param      $key
     * @param null $default_value
     * @param null $max_value
     *
     * @return int|null
     */
    public function getInt($key, $default_value = null, $max_value = null)
    {
        return $this->getParamInt($key, self::METHOD_GET, $default_value, $max_value);
    }

    /**
     * @param string $key
     * @param int $source
     * @param mixed|null $default_value
     * @param null|int $max_value максимальное значение
     *
     * @return int|null
     */
    protected function getParamInt($key, $source = self::METHOD_GET, $default_value = null)
    {
        $value = $this->getParam($key, $default_value);

        if (!is_numeric($value)) {
            return $default_value;
        }

        return $value;
    }

    /**
     * @param string $key
     * @param mixed|null $default_value
     *
     * @return mixed|null
     */
    protected function getParam($key, $default_value = null)
    {
        $value = isset($_GET[$key]) ? $_GET[$key] : $default_value;
        if (!is_string($value) || $value === '') {
            return $default_value;
        }
        return $value;
    }

    /**
     * @param $method
     * @return bool
     */
    public function checkMethod($method)
    {
        if ($_SERVER['REQUEST_METHOD'] == $method) {
            return true;
        }
        return false;
    }

    /**
     * @info получает массив из body x-www-form-url-encoded & row
     * @return false|mixed
     */
    public function getBodyParams($post = false)
    {
        $body = json_decode(file_get_contents('php://input'), true);

        if ($body == null && !$post) {
            parse_str(file_get_contents("php://input"), $body);
            if ($body == null) {
                return false;
            }
            return $body;
        } elseif ($post && $body == null) {
            $body = $_POST;
            if ($body == null) {
                parse_str(file_get_contents("php://input"), $body);
                if ($body == null) {
                    return false;
                }
                return $body;
            }
            return $body;
        }
        return $body;
    }

}