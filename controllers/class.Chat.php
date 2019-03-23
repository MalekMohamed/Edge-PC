<?php

class Chat extends notification
{
    public function get_user_messages($userid, $with, $ad)
    {
        $query = $this->conn->prepare("SELECT * FROM user_chat WHERE users_in_chat = ? AND ad_id = ? ORDER BY id ASC");
        $query->execute(array($userid . ',' . $with, $ad));


        return array($query->rowCount(), $query->fetchAll());
    }

    protected function get_message($from, $to)
    {
        $query = $this->conn->prepare("SELECT id,users_in_chat,userID FROM user_chat WHERE users_in_chat = ? ORDER BY id ASC");
        $query->execute(array($from . ',' . $to));


        return array($query->rowCount(), $query->fetch());
    }

    public function messages($from)
    {
        $query = $this->conn->prepare("SELECT ad_id,chat_with,userID,id,message,date FROM user_chat WHERE userID = ? OR chat_with = ? GROUP BY chat_with,userID,ad_id ORDER BY id DESC");
        $query->execute(array($from, $from));
        return array($query->rowCount(), $query->fetchAll());
    }

    protected function send_message($from, $to, $ad, $msg)
    {
        $check_old_messages = $this->get_message($to, $from);
        if ($check_old_messages[0] != 0) {
            // Old Messages Found
            $users_in_chat = $check_old_messages[1]['users_in_chat'];
        } else {
            $users_in_chat = $from . ',' . $to;
        }
        $date = date($this->Date);
        $sender = $this->getUserByID($from);
        $receiver = $this->getUserByID($to);
        $this->push_notification($sender['Username'], $receiver['Username'], $this->BASE_URL('account/messenger/' . numhash($ad) . '-' . $sender['Username']), $sender['Username'] . ' : ' . $msg, 'message');
        $query = $this->conn->prepare("INSERT INTO user_chat (userID , chat_with,ad_id , users_in_chat , date , message) VALUES (:from , :to,:ad ,:users , :date , :msg)");
        $query->execute(array(
            'from' => $from,
            'to' => $to,
            'ad' => $ad,
            'users' => $users_in_chat,
            'date' => $date,
            'msg' => $msg
        ));
    }

    public function get_time_stamp($date_given)
    {
        $date = new DateTime(str_replace('/', '-', $date_given));
        $time_stamp_given = $date->getTimeStamp();
        $time_stamp = time() - $time_stamp_given;
        $mirco_sec = array('hours' => 3600, 'minutes' => 60, 'seconds' => 1);
        $time_in_hours = $time_stamp / $mirco_sec['hours'];
        $time_in_minutes = $time_stamp / $mirco_sec['minutes'];
        $time_in_seconds = $time_stamp / $mirco_sec['seconds'];
        return array('hours' => intval($time_in_hours), 'minutes' => intval($time_in_minutes), 'seconds' => intval($time_in_seconds));
    }

    public function get_post_time($date_given)
    {

        $time_in_hours = $this->get_time_stamp($date_given)['hours'];
        $time_in_mints = $this->get_time_stamp($date_given)['minutes'];
        $time_in_sec = $this->get_time_stamp($date_given)['seconds'];
        $post_time = $date_given;
        if ($time_in_sec <= 60) {
            $post_time = $time_in_sec . ' Second Ago';
        } elseif ($time_in_mints <= 60) {
            $post_time = $time_in_mints . ' Minutes Ago';
        } elseif ($time_in_sec >= 60 && $time_in_mints >= 60 && $time_in_hours <= 23) {
            $post_time = $time_in_hours . ' Hours Ago';
        } elseif ($time_in_hours >= 23) {
            $new_date = new DateTime(str_replace('/', '-', $date_given));
            $post_time = $new_date->format($this->Date);

        }
        return $post_time;
    }

}