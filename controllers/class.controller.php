<?php

/**
 * Created by PhpStorm.
 * User: Legacy
 * Date: 10/11/2017
 * Time: 4:02 PM
 */
spl_autoload_register(function ($name) {
    require 'class.' . $name . '.php';
});
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

class controller extends Chat
{
    private static $AllowedTypes = array('jpg', 'png', 'jpeg');
    private $request;
    private $response = array();


    public function __construct()
    {
        parent::__construct();
        $this->request = filter_var($_GET['request'], FILTER_SANITIZE_STRING);
        if (isset($this->request)) {
            switch ($this->request) {
                case 'createuser':
                    $this->create_account();
                    break;
                case 'resetpass':
                    $this->resetpassword();
                    break;
                case 'login':
                    $this->login();
                    break;
                case 'change-password':
                    $this->change_password();
                    break;
                case 'getUser':
                    $this->getUser();
                    break;
                case 'edit-user':
                    $this->editUser();
                    break;
                case 'sort':
                    $this->sorting();
                    break;
                case 'add-item':
                    $this->add_item();
                    break;
                case 'item':
                    $this->get_item();
                    break;
                case 'edit-item':
                    $this->save_item();
                    break;
                case 'report':
                    $this->report_item();
                    break;
                case 'search':
                    $this->search();
                    break;
                case 'remove-item':
                    $this->remove_item();
                    break;
                case 'approve-item':
                    $this->approve();
                    break;
                case 'decline-item':
                    $this->decline();
                    break;
                case 'add_msg':
                    $this->send_msg();
                    break;
                case 'get_msgs':
                    $this->get_new_msgs();
                    break;
                case 'update_new_msgs':
                    $this->update_new_msgs();
                    break;
                case "update_notification":
                    $this->update_notification();
                    break;
                case "get_last_notification":
                    $this->get_last_notification();
                    break;
                case "Page":
                    $this->paging();
                    break;
                case "changeTheme":
                    $this->ChangeTheme();
                    break;
                case "brands":
                    $this->CategoryBrands();
                    break;
                case "rate":
                    $this->rate();
                    break;
            }
        } else {
            die();
        }
    }

    public function ItemRates($id)
    {
        $query = $this->conn->prepare("SELECT * FROM rates WHERE item = ?");
        $query->execute(array($id));
        $total = 0;
        foreach ($query->fetchAll() as $value) {
            $total = $value['value'] + $total;
        }
        $calcuate = $total / $query->rowCount();
        return floor($calcuate);
    }
    public function UserRates($id)
    {
        $query = $this->conn->prepare("SELECT * FROM rates WHERE seller = ?");
        $query->execute(array($id));
        $total = 0;
        foreach ($query->fetchAll() as $value) {
            $total = $value['value'] + $total;
        }
        $calcuate = $total / $query->rowCount();
        return floor($calcuate);
    }

    private function rate()
    {
        session_start();
        if (isset($_SESSION['account'])) {
            $data['id'] = filter_var(numhash($_POST['item']), FILTER_SANITIZE_NUMBER_INT);
            $value = filter_var($_POST['value'], FILTER_SANITIZE_NUMBER_INT);
            $item = $this->get_items($data)[0];
            $check_rate = $this->conn->prepare("SELECT * FROM rates WHERE user = ? AND item = ?");
            $check_rate->execute(array($_SESSION['account'], $data['id']));
            if (empty($item)) {
                $this->response['msg'] = 'Item not found';
                $this->response['status'] = 'error';
            } elseif (empty($value)) {
                $this->response['msg'] = 'Select the stars first';
                $this->response['status'] = 'error';
            } elseif ($check_rate->rowCount() != 0) {
                $query = $this->conn->prepare('UPDATE rates SET value = ? WHERE id = ?');
                $query->execute(array($value, $check_rate->fetch()['id']));
                $this->response['msg'] = 'Thanks for your rate';
                $this->response['status'] = 'success';
            } else {
                $query = $this->conn->prepare("INSERT INTO rates (user,item,value,seller) VALUES (:user,:item,:value,:seller)");
                $query->execute(array(
                    'user' => $_SESSION['account'],
                    'item' => $data['id'],
                    'value' => $value,
                    'seller' => $item['User']
                ));
                $this->response['msg'] = 'Thanks for your rate';
                $this->response['status'] = 'success';
            }
            $this->response['msg'] = 'You must be logged in to do this action';
            $this->response['status'] = 'error';
        }
        echo json_encode($this->response);
    }

    public function updateReport($id, $status)
    {
        session_start();
        if (isset($_SESSION['Staff'])) {
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
            $status = filter_var($status, FILTER_SANITIZE_NUMBER_INT);
            $query = $this->conn->prepare("UPDATE reports SET status = ? WHERE id = ?");
            $query->execute(array($status, $id));
            return $query->rowCount();
        }
    }

    public function getReports($type, $Id = null)
    {
        session_start();
        if (isset($_SESSION['Staff'])) {
            $Id = filter_var(numhash($Id), FILTER_SANITIZE_NUMBER_INT);
            if ($type == 'All') {
                $query = $this->conn->prepare("SELECT * FROM reports WHERE status = ?");
                $query->execute(array($Id));
                return $query->fetchAll();
            } elseif ($type == 'Item' && !empty($Id)) {

                $query = $this->conn->prepare("SELECT * FROM reports WHERE item = ?");
                $query->execute(array($Id));
                return $query->fetchAll();
            }
        }
    }

    private function CategoryBrands()
    {
        $cate = filter_var($_POST['cate'], FILTER_SANITIZE_STRING);
        if (in_array($cate, Store::$category_array)) {
            $cateData = Store::$category_data[$cate];
            if ($cate == 'Others') {
                $cateData['Brands'] = Store::$Brands;
            }
        } else {
            $cateData['Brands'] = Store::$Brands;
        }
        echo json_encode($cateData);
    }

    private function getUser()
    {
        session_start();
        if (isset($_SESSION['Staff'])) {
            $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
            $user = $this->getUserByID($id);
            if (!empty($user)) {
                echo json_encode($user);
            } else {
                $this->response['status'] = 'error';
                $this->response['msg'] = 'User not found.';
                echo json_encode($this->response);
            }
        }
    }

    private function editUser()
    {
        session_start();
        if (isset($_SESSION['Staff'])) {
            $data['id'] = filter_var($_POST['user']['id'], FILTER_SANITIZE_NUMBER_INT);
            $data['Username'] = filter_var($_POST['user']['Username'], FILTER_SANITIZE_STRING);
            $data['Password'] = filter_var($_POST['user']['Password'], FILTER_SANITIZE_STRING);
            $data['Email'] = filter_var($_POST['user']['Email'], FILTER_SANITIZE_EMAIL);
            $data['Country'] = filter_var($_POST['user']['Country'], FILTER_SANITIZE_STRING);
            $data['Mobile'] = filter_var($_POST['user']['Mobile'], FILTER_SANITIZE_STRING);
            $data['State'] = filter_var($_POST['user']['State'], FILTER_SANITIZE_STRING);
            $user = $this->getUserByID($data['id']);
            if (empty($user)) {
                $this->response['status'] = 'error';
                $this->response['msg'] = 'User not found.';
            } else {
                $query = $this->conn->prepare("UPDATE accounts SET Username = ? , Password = ? , Email = ? , Mobile = ? , Country = ? , State = ? WHERE id = ?");
                if ($query->execute(array($data['Username'], $data['Password'], $data['Email'], $data['Mobile'], $data['Country'], $data['State'], $data['id']))) {
                    $this->response['status'] = 'success';
                    $this->response['msg'] = 'User data updated successfully.';
                } else {
                    $this->response['status'] = 'error';
                    $this->response['msg'] = 'Something went wrong. ' . var_dump($data);
                }
            }
        }
        echo json_encode($this->response);
    }

    private function decline()
    {
        session_start();
        if (isset($_SESSION['Staff'])) {
            $data['id'] = filter_var(numhash($_POST['id']), FILTER_SANITIZE_NUMBER_INT);
            $reason = nl2br(filter_var($_POST['reason'], FILTER_SANITIZE_STRING));
            if (!empty($reason)) {
                $query = $this->conn->prepare("UPDATE store SET reason = ? WHERE ID = ?");
                $query->execute(array($reason, $data['id']));
                if ($this->Updateitem($data['id'], 4) == true) {
                    $this->response['status'] = 'success';
                    $this->response['msg'] = 'Item Updated successfully';
                }
            } else {
                $this->response['status'] = 'error';
                $this->response['msg'] = 'Please enter the reason.';
            }
            echo json_encode($this->response);
        }
    }

    private function approve()
    {
        session_start();
        if (isset($_SESSION['Staff'])) {
            $data['id'] = filter_var(numhash($_POST['id']), FILTER_SANITIZE_NUMBER_INT);
            if ($this->Updateitem($data['id'], 1) == true) {
                $this->response['status'] = 'success';
                $this->response['msg'] = 'Item Updated successfully';
            }
            echo json_encode($this->response);
        }
    }

    private function ChangeTheme()
    {
        $color = filter_var($_POST['Color'], FILTER_SANITIZE_STRING);
        setcookie('theme', $color, time() + (86400 * 30), "/");
    }

    private function paging()
    {
        $data = $_POST['request'];
        $data['Status'] = 0;
        if (empty($data['cate']) && empty($data['brand'])) {
            $data = $_POST['page'];
        } else {
            $data['page'] = $_POST['page'];
        }
        $items = $this->get_items($data);
        foreach ($items as $key => $item) {
            if ($items[$key]['Status'] != 0 && $items[$key]['Status'] != 3) {
                $img = '../public/uploads/images/' . numhash($items[$key]['ID']) . '/' . explode('-', $items[$key]['images'])[0];
                if (!file_exists($img)) {
                    $items[$key]['images'] = $this->BASE_URL('public/uploads/images/no-thumbnail.png');
                } else {
                    $items[$key]['images'] = $this->BASE_URL('public/uploads/images/' . numhash($items[$key]['ID']) . '/' . explode('-', $items[$key]['images'])[0]);
                }
                $items[$key]['link'] = $this->BASE_URL('Products/' . numhash($item['ID']));
                $items[$key]['Status'] = Store::status($item['Status']);
            }
        }
        echo json_encode($items);
    }

    /* Notifications Functions */

    private function update_notification()
    {
        session_start();
        if (!isset($_SESSION['account'])) {
            $this->response['status'] = 'error';
            $this->response['msg'] = 'Please Login first';
        } else {
            $this->response['status'] = 'success';
            $this->response['msg'] = '';
            $this->update_notifications($_SESSION['account'], 0);
        }
        echo json_encode($this->response);
    }

    private function get_last_notification()
    {
        session_start();
        $query = $this->conn->prepare("SELECT * FROM notification WHERE touser = ? AND Status = ? ORDER BY time");
        $query->execute(array($_SESSION['account'], 1));
        foreach ($query->fetchAll() as $notification) {
            if ($notification['Status'] == 1) {
                $query = $this->conn->prepare("UPDATE notification SET Status = ? WHERE id = ?");
                $query->execute(array(2, $notification['id']));
            }
        }
        echo json_encode(array('data' => $query->fetchAll(), 'number' => $query->rowCount(), 'status' => 'white'));

    }

    private function send_msg()
    {
        $sender = filter_var($_POST['sender'], FILTER_SANITIZE_STRING);
        $receiver = filter_var($_POST['receiver'], FILTER_SANITIZE_STRING);
        $msg = filter_var($_POST['msg'], FILTER_SANITIZE_STRING);
        $id = numhash(filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));
        $date = $this->get_post_time(date($this->Date));
        session_start();
        if (!isset($_SESSION['account'])) {
            $this->response['status'] = 'error';
            $this->response['msg'] = 'Please login first';
        } elseif (empty($receiver)) {
            $this->response['status'] = 'error';
            $this->response['msg'] = 'User not found<br>';
        } elseif (empty($msg)) {
            $this->response['status'] = 'error';
            $this->response['msg'] = 'Please Enter your Message';
        } elseif ($sender == $receiver) {
            $this->response['status'] = 'error';
            $this->response['msg'] = 'you can`t send Messages to your self';
        } else {
            $this->response['status'] = 'success';
            $this->response['date'] = $date;
            $this->send_message($sender, $receiver, $id, $msg);
        }
        echo json_encode($this->response);

    }

    private function get_new_msgs()
    {
        $sender = filter_var($_POST['sender'], FILTER_SANITIZE_STRING);
        $receiver = filter_var($_POST['receiver'], FILTER_SANITIZE_STRING);
        $check_old_messages = $this->get_message($receiver, $sender);
        if ($check_old_messages[0] != 0) {
            // Old Messages Found
            $users_in_chat = $check_old_messages[1]['users_in_chat'];
        } else {
            $users_in_chat = $sender . ',' . $receiver;
        }
        $query = $this->conn->prepare("SELECT * FROM user_chat WHERE users_in_chat = ? AND status = ?");
        $query->execute(array($users_in_chat, 0));
        echo json_encode(array('data' => $query->fetchAll(), 'number' => $query->rowCount(), 'status' => 'white'));


    }

    private function update_new_msgs()
    {
        $sender = filter_var($_POST['sender'], FILTER_SANITIZE_STRING);
        $receiver = filter_var($_POST['receiver'], FILTER_SANITIZE_STRING);
        $check_old_messages = $this->get_message($receiver, $sender);
        if ($check_old_messages[0] != 0) {
            // Old Messages Found
            $users_in_chat = $check_old_messages[1]['users_in_chat'];
        } else {
            $users_in_chat = $sender . ',' . $receiver;
        }
        $query = $this->conn->prepare("UPDATE user_chat SET Status = ? WHERE users_in_chat = ?");
        $query->execute(array(1, $users_in_chat));
    }

    private function report_item()
    {
        session_start();
        if (isset($_SESSION['account'])) {
            $data['id'] = filter_var(numhash($_POST['id']), FILTER_SANITIZE_NUMBER_INT);
            $reason = filter_var($_POST['reason'], FILTER_SANITIZE_STRING);
            $text = filter_var($_POST['reason_text'], FILTER_SANITIZE_STRING);
            $item = $this->get_items($data)[0];
            if (empty($item)) {
                $this->response['msg'] = 'Item not found';
                $this->response['status'] = 'error';
                $this->response['field'] = '#reason_text';
            } elseif (empty($text)) {
                $this->response['msg'] = 'Please write your comment on this item';
                $this->response['status'] = 'error';
                $this->response['field'] = '#reason_text';
            } else {
                $query = $this->conn->prepare("INSERT INTO reports (item,category,reason,date) VALUES (:item,:cate,:reason,:date)");
                if ($query->execute(array('item' => $data['id'], 'cate' => $reason, 'reason' => $text, 'date' => date($this->Date)))) {
                    $this->response['status'] = 'success';
                    $this->response['msg'] = 'Thanks for your report, we will look into it ASAP';
                } else {
                    $this->response['msg'] = 'Something went wrong';
                    $this->response['status'] = 'error';
                }
            }
        } else {
            $this->response['msg'] = 'You must be logged in to Do this action';
            $this->response['status'] = 'error';
        }
        echo json_encode($this->response);
    }

    private function save_item()
    {
        session_start();
        if (isset($_SESSION['account'])) {
            $data['id'] = filter_var(numhash($_POST['id']), FILTER_SANITIZE_NUMBER_INT);
            $data['Name'] = filter_var($_POST['Name'], FILTER_SANITIZE_STRING);
            $data['Category'] = filter_var($_POST['Category'], FILTER_SANITIZE_STRING);
            $data['Brand'] = filter_var($_POST['Brand'], FILTER_SANITIZE_STRING);
            $data['Price'] = filter_var($_POST['Price'], FILTER_SANITIZE_NUMBER_INT);
            $data['Status'] = filter_var($_POST['Status'], FILTER_SANITIZE_NUMBER_INT);
            $data['Cond'] = filter_var($_POST['Cond'], FILTER_SANITIZE_STRING);
            $data['Description'] = nl2br(filter_var($_POST['Description'], FILTER_SANITIZE_STRING));
            $data['Date'] = date($this->Date);
            $item['id'] = $data['id'];
            $item_data = $this->get_items($item)[0];
            $data['images'] = $item_data['images'];
            if ($item_data['Status'] == 4 || $item_data['Status'] == 3) {
                $data['Status'] = $item_data['Status'];
            }
            $images = '';
            $upload = true;
            if (empty($item_data)) {
                $this->response['msg'] = 'Item not found';
                $this->response['status'] = 'error';
            } else {
                if (empty($data['Name']) || empty($data['Category']) || empty($data['Brand']) || empty($data['Price']) || empty($data['Cond']) || empty($data['Description'])) {
                    $this->response['status'] = 'error';
                    $this->response['msg'] = 'All fields are required';
                } elseif ($item_data['Status'] == 3 || $item_data['Status'] == 4) {
                    $this->response['status'] = 'error';
                    $this->response['msg'] = 'You can\'t edit this item ';

                } elseif (empty(reArrayFiles($_FILES['reimages']))) {
                    $img_desc = reArrayFiles($_FILES['reimages']);
                    if (count($img_desc) > 4) {
                        $this->response['status'] = 'error';
                        $this->response['msg'] = 'Max images to upload is 4';
                    } else {
                        $target = '../public/uploads/images/' . numhash($data['id']) . '/';
                        $files = glob($target . '/*');
                        foreach ($files as $file) {
                            //Make sure that this is a file and not a directory.
                            if (is_file($file)) {
                                //Use the unlink function to delete the file.
                                unlink($file);
                            }
                        }
                        foreach ($img_desc as $val) {
                            $type = explode('.', $val['name']);
                            $newname = generateRandomString(12) . '.' . $type[1];
                            $images .= $newname . '-';
                            if ($val['size'] > 2097152) {
                                $upload = false;
                                $this->response['status'] = 'error';
                                $this->response['msg'] = $val['name'] . ' File size must be less than 2 MB';
                            } else {
                                if (in_array($type[1], self::$AllowedTypes)) {
                                    move_uploaded_file($val['tmp_name'], $target . $newname);
                                    $upload = true;
                                } else {
                                    $upload = false;
                                    $this->response['status'] = 'error';
                                    $this->response['msg'] = 'Uploaded files is not images';
                                }
                            }
                        }
                    }
                }
                if ($upload == true) {
                    $query = $this->conn->prepare("UPDATE store SET Name = ? , Category = ? , Brand = ? , Price = ? , Cond = ? , Description = ? , Date = ? , Status = ? , images = ? WHERE ID = ?");
                    if ($query->execute(array($data['Name'], $data['Category'], $data['Brand'], $data['Price'], $data['Cond'], $data['Description'], $data['Date'], $data['Status'], $images, $item['id']))) {
                        $this->response['status'] = 'success';
                        $this->response['msg'] = 'Item edited successfully';
                    } else {
                        $this->response['status'] = 'error';
                        $this->response['msg'] = 'Something went wrong';
                    }
                }
            }

        } else {
            $this->response['msg'] = 'You must be logged in to Do this action';
            $this->response['status'] = 'error';
        }
        echo json_encode($this->response);
    }

    private function get_item()
    {
        session_start();
        if (isset($_SESSION['account'])) {
            $item['id'] = filter_var(numhash($_POST['id']), FILTER_SANITIZE_NUMBER_INT);
            $item_data = $this->get_items($item)[0];
            if (empty($item_data)) {
                $this->response['status'] = 'error';
                $this->response['msg'] = 'Item not found';
            } else {
                $item_data['State'] = strip_tags(Store::status($item_data['Status']));
                $item_data['ID'] = numhash($item_data['ID']);
                $this->response['Data'] = $item_data;
            }
        } else {
            $this->response['msg'] = 'You must be logged in to Do this action';
            $this->response['status'] = 'error';
        }
        echo json_encode($this->response);
    }

    public function search()
    {
        $data = filter_var(htmlentities(strip_tags($_POST['search'])), FILTER_SANITIZE_STRING);
        $arr = explode(' ', $data);
        $items = array();
        if (in_array('SSD', $arr) || in_array('ssd', $arr) || in_array('Ssd', $arr) || in_array('drive', $arr) || in_array('Drive', $arr)) {
            array_push($arr, 'Solid state drive');
        } elseif (in_array('Solid state drive', $arr) || in_array('solid state drive', $arr) || in_array('solid', $arr) | in_array('Solid', $arr) || in_array('state', $arr) || in_array('State', $arr)) {
            array_push($arr, 'SSD');
        }
        if (in_array('Hard disk', $arr) || in_array('disk', $arr) || in_array('hard', $arr) || in_array('drive', $arr) || in_array('Drive', $arr)) {
            array_push($arr, 'HDD');
        } elseif (in_array('HDD', $arr) || in_array('hdd', $arr) || in_array('Hdd', $arr)) {
            array_push($arr, 'Hard disk');
        }
        $i = 0;

        foreach ($arr as $data) {
            if ($data != '') {
                $q = $this->conn->query("SELECT * FROM store WHERE Name LIKE '%$data%' OR extData LIKE '%$data%' AND Status != 4  AND Status != 3 AND Status != 0 ORDER BY Date");
                $dat = $q->fetchAll();
                foreach ($dat as $key => $item) {
                    if (!empty($dat[$key]['Name'])) {
                        $dat[$key]['original'] = $dat[$key]['Name'];
                        $patterns = array(
                            $data,
                            strtolower($data),
                            strtoupper($data),
                        );
                        $dat[$key]['Name'] = str_replace($patterns, "<span class=\"text-danger\">$data</span>", $dat[$key]['Name']);
                        $img = '../public/uploads/images/' . numhash($dat[$key]['ID']) . '/' . explode('-', $dat[$key]['images'])[0];
                        if (!file_exists($img)) {
                            $dat[$key]['images'] = $this->BASE_URL('public/uploads/images/no-thumbnail.png');
                        } else {
                            $dat[$key]['images'] = $this->BASE_URL('public/uploads/images/' . numhash($dat[$key]['ID']) . '/' . explode('-', $dat[$key]['images'])[0]);
                        }
                        $dat[$key]['link'] = $this->BASE_URL('Products/' . numhash($dat[$key]['ID']));
                        $dat[$key]['Status'] = Store::status($dat[$key]['Status']);
                    }

                }
                $items[$i] = $dat;
                $i++;
            }
        }
        $merged = call_user_func_array('array_merge', $items);

        $i = 0;
        foreach ($items as $value) {
            if (!empty($value)) {
                $merged = array_unique(array_merge($items[0], $items[$i]), SORT_REGULAR);
            }
            $i++;
        }

        if (empty($merged)) {
            $this->response['status'] = 'error';
            $this->response['msg'] = 'No Data found';
        } else {

            $this->response['status'] = 'success';
            $this->response['data'] = array_unique($merged, SORT_REGULAR);

        }
        echo json_encode($this->response);

    }

    private function remove_item()
    {
        session_start();
        if (isset($_SESSION['account'])) {
            $item['id'] = filter_var(numhash($_POST['id']), FILTER_SANITIZE_NUMBER_INT);
            $item_data = $this->get_items($item);
            if (empty($item_data)) {
                $this->response['msg'] = 'Item not found';
                $this->response['status'] = 'error';
            } else {
                $change = $this->Updateitem($item['id'], 3);
                if (isset($change)) {
                    $this->response['msg'] = 'Item Removed';
                    $this->response['status'] = 'success';
                } else {
                    $this->response['msg'] = 'Something went wrong';
                    $this->response['status'] = 'error';
                }
            }
        } else {
            $this->response['msg'] = 'You must be logged in to Do this action';
            $this->response['status'] = 'error';
        }
        echo json_encode($this->response);
    }

    private function sorting()
    {

        $data['sort'] = filter_var($_POST['sort'], FILTER_SANITIZE_STRING);
        $data['cate'] = filter_var($_POST['cate'], FILTER_SANITIZE_STRING);
        $data['brand'] = filter_var($_POST['brand'], FILTER_SANITIZE_STRING);
        $data['Status'] = 3;
        $items = $this->get_items($data);
        foreach ($items as $key => $item) {
            if ($items[$key]['Status'] != 0 && $items[$key]['Status'] != 3) {
                $img = '../public/uploads/images/' . numhash($items[$key]['ID']) . '/' . explode('-', $items[$key]['images'])[0];
                if (!file_exists($img)) {
                    $items[$key]['images'] = $this->BASE_URL('public/uploads/images/no-thumbnail.png');
                } else {
                    $items[$key]['images'] = $this->BASE_URL('public/uploads/images/' . numhash($items[$key]['ID']) . '/' . explode('-', $items[$key]['images'])[0]);
                }
                $items[$key]['link'] = $this->BASE_URL('Products/' . numhash($item['ID']));
                $items[$key]['Status'] = Store::status($item['Status']);
            }
        }
        $error = '';
        if (empty($data['sort'])) {
            $this->response['msg'] = 'Select sorting type';
            $this->response['status'] = 'error';
            $error .= '1';
        }
        if (empty($error)) {
            $this->response = $items;
        }
        echo json_encode($this->response);
    }

    private function add_item()
    {
        session_start();
        if (isset($_SESSION['account'])) {
            $upload = false;
            $data['Name'] = filter_var($_POST['Name'], FILTER_SANITIZE_STRING);
            $data['Category'] = filter_var($_POST['Category'], FILTER_SANITIZE_STRING);
            $data['Brand'] = filter_var($_POST['Brands'], FILTER_SANITIZE_STRING);
            $data['Price'] = filter_var($_POST['Price'], FILTER_SANITIZE_NUMBER_INT);
            $data['Cond'] = filter_var($_POST['Cond'], FILTER_SANITIZE_STRING);
            $data['Description'] = nl2br(filter_var($_POST['Description'], FILTER_SANITIZE_STRING));
            $data['User'] = $_SESSION['account'];
            $data['extData'] = filter_var($_POST['extData'], FILTER_SANITIZE_STRING);
            $data['Date'] = date($this->Date);
            $last = $this->conn->query("SHOW TABLE STATUS LIKE 'store'");
            $lastid = $last->fetch(PDO::FETCH_ASSOC)['Auto_increment'];
            if (empty($data['Name']) || empty($data['Category']) || empty($data['Brand']) || empty($data['Price']) || empty($data['Cond']) || empty($data['Description'])) {
                $this->response['status'] = 'error';
                $this->response['msg'] = 'All fields are required';
            } elseif (empty($_FILES['images'])) {
                $this->response['status'] = 'error';
                $upload = false;
                $this->response['msg'] = 'Please Upload at least 1 Real Image of the product';
            } else {
                $target = '../public/uploads/images/' . numhash($lastid) . '/';
                mkdir($target);
                $img_desc = reArrayFiles($_FILES['images']);
                foreach ($img_desc as $val) {
                    $type = explode('.', $val['name']);
                    $newname = generateRandomString(12) . '.' . $type[1];
                    $data['images'] .= $newname . '-';
                    if ($val['size'] > 2097152) {
                        $upload = false;
                        $this->response['status'] = 'error';
                        $this->response['msg'] = $val['name'] . ' File size must be less than 2 MB';
                    } else {
                        if (in_array($type[1], self::$AllowedTypes)) {
                            move_uploaded_file($val['tmp_name'], $target . $newname);
                            $upload = true;
                        } else {
                            $upload = false;
                            $this->response['status'] = 'error';
                            $this->response['msg'] = 'Uploaded files is not images';
                        }
                    }
                }
                if ($upload == true) {
                    if ($this->Additem($data)) {
                        $this->response['status'] = 'success';
                        $this->response['msg'] = 'Item Added';
                    } else {
                        $this->response['status'] = 'error';
                        $this->response['msg'] = 'Something went Wrong';
                    }
                } else {
                    $this->response['status'] = 'error';
                    $this->response['msg'] = 'Upload Failed';
                }
            }
        } else {
            $this->response['msg'] = 'You must be logged in to Do this function';
            $this->response['status'] = 'error';
            $this->response['field'] = 'All';
        }

        echo json_encode($this->response);
    }

    private function change_password()
    {
        $current_password = filter_var($_POST['oldPassword'], FILTER_SANITIZE_STRING);
        $new = filter_var($_POST['NewPassword'], FILTER_SANITIZE_STRING);
        session_start();
        $check = $this->check_user_data($_SESSION['account'], $current_password, null);
        if (empty($new) || empty($current_password)) {
            $this->response['status'] = 'error';
            $this->response['msg'] = 'All fields are required';
            $this->response['field'] = 'All';
        } elseif ($check['password_check'] != 1) {
            $this->response['status'] = 'error';
            $this->response['msg'] = 'Incorrect Password';
            $this->response['field'] = '#oldPassword';
        } elseif ($current_password == $new) {
            $this->response['status'] = 'error';
            $this->response['msg'] = 'New password and Current password can`t be the same';
            $this->response['field'] = '#Newpassword';
        } else {
            $this->changepassword($_SESSION['account'], $new);
            $this->response['status'] = 'success';
            $this->response['msg'] = 'Your Password has been changed Successfully';
        }
        echo json_encode($this->response);
    }

    private function change_email()
    {
        $password = filter_var($_POST['Password'], FILTER_SANITIZE_STRING);
        $current_email = filter_var($_POST['Email'], FILTER_SANITIZE_EMAIL);
        $new = filter_var($_POST['NewEmail'], FILTER_SANITIZE_EMAIL);
        session_start();
        $check = $this->check_user_data($_SESSION['account'], $password, $current_email);
        if (empty($new) || empty($current_email) || empty($password)) {
            $this->response['status'] = 'error';
            $this->response['msg'] = 'All fields are required';
            $this->response['field'] = 'All';
        } elseif ($check['password_check'] != 1) {
            $this->response['status'] = 'error';
            $this->response['msg'] = 'Incorrect Password';
            $this->response['field'] = '#register_email_password';
        } elseif ($check['email_check'] != 1) {
            $this->response['status'] = 'error';
            $this->response['msg'] = 'Incorrect Email';
            $this->response['field'] = '#register_email';
        } elseif ($current_email == $new) {
            $this->response['status'] = 'error';
            $this->response['msg'] = 'New Email and Current Email can`t be the same';
            $this->response['field'] = '#register_new_email';
        } else {
            $this->changeemail($_SESSION['account'], $new);
            $this->response['status'] = 'success';
            $this->response['msg'] = 'Your Email has been changed Successfully';
        }
        echo json_encode($this->response);
    }

    public function reset_password($username, $email)
    {
        require 'PHPMailer/PHPMailerAutoload.php';
        $password = $this->get_user($username)['User']['Data']['Password'];
        $token = sha1($username . time() . $password) . dechex(time()) . dechex($username);
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; // or 587
        $mail->smtpConnect(
            array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                    "allow_self_signed" => true
                )
            )
        );
        $mail->IsHTML(true);
        $mail->Username = $this->gmail['email'];
        $mail->Password = $this->gmail['password'];
        $mail->SetFrom($this->siteName . ' - Support');
        $mail->Subject = $this->siteName . ' - Password Reset';
        $mail->Body = '	
        <style>
    /* -------------------------------------
      GLOBAL RESETS
  ------------------------------------- */

    img {
        border: none;
        -ms-interpolation-mode: bicubic;
        max-width: 100%;
    }

    body {
        /* background-color: #868b8c; */
        font-family: \'Open Sans\', sans-serif;
        -webkit-font-smoothing: antialiased;
        font-size: 15px;
        line-height: 1.6;
        margin: 0;
        padding: 0;
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%;
    }

    table {
        border-collapse: separate;
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
        width: 100%;
    }

    table td {
        font-family: \'Open Sans\', sans-serif;
        font-size: 15px;
        vertical-align: top;
    }
    /* -------------------------------------
      BODY & CONTAINER
  ------------------------------------- */

    .body {
        /* background-color: #868b8c; */
        color: #ffffff;
        width: 100%;
    }
    /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */

    .container {
        display: block;
        Margin: 0 auto !important;
        /* makes it centered */
        max-width: 400px;
        padding: 10px;
        width: 400px;
    }
    /* This should also be a block element, so that it will fill 100% of the .container */

    .content {
        box-sizing: border-box;
        display: block;
        Margin: 0 auto;
        max-width: 400px;
        /*padding: 10px;*/
    }
    /* -------------------------------------
      HEADER, FOOTER, MAIN
  ------------------------------------- */

    .main {
        background: #3B474A;
        border: 1px solid #232B2C;
        border-radius: 3px;
        width: 100%;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2)
    }

    .wrapper {
        box-sizing: border-box;
        padding: 20px;
    }

    .footer {
        clear: both;
        padding-top: 10px;
        width: 100%;
    }

    .footer td,
    .footer p,
    .footer span,
    .footer a {
        color: #3b474a;
        font-weight: bold;
        font-size: 12px;
        padding-left: 10px;
        padding-right: 10px;
    }
    /* -------------------------------------
      TYPOGRAPHY
  ------------------------------------- */

    h1,
    h2,
    h3,
    h4 {
        color: #ffffff;
        font-family: \'Open Sans\', sans-serif;
        font-weight: 400;
        line-height: 1.5;
        margin: 0;
        Margin-bottom: 30px;
    }

    h1 {
        font-size: 35px;
        font-weight: 300;
        text-align: center;
        text-transform: capitalize;
    }

    p,
    ul,
    ol {
        font-family: \'Open Sans\', sans-serif;
        font-size: 15px;
        font-weight: normal;
        margin: 0;
        Margin-bottom: 15px;
    }

    p li,
    ul li,
    ol li {
        list-style-position: inside;
        margin-left: 5px;
    }

    a {
        color: #00bbc9;
        text-decoration: underline;
    }
    /* -------------------------------------
      BUTTONS
  ------------------------------------- */

    .btn {
        box-sizing: border-box;
        width: 100%;
    }

    .btn>tbody>tr>td {
        padding-bottom: 15px;
    }

    .btn table {
        width: 100%;
    }

    .btn table td {
        background-color: #ffffff;
        border-radius: 3px;
        text-align: center;
    }

    .btn a,
    .btn a:hover {
        background-color: #00bbc9;
        border: solid 1px #00a8b5;
        border-radius: 3px;
        box-sizing: border-box;
        color: #f2f3f2;
        cursor: pointer;
        display: inline-block;
        font-size: 15px;
        margin: 0;
        padding: 10px 15px;
        text-decoration: none;
        text-transform: capitalize;
        width: 100%;
    }

    .btn-primary table td {
        background-color: #00bbc9;
    }

    .btn-primary a {
        background-color: #00bbc9;
        border-color: #00a8b5;
        color: #f2f3f2;
    }
    /* -------------------------------------
      OTHER STYLES THAT MIGHT BE USEFUL
  ------------------------------------- */

    .last {
        margin-bottom: 0;
    }

    .first {
        margin-top: 0;
    }

    .align-center {
        text-align: center;
    }

    .align-right {
        text-align: right;
    }

    .align-left {
        text-align: left;
    }

    .clear {
        clear: both;
    }

    .mt0 {
        margin-top: 0;
    }

    .mb0 {
        margin-bottom: 0;
    }

    .logo {
        text-align: center;
        padding: 20px;
    }

    .preheader {
        color: transparent;
        display: none;
        height: 0;
        max-height: 0;
        max-width: 0;
        opacity: 0;
        overflow: hidden;
        mso-hide: all;
        visibility: hidden;
        width: 0;
    }
    /* -------------------------------------
      RESPONSIVE AND MOBILE FRIENDLY STYLES
  ------------------------------------- */

    @media only screen and (max-width: 620px) {
        table[class=body] h1 {
            font-size: 28px !important;
            margin-bottom: 10px !important;
        }
        table[class=body] p,
        table[class=body] ul,
        table[class=body] ol,
        table[class=body] td,
        table[class=body] span,
        table[class=body] a {
            font-size: 16px !important;
        }
        table[class=body] .wrapper,
        table[class=body] .article {
            padding: 10px !important;
        }
        table[class=body] .content {
            padding: 0 !important;
        }
        table[class=body] .container {
            padding: 0 !important;
            width: 100% !important;
        }
        table[class=body] .main {
            border-left-width: 0 !important;
            border-radius: 0 !important;
            border-right-width: 0 !important;
        }
        table[class=body] .btn table {
            width: 100% !important;
        }
        table[class=body] .btn a {
            width: 100% !important;
        }
        table[class=body] .img-responsive {
            height: auto !important;
            max-width: 100% !important;
            width: auto !important;
        }
    }
    /* -------------------------------------
      PRESERVE THESE STYLES IN THE HEAD
  ------------------------------------- */

    @media all {
        .ExternalClass {
            width: 100%;
        }
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
            line-height: 100%;
        }
        .apple-link a {
            color: inherit !important;
            font-family: inherit !important;
            font-size: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            text-decoration: none !important;
        }
        .btn-primary table td:hover {
            background-color: #00bbc9 !important;
        }
        .btn-primary a:hover {
            background-color: #00bbc9 !important;
            border-color: #00a8b5 !important;
        }
    }
</style><table border="0" cellpadding="0" cellspacing="0" class="body">
    <tr>
        <td>&nbsp;</td>
        <td class="container">
            <div class="content">

                <!-- START CENTERED WHITE CONTAINER -->
               
                <table class="main">

                    <!-- START MAIN CONTENT AREA -->
                    <tr>
                        <td></td>
                        <td width="400" class="wrapper">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <p style="color:#FFFFFF">Reset your password?</p>
                                        <p style="color:#FFFFFF">If you requested a password reset for ' . $username . ', click the button below. If you didn\'t make this request, ignore this email.</p>
                                        <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <table border="0" cellpadding="0" cellspacing="0">
                                                        <tbody>
                                                        <tr>
                                                            <td> <a href="' . $this->BASE_URL('account/reset/' . $token) . '" target="_blank">Reset password</a> </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <p style="color:#FFFFFF">Getting a lot of password reset emails?
You can change your <a href="' . $this->BASE_URL('account/settings') . '" >account settings</a> to require personal information to reset your password.
</p>
                                        <p style="color:#FFFFFF">Thanks,Your friends at ' . $this->siteName . '.</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td></td>
                    </tr>

                    <!-- END MAIN CONTENT AREA -->
                </table>

                <!-- START FOOTER -->
                <div class="footer">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="left" class="content-block">
                                <span class="apple-link">+02 011 5018 8676 </span>
                            </td>
                            <td align="right" class="content-block">
                                <span class="apple-link">' . $this->gmail['email'] . '</span>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- END FOOTER -->

                <!-- END CENTERED WHITE CONTAINER -->
            </div>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>';
        $mail->AddAddress($email);
        if ($mail->send()) {
            $length = strlen($email) / 2;
            $response['msg'] = 'Your Password has been sent to ' . substr($email, 0, $length) . ' [ ' . preg_replace("|.|", "*", $length) . ' ] Please check Junk/Spam if not in Inbox.';
            $response['status'] = 'success';
        } else {
            $response['msg'] = 'Error sending your email, please contact an admin.';
            $response['field'] = 'All';
            $response['status'] = 'error';
        }
        return $this->response;
    }

    private function resetpassword()
    {
        $email = filter_var($_POST['Email'], FILTER_SANITIZE_EMAIL);
        $check_email = $this->conn->prepare("SELECT Email,Username FROM accounts WHERE Email = ?");
        $check_email->execute(array($email));
        $data = $check_email->fetch();
        if ($check_email->rowCount() != 1) {
            $this->response['status'] = 'error';
            $this->response['msg'] = 'Email not found';
            $this->response['field'] = '#reset_email';
        } else {
            if ($this->reset_password($data['Username'], $email)['status']) {
                $this->response['status'] = 'success';
                $this->response['msg'] = 'Email sent to ' . $data['Username'] . ' .Please check your inbox and Spam messages';
            } else {
                $response['msg'] = 'Error sending your email, please contact an admin.';
                $response['field'] = 'All';
                $response['status'] = 'error';
            }
        }
        echo json_encode($this->response);
    }

    private function create_account()
    {
        $data['Username'] = filter_var($_POST['Username'], FILTER_SANITIZE_STRING);
        $data['Password'] = filter_var($_POST['Password'], FILTER_SANITIZE_STRING);
        $data['Email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $data['Country'] = filter_var($_POST['Country'], FILTER_SANITIZE_STRING);
        $data['Mobile'] = filter_var($_POST['Mobile'], FILTER_SANITIZE_STRING);
        if (!empty($data['Password']) && !empty($data['Username']) && !empty($data['Email']) && !empty($data['Country']) && !empty($data['Mobile'])) {
            $user = $this->Object($this->get_user($data['Username']));
            $check_email = $this->select('accounts', '*', array('Email = ?'), $data['Email']);
            if (!preg_match("/^([0-9a-zA-Z]+)$/", $data['Password'])) {
                $this->response['msg'] = 'Password Only letters from A-a to Z-z and numbers, length of 3 to 32 characters';
                $this->response['status'] = 'error';
                $this->response['field'] = '#register_password';
            } elseif (!preg_match("/^([0-9a-zA-Z]+)$/", $data['Username'])) {
                $this->response['msg'] = 'Username Only letters from A-a to Z-z and numbers, length of 3 to 32 characters';
                $this->response['status'] = 'error';
                $this->response['field'] = '#register_username';
            } elseif ($user->User['Count'] != 0) {
                $this->response['msg'] = 'Username already taken. Please choose another one';
                $this->response['status'] = 'error';
                $this->response['field'] = '#register_username';
            } elseif ($check_email->rowCount() != 0) {
                $this->response['msg'] = 'Email already taken. Please choose another one';
                $this->response['status'] = 'error';
                $this->response['field'] = '#register_email';
            } else {
                $this->addUser($data);
                $this->response['msg'] = 'Account created successfully';
                $this->response['status'] = 'success';
                session_start();
                $_SESSION['account'] = $data['Username'];
            }
        } else {
            $this->response['msg'] = 'All field is required';
            $this->response['status'] = 'error';
        }
        echo json_encode($this->response);
    }

    private function login()
    {
        $username = filter_var($_POST['Username'], FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['Password'], FILTER_SANITIZE_STRING);
        $user = $this->Object($this->get_user($username));
        if ($user->User['Count'] == 0) {
            $this->response['status'] = 'error';
            $this->response['msg'] = 'Username not found';
            $this->response['field'] = '#username';
        } elseif ($user->User['Data']['Password'] != $password) {
            $this->response['status'] = 'error';
            $this->response['msg'] = 'Password not matching';
            $this->response['field'] = '#password';
        } else {
            session_start();
            $_SESSION['account'] = $username;
            if ($user->User['Data']['State'] == 3 || $user->User['Data']['State'] == 2) {
                $_SESSION['Staff'] = $username;
            }
            $query = $this->conn->prepare("UPDATE accounts SET Last_Login = ? WHERE Username = ?");
            $query->execute(array(date($this->Date), $username));
            $this->response['msg'] = 'Login Successful . You will be redirect in 1 second';
            $this->response['status'] = 'success';
        }
        echo json_encode($this->response);
    }


}

$app = new controller();