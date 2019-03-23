<?php
/**
 * Created by PhpStorm.
 * User: Strix
 * Date: 1/28/2019
 * Time: 2:27 PM
 */
$title = $app->siteName . ' - Account Settings';
require 'public/client/header.php';
?>
<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <form action="#" class="form-horizontal changepassword-form"
                  data-parsley-validate="" novalidate="">
                <div class="form-group">
                    <div class="col-xs-12">
                        <label for="oldPassword" class="control-label">Old Password : </label>
                        <input class="form-control" id="oldPassword"
                               name="oldPassword" type="password"
                               required="" placeholder="*******">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <label for="Newpassword" class="control-label">New Password : </label>
                        <input class="form-control" id="Newpassword"
                               name="NewPassword" type="password"
                               required="***********" placeholder="New Password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <label for="ConfirmPassword" class="control-label">Confirm New Password : </label>
                        <input class="form-control" id="ConfirmPassword" type="password" data-parsley-equalto="#Newpassword"
                               required="***********" placeholder="Confirm Password">
                    </div>
                </div>
                <button type="submit"
                        class="btn btn-primary waves-effect waves-light"><i
                            class="fa fa-sign-in"></i> Submit
                </button>

            </form>
        </div>
    </div>
</div>