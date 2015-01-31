<?php namespace Monoblock\Datagrids;

use Champion\Utils\Url;
use Datagrid\Datagrid;
use Monoblock\Documents\User;

class UserListDatagrid
{
    /**
     * @var array
     */
    private $users;

    public function __construct($users)
    {
        $this->users = $this->usersToArray($users);
    }

    private function getDatagrid()
    {
        $url = new Url();
        $apiUri = $url->getAppBaseUri();

        $datagrid = new Datagrid();
        $datagrid->setData($this->users);

        $datagrid->setTableClass('table');
        $datagrid->hideColumns(array('id'));

        $datagrid->addHeader(array('Id', 'Name', 'Email'));

        $datagrid->addAction('Edit', $apiUri . '/admin/user/edit/{id}');
        $datagrid->addAction('Delete', $apiUri . '/admin/user/delete/{id}');

        return $datagrid;
    }

    public function __toString()
    {
        return strval($this->getDatagrid());
    }

    private function usersToArray($users)
    {
        $out = array();

        /** @var User $user */
        foreach ($users as $user) {
            $row = array();
            $row['id'] = $user->getUserId();
            $row['name'] = $user->getName();
            $row['email'] = $user->getEmail();

            $out[] = $row;
        }

        return $out;
    }
}
