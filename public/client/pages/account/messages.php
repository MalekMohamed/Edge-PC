<?php
/**
 * Created by PhpStorm.
 * User: Strix
 * Date: 9/2/2019
 * Time: 6:26 PM
 */
$title = $app->siteName . ' - Messenger';
require 'public/client/header.php';
$messages = $app->messages($userData['id']);
if ($messages[0] != 0) {
    $messanger = $messages[1];
    ?>
    <div class="wrapper">
    <div class="container">
    <div class="row">
        <div class="col-sm-8">
            <ol class="breadcrumb">
                <li>Home</li>
                <li class="active">
                    <a href="#">Messenger</a>
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <h4 class="m-t-0 m-b-20 header-title"><b>All Messages</b></h4>
                <div class="inbox-widget nicescroll" tabindex="5000"
                     style="overflow: hidden; outline: none;max-height: 700px;">
                    <?php
                    foreach ($messanger as $msgs) {
                       
                        $users = $app->getUserByID($msgs['userID']);
                        if (empty($users)) {
                            $users = $app->getUserByID($msgs['chat_with']);
                        }
                        if ($users['Username'] != $userData['Username']) {
                            ?>
                            <a class="" href="<?php echo $app->BASE_URL('account/messenger/' . numhash($msgs['ad_id']) . '-' . $users['Username']); ?>">
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img
                                                src="<? echo $app->BASE_URL('public/assets/images/user.jpg'); ?>"
                                                class="img-circle" alt=""></div>
                                    <p class="inbox-item-author"><?php echo $users['Username']; ?></p>
                                    <p class="inbox-item-text"><?php echo $msgs['message']; ?></p>
                                    <p class="inbox-item-date"><?php echo $app->get_post_time($msgs['date']); ?></p>
                                </div>
                            </a>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>

        </div>

    </div>
    <?php
}
?>