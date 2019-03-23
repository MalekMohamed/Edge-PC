<?php
/**
 * Created by PhpStorm.
 * User: Legacy
 * Date: 7/15/2018
 * Time: 11:59 AM
 */
?>
<div class="card-box">
    <div class="panel-heading">
        <h3 class="text-center"> Sign In to <strong class="text-custom">UBold</strong></h3>
    </div>

    <div class="panel-body">

<form action="#" class="form-horizontal m-t-20" data-parsley-validate="" novalidate="">
    <div class="form-group ">
    <div class="col-xs-12">
        <input class="form-control" type="text" required="" placeholder="Username">
    </div>
    </div>

    <div class="form-group">
        <div class="col-xs-12">
            <input class="form-control" type="password" required="" placeholder="Password">
        </div>
    </div>

    <div class="form-group ">
        <div class="col-xs-12">
            <div class="checkbox checkbox-primary">
                <input id="checkbox-signup" type="checkbox">
                <label for="checkbox-signup"> Remember me </label>
            </div>

        </div>
    </div>

    <div class="form-group text-center m-t-40">
        <div class="col-xs-12">
            <button class="btn btn-pink btn-block text-uppercase waves-effect waves-light" type="submit">
                Log In
            </button>
        </div>
    </div>

    <div class="form-group m-t-20 m-b-0">
        <div class="col-sm-12">
            <a href="<?php echo $app->BASE_URL('account/recover_password');?>" class="text-dark"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
        </div>
    </div>
    </form>

</div>
</div>
<div class="row">
    <div class="col-sm-12 text-center">
        <p>
            Don't have an account? <a href="<?php echo $app->BASE_URL('account/sign-up');?>" class="text-primary m-l-5"><b>Sign Up</b></a>
        </p>
    </div>
</div>

