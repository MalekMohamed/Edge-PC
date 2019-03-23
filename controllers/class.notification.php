<?php
/**
 * Created by PhpStorm.
 * User: Strix
 * Date: 2/12/2019
 * Time: 12:52 AM
 */

class notification extends account
{
    /*
          Notifications Functions
          $user => UserID
          $id => Notification ID
          */
    public function get_notification($user)
    {
        $query = $this->conn->prepare("SELECT * FROM notification WHERE touser = ? ORDER BY id DESC ");
        $query->execute(array($user));
        return array($query->rowCount(), $query->fetchAll());
    }

    public function get_new_notification($user)
    {
        $query = $this->conn->prepare("SELECT * FROM notification WHERE touser = ? AND (Status = ? OR Status = 2) ORDER BY id DESC ");
        $query->execute(array($user, 1));
        return array($query->rowCount(), $query->fetchAll());
    }

    public function get_old_notification($user)
    {
        $query = $this->conn->prepare("SELECT * FROM notification WHERE touser = ? AND Status = ? ORDER BY id DESC ");
        $query->execute(array($user, 0));
        return array($query->rowCount(), $query->fetchAll());
    }

    public function update_notifications($user, $status)
    {
        $query = $this->conn->prepare("UPDATE notification SET Status = ? WHERE touser = ?");
        $query->execute(array($status, $user));
    }

    /* Prevent Notification Duplicate */
    private function check_notification($from, $to, $url)
    {

        $query = $this->conn->prepare("SELECT * FROM notification WHERE ByUser = ? AND touser = ?  AND url = ?");
        $query->execute(array($from, $to, $url));
        $result = $query->rowCount();
        $fetch = $query->fetch();
        return array($result, $fetch);
    }

    public function push_notification($from, $to, $url, $title, $category)
    {
        $date = date($this->Date);
        $check_notifi = $this->check_notification($from, $to, $url);
        if ($check_notifi[0] != 0) {
            $update_old = $this->conn->prepare("UPDATE notification SET Status = ? , title = ? WHERE id = ?");
            $update_old->execute(array(1, $title, $check_notifi[1]['id']));

        } else {
            $query = $this->conn->prepare("INSERT INTO 
                                     notification (
                                     ByUser,
                                     touser, 
                                     url,
                                     title, 
                                     category,
                                     time,
                                     Status
                                     )
                                     Values (
                                     :by,
                                     :to,
                                     :url,
                                     :title,
                                     :cate,
                                     :time,
                                     :status
                                     )");
            $query->execute(array(
                'by' => $from,
                'to' => $to,
                'url' => $url,
                'title' => $title,
                'cate' => $category,
                'time' => $date,
                'status' => 1
            ));
        }
    }

    public function notification_category($category)
    {
        $result = 'fa-globe';
        if ($category == 'like') {
            $result = 'fa-heart';
        } elseif ($category == 'comment') {
            $result = 'fa-comments';
        } elseif ($category == 'follow') {
            $result = 'fa-flag';
        } elseif ($category == 'friend_request') {
            $result = 'fa-user-plus';
        } elseif ($category == 'message') {
            $result = 'fa-envelope-o';
        } elseif ($category == 'post') {
            $result = 'fa-quote-right';
        }
        return $result;
    }
}