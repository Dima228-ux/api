<?php

/**
 * Class BasePdo
 */
class BasePdo
{

    /*Класс*/
    public static $class;

    /*БД*/
    public static $base;

    /**
     * Создание подключения к базе
     *
     * @return object Инициализированный класс
     */
    public static function initial()
    {
        if (!isset(self::$class)) {
            self::$class = new BasePdo();
        }

        self::_configurationBase();

        return self::$class;
    }

    /**
     * Конфигурационные данные к базе
     *
     * @return void
     */
    private static function _configurationBase()
    {
        $pdoAttributes = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        );

        self::$base = new PDO(
            'mysql:host=127.0.0.1:3306;dbname=test_group',
            'root', '', $pdoAttributes
        );
    }

    /**
     * Маршрутизатор запросов к базе
     *
     * @param string $type Тип запроса
     * @param mixed $typeQuery Параметр запроса
     * @param array $placeholder Плэйсхолдер
     *
     * @return string Результат запроса
     */
    public static function queryRoute($typeQuery, $query, $placeholder = array())
    {
        if ($typeQuery == 'insert') {
            if (!empty($placeholder)) {
                $q = self::$base->prepare($query);
                $q->execute($placeholder);
            } else {
                $q = self::$base->prepare($query);
                $q->execute();
            }

            $error = self::$base->errorInfo();
            if ($error[0] != 00000) {
                die;
            }

            return self::$base->lastInsertId();
        } else {
            if ($typeQuery == 'select') {
                if (!empty($placeholder)) {
                    $q = self::$base->prepare($query);
                    $q->execute($placeholder);
                } else {
                    $q = self::$base->prepare($query);
                    $q->execute();
                }

                $error = self::$base->errorInfo();
                if ($error[0] != 00000) {
                    die;
                }

                $q->setFetchMode(PDO::FETCH_ASSOC);
                $listResult = [];
                while ($r = $q->fetch()) {
                    $listResult[] = $r;
                }

                return $listResult;
            } else {
                if ($typeQuery == 'update') {
                    if (!empty($placeholder)) {
                        $q = self::$base->prepare($query);
                        $q->execute($placeholder);
                    } else {
                        $q = self::$base->prepare($query);
                        $q->execute();
                    }

                    $error = self::$base->errorInfo();
                    if ($error[0] != 00000) {
                        die;
                    }
                } else {
                    if ($typeQuery = 'delete') {
                        $q = self::$base->prepare($query);
                        $q->execute();
                    }
                }
            }
        }
    }

    /**
     * метод для посыла нестандартных запросов
     *
     */
    public static function query($query)
    {
        $q = self::$base->prepare($query);
        $q->execute();
    }


}