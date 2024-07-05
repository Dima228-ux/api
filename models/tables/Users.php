<?php

require_once './models/BasePdo.php';

/**
 * Class Users
 */
class Users
{
    /**
     * @param $id
     * @return bool
     */
    public function checkUser($id)
    {
        $query = "SELECT id FROM `users` WHERE `id`={$id}";
        $result = BasePdo::queryRoute('select', $query);
        if (count($result) > 0) {
            return true;
        }
        return false;
    }

    /**
     * @param $id_group
     * @param $id_user
     * @return bool
     */
    public function insertUserGroup($id_group, $id_user)
    {
        $query = "INSERT INTO `group_users`(`group_id`, `user_id`) VALUES ({$id_group},{$id_user})";
        $result = BasePdo::queryRoute('insert', $query);
        if (is_numeric($result)) {
            return true;
        }

        return false;
    }

    /**
     * @param $id_group
     * @param $id_user
     * @return bool
     */
    public function deleteUserGroup($id_group, $id_user)
    {
        $query = "DELETE FROM `group_users` WHERE `group_id`= {$id_group} AND `user_id` = {$id_user}";
        $result = BasePdo::queryRoute('delete', $query);
        return true;
    }

    /**
     * @param $id_group
     * @param $id_user
     * @return bool
     */
    public function checkUserGroup($id_group, $id_user)
    {
        $query = "SELECT id FROM `group_users` WHERE `group_id`= {$id_group} AND `user_id` = {$id_user}";
        $result = BasePdo::queryRoute('select', $query);

        if (count($result) > 0) {
            return true;
        }
        return false;
    }

    /**
     * @param $id
     * @return array
     */
    public function getUser($id)
    {
        $result = $this->getRightUser($id);
        $query = "SELECT * FROM rights";
        $result_rights = BasePdo::queryRoute('select', $query);
        $rights = [];

        foreach ($result_rights as $right) {
            if (is_array($result)) {
                $key = array_keys(array_combine(array_keys($result), array_column($result, 'id')), $right['id']);
                if (count($key) > 0) {
                    $rights [] = $right['name'] . ': true';
                    continue;
                }
                $rights [] = $right['name'] . ': false';
            } else {
                $rights [] = $right['name'] . ':  false';
            }
        }
        return $rights;
    }

    /**
     * @param $id
     * @return array|string|null
     */
    private function getRightUser($id)
    {
        $query = "SELECT * FROM rights WHERE id IN (SELECT right_id FROM group_rights WHERE group_id IN(SELECT group_id FROM group_users WHERE user_id = {$id}))";
        $result_rights = BasePdo::queryRoute('select', $query);


        $query = "SELECT id FROM rights WHERE id IN (SELECT right_id FROM group_rights WHERE group_id IN(SELECT group_id FROM group_users WHERE user_id = {$id} AND group_id  IN (SELECT id FROM `groups` WHERE type = 'block')))";
        $result_block = BasePdo::queryRoute('select', $query);

        if (count($result_rights) > 0) {
            if (count($result_block) > 0) {
                $rights = [];
                foreach ($result_rights as $value) {
                    $key = array_keys(
                        array_combine(array_keys($result_block), array_column($result_block, 'id')),
                        $value['id']
                    );

                    if (count($key) > 0) {
                        continue;
                    }
                    $rights [] = $value;
                }
                return $rights;
            }
            return $result_rights;
        }

        return null;
    }

}