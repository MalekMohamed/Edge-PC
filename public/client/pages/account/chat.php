<?php
/**
 * Created by PhpStorm.
 * User: Strix
 * Date: 9/2/2019
 * Time: 6:26 PM
 */
$ad['id'] = numhash(filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT));
$user = filter_var($_GET['user'], FILTER_SANITIZE_STRING);
$item = $app->get_items($ad)[0];
if (!empty($item)) {
$item_owner = $app->get_user($item['User'])['User']['Data'];
$chat_with = $app->get_user($user)['User']['Data'];
$users_in_chat = $chat_with['id'] . ',' . $userData['id'];
$title = !empty($chat_with['Username']) ? 'Chat - ' . $chat_with['Username'] : $app->siteName;
require 'public/client/header.php';
$chat = $app->get_user_messages($userData['id'], $chat_with['id'], $ad['id']);
if ($chat[0] == 0) {
    $chat = $app->get_user_messages($chat_with['id'], $userData['id'], $ad['id'])[1];
} else {
    $chat = $chat[1];
}

?>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">

                <h4 class="page-title">Chat with : <a
                            href="<?php echo $app->BASE_URL('profile/' . $chat_with); ?>"> <?php echo $chat_with['Username']; ?></a>
                </h4>
                </h4>
            </div>
            <div class="col-sm-4 m-b-5">
                <button type="button" onclick="$(this).text('0<?php echo $item_owner['Mobile']; ?>');"
                        class="btn btn-block btn-lg btn-inverse waves-effect waves-light">Show Mobile Number
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="card-box">
                    <h4 class="m-t-0 m-b-20 header-title"><b><?php echo $chat_with['Username']; ?></b></h4>

                    <div class="chat-conversation">
                        <ul class="conversation-list nicescroll" style="overflow: hidden; outline: none;"
                            tabindex="5001">
                            <?php foreach ($chat as $data) {
                                if ($data['userID'] == $chat_with['id']) { ?>
                                    <li class="clearfix">
                                        <div class="chat-avatar">
                                            <a class="chat-profile"
                                               href="<?php echo $app->BASE_URL('profile/' . $chat_with); ?>">
                                                <img data-toggle="tooltip" data-placement="left" title=""
                                                     data-original-title="<?php echo $chat_with['Username']; ?>"
                                                     class="user-avatar"
                                                     src="<?php echo $app->BASE_URL('public/assets/images/user.jpg'); ?>"
                                                     alt="<?php echo $chat_with['Username']; ?>"
                                                     width="45"
                                                     height="45">
                                            </a>
                                        </div>
                                        <div class="conversation-text">
                                            <div class="ctext-wrap" data-placement="right" data-toggle="tooltip"
                                                 data-original-title="<?php echo $app->get_post_time($data['date']); ?>">
                                                <p>
                                                    <?php echo $data['message']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                <?php } elseif ($data['userID'] == $userData['id']) {
                                    ?>
                                    <li class="clearfix odd">
                                        <div class="chat-avatar">
                                            <img class="my-avatar" data-toggle="tooltip" data-placement="right" title=""
                                                 data-original-title="Me"
                                                 src="<?php echo $app->BASE_URL('public/assets/images/user.jpg'); ?>"
                                                 alt="Me"
                                                 width="45"
                                                 height="45">

                                        </div>
                                        <div class="conversation-text">
                                            <div class="ctext-wrap" data-placement="left" data-toggle="tooltip"
                                                 data-original-title="<?php echo $app->get_post_time($data['date']); ?>">

                                                <p class="chat-me">
                                                    <?php echo $data['message']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                <?php }
                            } ?>
                        </ul>
                        <div class="row">
                            <form class="chat-form" action="#">
                                <div class="col-sm-9 chat-inputbar">
                                    <input type="text" class="form-control chat-input" placeholder="Enter your text">
                                </div>
                                <div class="col-sm-3 chat-send">
                                    <button type="submit" data-sender="<?php echo $userData['id']; ?>"
                                            data-adID="<?php echo numhash($ad['id']); ?>"
                                            data-receiver="<?php echo $chat_with['id']; ?>"
                                            class="btn btn-md btn-info btn-block waves-effect waves-light chat-data"><i
                                                class="fa fa-send"></i>
                                        Send
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-box">
                    <h4><b>Item Specifications:</b></h4>
                    <div class="table-responsive m-t-20">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td width="400">Name</td>
                                <td style="text-transform: uppercase">
                                    <?php echo $item['Name']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="400">Brand</td>
                                <td>
                                    <?php echo $item['Brand']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Condition</td>
                                <td>
                                    <?php echo $item['Cond']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Price</td>
                                <td>
                                    <?php echo number_format($item['Price']); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>
                                    <?php echo Store::status($item['Status']); ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
        } else {

            $url = $app->BASE_URL('404');
            header("Location: $url");
        } ?>
