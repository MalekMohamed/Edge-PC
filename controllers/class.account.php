<?php

/**
 * Created by PhpStorm.
 * User: Legacy
 * Date: 7/15/2018
 * Time: 1:20 PM
 */
class account extends Store
{
    public static function State($user, $rate)
    {
        if ($rate >= 3 ) {
            return '<span data-toggle="tooltip" data-placement="right" data-original-title="Trusted" data-rate="'.$rate.'" class="text-primary">' . $user . ' <i class="fa fa-check-square"></i></span>';
        } else {
            return $user;
        }
        /*switch ($state) {
            case 0:
                return $user;
                break;
            case 1:
                return '<span data-toggle="tooltip" data-placement="right" data-original-title="Trusted" class="text-primary">' . $user . ' <i class="fa fa-check-square"></i></span>';
                break;
            case 2:
                return '<span data-toggle="tooltip" data-placement="right" data-original-title="Admin" class="text-danger">' . $user . ' <i class="fa fa-user-secret"></i></span>';
                break;
            case 3:
                return '<span data-toggle="tooltip" data-placement="right" data-original-title="Moderator" class="text-success">' . $user . ' <i class="fa fa-user-secret"></i></span>';
                break;
        }*/
    }

    public function get_user($username)
    {
        $query = $this->select('accounts', '*', array('Username = ?'), $username);
        $user = array('Data' => $query->fetch(), 'Count' => $query->rowCount());
        $arr['user'] = $username;
        $ads = $this->get_items($arr)[0];

        return array('ads' => $ads, 'User' => $user);
    }

    public function addUser($data)
    {
        $data['Last_Login'] = date($this->Date);
        $query = $this->conn->prepare("INSERT INTO accounts (Username,Password,Email,Mobile,Country,Last_Login) VALUES (:Username,:Password,:Email,:Mobile,:Country,:Last_Login)");
        $query->execute($data);
    }

    public function check_user_data($username, $password = null, $email = null)
    {
        $check_user = $this->get_user($username)['User']['Count'];
        if ($password != null) {
            $query = $this->select('accounts', '*', array('Password = ?'), $password);
            $response['password_check'] = $query->rowCount();
        }
        if ($email != null) {
            $query = $this->select('accounts', '*', array('Email = ?'), $email);
            $response['email_check'] = $query->rowCount();
        }
        $response['user_check'] = $check_user[1];
        return $response;
    }

    public function getUserByID($id)
    {
        $query = $this->select('accounts', '*', array('id = ?'), $id);
        return $query->fetch();
    }
    public function getUsers()
    {
        $query = $this->select('accounts', '*', '','');
        return $query->fetchAll();
    }

    public function changepassword($username, $newpassword)
    {
        $query = $this->conn->prepare("UPDATE accounts SET Password = ? WHERE Username = ?");
        $query->execute(array($newpassword, $username));
        return true;
    }
}