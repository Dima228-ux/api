<?php

/**
 * Class Groups
 */
class Groups
{
    /**
     * @return array|null
     */
    public function getGroups()
    {
        $query = "SELECT groups.id,groups.name as `group`,rights.name as `right` FROM group_rights JOIN `groups` ON groups.id = group_rights.group_id JOIN rights ON rights.id = group_rights.right_id";
        $select_rights = BasePdo::queryRoute('select', $query);
        $query = "SELECT * FROM `groups`";
        $select_groups = BasePdo::queryRoute('select', $query);

        return $this->formedGroups($select_rights, $select_groups);
    }

    /**
     * @param $select_rights
     * @param $select_groups
     * @return array|null
     */
    private function formedGroups($select_rights, $select_groups)
    {
        $groups = [];

        if (count($select_groups) < 1) {
            return null;
        }

        if (count($select_groups) < 1) {
            foreach ($select_groups as $group) {
                $groups [] = $group ['name'];
            }
            return $groups;
        }
        $rights = [];
        $name = $select_groups[0]['name'];

        foreach ($select_groups as $group) {
            if ($name !== $group['name']) {
                $groups[$name] = $rights;
                $name = $group['name'];
                $rights = [];
            }
            $keys = array_keys(
                array_combine(array_keys($select_rights), array_column($select_rights, 'id')),
                $group['id']
            );
            if (count($keys) > 0) {
                foreach ($keys as $key) {
                    $rights [] = $select_rights[$key]['right'];
                }
            }
        }
        $groups[$name] = $rights;

        return $groups;
    }

    /**
     * @param $id
     * @return bool
     */
    public function checkGroup($id)
    {
        $query = "SELECT id FROM `groups` WHERE `id`={$id}";
        $result = BasePdo::queryRoute('select', $query);
        if (count($result) > 0) {
            return true;
        }
        return false;
    }

}