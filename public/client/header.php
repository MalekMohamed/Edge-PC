<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PC, <?php foreach (Store::$category_array as $category) { echo $category.',';} foreach (Store::$Brands as $brand) { echo $brand.',';}
                                                        ?> used PC ,used in egypt ,pc hardware">
    <meta name="author" content="Malek Mohamed">
    <meta name="keywords" content="PC, <?php foreach (Store::$category_array as $category) { echo $category.',';} foreach (Store::$Brands as $brand) { echo $brand.',';}
                                                        ?> used PC ,used in egypt ,pc hardware">
    <link rel="shortcut icon" href="<?php echo $app->BASE_URL('public/assets/images/favicon_1.ico'); ?>">
    <title><?php echo $title; ?></title>
    <script src="<?php echo $app->BASE_URL('public/assets/js/jquery.min.js'); ?>"></script>
    <meta name="google-site-verification" content="8GOvdMR0W4bYgLI4QAGOtIP-mVJqWl3z6nzb5JsFuk8" />
    <script src="https://www.googletagmanager.com/gtag/js?id=UA-135664850-1" async></script>
    <script>function gtag() {
            dataLayer.push(arguments)
        }
        window.dataLayer = window.dataLayer || [], gtag("js", new Date), gtag("config", "UA-135664850-1")</script>
    <script>
        if (localStorage.theme == 'undefined') {
            localStorage.theme = 'light';
        }
    </script>
    <?php
    if (isset($_COOKIE['theme'])) {
        $theme = $_COOKIE['theme'];
    } else {
        $theme = 'light';
    }
    ?>
    <meta name="theme-color" id="themeColor" content="#36404a"/>
    <!-- DataTables -->
    <link href="<?php echo $app->BASE_URL('public/assets/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $app->BASE_URL('public/assets/css/' . $theme . '/core.min.css'); ?>" id="core-css"
          rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo $app->BASE_URL('public/assets/css/app.min.css'); ?>" rel="stylesheet" type="text/css"/>
    <script>
        DEBUG = false;
    </script>
    <style>
        .dataTables_wrapper {
            width: 100%;
        }
    </style>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

</head>
<body class="fixed-left">
<div id="wrapper">
    <div class="topbar">
        <div class="topbar-left">
            <div class="text-center">
                <a href="<?php echo $app->BASE_URL('index.php'); ?>" class="logo"><i
                            class="fa fa-edge"></i><span>-PC</span></a>
            </div>
        </div>
        <div class="navbar navbar-default" role="navigation">
            <div class="container">
                <div class="">
                    <div class="pull-left">
                        <button class="button-menu-mobile open-left waves-effect waves-light">
                            <i class="md md-menu"></i>
                        </button>
                        <span class="clearfix"></span>

                    </div>

                    <form role="search" class="navbar-left app-search pull-left hidden-xs">
                        <input type="text" name="search" placeholder="Search..." class="form-control">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                    <?php
                    if (isset($user_logged)) {
                        $userData = $app->get_user($user_logged)['User']['Data'];
                    if ($user_logged == 'Malek Mohamed') {
                        ?>
                        <script>
                            DEBUG = true;

                        </script>
                    <?php
                    }
                    ?>
                    <?php } else {
                    ?>
                        <div class="modal-demo text-left register-model">
                            <div class="custom-modal-dialog">
                                <div class="custom-modal-content">
                                    <div class="custom-modal-header">
                                        <button type="button" class="close" onclick="Custombox.close();"
                                                aria-hidden="true">×
                                        </button>
                                        <h4 class="custom-modal-title">Sign up
                                        </h4>
                                    </div>
                                    <div class="custom-modal-text">
                                        <form action="#" class="form-horizontal register-form"
                                              data-parsley-validate="" novalidate="">
                                            <div class="form-group ">
                                                <div class="col-xs-12">
                                                    <label for="register_username" class="control-label">Username
                                                        : </label>
                                                    <input class="form-control" id="register_username"
                                                           name="Username" type="text"
                                                           required="" placeholder="Username">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-xs-6">
                                                    <label for="register_password" class="control-label">Password
                                                        : </label>
                                                    <input class="form-control" id="register_password"
                                                           name="Password" type="password"
                                                           required="" placeholder="Password">
                                                </div>
                                                <div class="col-xs-6">
                                                    <label for="confirm_password" class="control-label">Confirm Password
                                                        : </label>
                                                    <input class="form-control" id="confirm_password"
                                                           data-parsley-equalto="#register_password"
                                                           type="password"
                                                           required="" placeholder="Password">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <label for="emailAddress">Email address*</label>
                                                    <input type="email" name="email" parsley-trigger="change"
                                                           required="" placeholder="Enter email" class="form-control"
                                                           id="register_email">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-xs-6">
                                                    <label for="register_country" class="control-label"
                                                           style="margin-top: 4px;">Country : </label>
                                                    <select class="selectpicker" name="Country" data-style="btn-inverse"
                                                            id="register_country">
                                                        <option value="AF">Afghanistan</option>
                                                        <option value="AX">Åland Islands</option>
                                                        <option value="AL">Albania</option>
                                                        <option value="DZ">Algeria</option>
                                                        <option value="AS">American Samoa</option>
                                                        <option value="AD">Andorra</option>
                                                        <option value="AO">Angola</option>
                                                        <option value="AI">Anguilla</option>
                                                        <option value="AQ">Antarctica</option>
                                                        <option value="AG">Antigua and Barbuda</option>
                                                        <option value="AR">Argentina</option>
                                                        <option value="AM">Armenia</option>
                                                        <option value="AW">Aruba</option>
                                                        <option value="AU">Australia</option>
                                                        <option value="AT">Austria</option>
                                                        <option value="AZ">Azerbaijan</option>
                                                        <option value="BS">Bahamas</option>
                                                        <option value="BH">Bahrain</option>
                                                        <option value="BD">Bangladesh</option>
                                                        <option value="BB">Barbados</option>
                                                        <option value="BY">Belarus</option>
                                                        <option value="BE">Belgium</option>
                                                        <option value="BZ">Belize</option>
                                                        <option value="BJ">Benin</option>
                                                        <option value="BM">Bermuda</option>
                                                        <option value="BT">Bhutan</option>
                                                        <option value="BO">Bolivia, Plurinational State of</option>
                                                        <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                                        <option value="BA">Bosnia and Herzegovina</option>
                                                        <option value="BW">Botswana</option>
                                                        <option value="BV">Bouvet Island</option>
                                                        <option value="BR">Brazil</option>
                                                        <option value="IO">British Indian Ocean Territory</option>
                                                        <option value="BN">Brunei Darussalam</option>
                                                        <option value="BG">Bulgaria</option>
                                                        <option value="BF">Burkina Faso</option>
                                                        <option value="BI">Burundi</option>
                                                        <option value="KH">Cambodia</option>
                                                        <option value="CM">Cameroon</option>
                                                        <option value="CA">Canada</option>
                                                        <option value="CV">Cape Verde</option>
                                                        <option value="KY">Cayman Islands</option>
                                                        <option value="CF">Central African Republic</option>
                                                        <option value="TD">Chad</option>
                                                        <option value="CL">Chile</option>
                                                        <option value="CN">China</option>
                                                        <option value="CX">Christmas Island</option>
                                                        <option value="CC">Cocos (Keeling) Islands</option>
                                                        <option value="CO">Colombia</option>
                                                        <option value="KM">Comoros</option>
                                                        <option value="CG">Congo</option>
                                                        <option value="CD">Congo, the Democratic Republic of the
                                                        </option>
                                                        <option value="CK">Cook Islands</option>
                                                        <option value="CR">Costa Rica</option>
                                                        <option value="CI">Côte d'Ivoire</option>
                                                        <option value="HR">Croatia</option>
                                                        <option value="CU">Cuba</option>
                                                        <option value="CW">Curaçao</option>
                                                        <option value="CY">Cyprus</option>
                                                        <option value="CZ">Czech Republic</option>
                                                        <option value="DK">Denmark</option>
                                                        <option value="DJ">Djibouti</option>
                                                        <option value="DM">Dominica</option>
                                                        <option value="DO">Dominican Republic</option>
                                                        <option value="EC">Ecuador</option>
                                                        <option value="EG">Egypt</option>
                                                        <option value="SV">El Salvador</option>
                                                        <option value="GQ">Equatorial Guinea</option>
                                                        <option value="ER">Eritrea</option>
                                                        <option value="EE">Estonia</option>
                                                        <option value="ET">Ethiopia</option>
                                                        <option value="FK">Falkland Islands (Malvinas)</option>
                                                        <option value="FO">Faroe Islands</option>
                                                        <option value="FJ">Fiji</option>
                                                        <option value="FI">Finland</option>
                                                        <option value="FR">France</option>
                                                        <option value="GF">French Guiana</option>
                                                        <option value="PF">French Polynesia</option>
                                                        <option value="TF">French Southern Territories</option>
                                                        <option value="GA">Gabon</option>
                                                        <option value="GM">Gambia</option>
                                                        <option value="GE">Georgia</option>
                                                        <option value="DE">Germany</option>
                                                        <option value="GH">Ghana</option>
                                                        <option value="GI">Gibraltar</option>
                                                        <option value="GR">Greece</option>
                                                        <option value="GL">Greenland</option>
                                                        <option value="GD">Grenada</option>
                                                        <option value="GP">Guadeloupe</option>
                                                        <option value="GU">Guam</option>
                                                        <option value="GT">Guatemala</option>
                                                        <option value="GG">Guernsey</option>
                                                        <option value="GN">Guinea</option>
                                                        <option value="GW">Guinea-Bissau</option>
                                                        <option value="GY">Guyana</option>
                                                        <option value="HT">Haiti</option>
                                                        <option value="HM">Heard Island and McDonald Islands</option>
                                                        <option value="VA">Holy See (Vatican City State)</option>
                                                        <option value="HN">Honduras</option>
                                                        <option value="HK">Hong Kong</option>
                                                        <option value="HU">Hungary</option>
                                                        <option value="IS">Iceland</option>
                                                        <option value="IN">India</option>
                                                        <option value="ID">Indonesia</option>
                                                        <option value="IR">Iran, Islamic Republic of</option>
                                                        <option value="IQ">Iraq</option>
                                                        <option value="IE">Ireland</option>
                                                        <option value="IM">Isle of Man</option>
                                                        <option value="IL">Israel</option>
                                                        <option value="IT">Italy</option>
                                                        <option value="JM">Jamaica</option>
                                                        <option value="JP">Japan</option>
                                                        <option value="JE">Jersey</option>
                                                        <option value="JO">Jordan</option>
                                                        <option value="KZ">Kazakhstan</option>
                                                        <option value="KE">Kenya</option>
                                                        <option value="KI">Kiribati</option>
                                                        <option value="KP">Korea, Democratic People's Republic of
                                                        </option>
                                                        <option value="KR">Korea, Republic of</option>
                                                        <option value="KW">Kuwait</option>
                                                        <option value="KG">Kyrgyzstan</option>
                                                        <option value="LA">Lao People's Democratic Republic</option>
                                                        <option value="LV">Latvia</option>
                                                        <option value="LB">Lebanon</option>
                                                        <option value="LS">Lesotho</option>
                                                        <option value="LR">Liberia</option>
                                                        <option value="LY">Libya</option>
                                                        <option value="LI">Liechtenstein</option>
                                                        <option value="LT">Lithuania</option>
                                                        <option value="LU">Luxembourg</option>
                                                        <option value="MO">Macao</option>
                                                        <option value="MK">Macedonia, the former Yugoslav Republic of
                                                        </option>
                                                        <option value="MG">Madagascar</option>
                                                        <option value="MW">Malawi</option>
                                                        <option value="MY">Malaysia</option>
                                                        <option value="MV">Maldives</option>
                                                        <option value="ML">Mali</option>
                                                        <option value="MT">Malta</option>
                                                        <option value="MH">Marshall Islands</option>
                                                        <option value="MQ">Martinique</option>
                                                        <option value="MR">Mauritania</option>
                                                        <option value="MU">Mauritius</option>
                                                        <option value="YT">Mayotte</option>
                                                        <option value="MX">Mexico</option>
                                                        <option value="FM">Micronesia, Federated States of</option>
                                                        <option value="MD">Moldova, Republic of</option>
                                                        <option value="MC">Monaco</option>
                                                        <option value="MN">Mongolia</option>
                                                        <option value="ME">Montenegro</option>
                                                        <option value="MS">Montserrat</option>
                                                        <option value="MA">Morocco</option>
                                                        <option value="MZ">Mozambique</option>
                                                        <option value="MM">Myanmar</option>
                                                        <option value="NA">Namibia</option>
                                                        <option value="NR">Nauru</option>
                                                        <option value="NP">Nepal</option>
                                                        <option value="NL">Netherlands</option>
                                                        <option value="NC">New Caledonia</option>
                                                        <option value="NZ">New Zealand</option>
                                                        <option value="NI">Nicaragua</option>
                                                        <option value="NE">Niger</option>
                                                        <option value="NG">Nigeria</option>
                                                        <option value="NU">Niue</option>
                                                        <option value="NF">Norfolk Island</option>
                                                        <option value="MP">Northern Mariana Islands</option>
                                                        <option value="NO">Norway</option>
                                                        <option value="OM">Oman</option>
                                                        <option value="PK">Pakistan</option>
                                                        <option value="PW">Palau</option>
                                                        <option value="PS">Palestinian Territory, Occupied</option>
                                                        <option value="PA">Panama</option>
                                                        <option value="PG">Papua New Guinea</option>
                                                        <option value="PY">Paraguay</option>
                                                        <option value="PE">Peru</option>
                                                        <option value="PH">Philippines</option>
                                                        <option value="PN">Pitcairn</option>
                                                        <option value="PL">Poland</option>
                                                        <option value="PT">Portugal</option>
                                                        <option value="PR">Puerto Rico</option>
                                                        <option value="QA">Qatar</option>
                                                        <option value="RE">Réunion</option>
                                                        <option value="RO">Romania</option>
                                                        <option value="RU">Russian Federation</option>
                                                        <option value="RW">Rwanda</option>
                                                        <option value="BL">Saint Barthélemy</option>
                                                        <option value="SH">Saint Helena, Ascension and Tristan da
                                                            Cunha
                                                        </option>
                                                        <option value="KN">Saint Kitts and Nevis</option>
                                                        <option value="LC">Saint Lucia</option>
                                                        <option value="MF">Saint Martin (French part)</option>
                                                        <option value="PM">Saint Pierre and Miquelon</option>
                                                        <option value="VC">Saint Vincent and the Grenadines</option>
                                                        <option value="WS">Samoa</option>
                                                        <option value="SM">San Marino</option>
                                                        <option value="ST">Sao Tome and Principe</option>
                                                        <option value="SA">Saudi Arabia</option>
                                                        <option value="SN">Senegal</option>
                                                        <option value="RS">Serbia</option>
                                                        <option value="SC">Seychelles</option>
                                                        <option value="SL">Sierra Leone</option>
                                                        <option value="SG">Singapore</option>
                                                        <option value="SX">Sint Maarten (Dutch part)</option>
                                                        <option value="SK">Slovakia</option>
                                                        <option value="SI">Slovenia</option>
                                                        <option value="SB">Solomon Islands</option>
                                                        <option value="SO">Somalia</option>
                                                        <option value="ZA">South Africa</option>
                                                        <option value="GS">South Georgia and the South Sandwich
                                                            Islands
                                                        </option>
                                                        <option value="SS">South Sudan</option>
                                                        <option value="ES">Spain</option>
                                                        <option value="LK">Sri Lanka</option>
                                                        <option value="SD">Sudan</option>
                                                        <option value="SR">Suriname</option>
                                                        <option value="SJ">Svalbard and Jan Mayen</option>
                                                        <option value="SZ">Swaziland</option>
                                                        <option value="SE">Sweden</option>
                                                        <option value="CH">Switzerland</option>
                                                        <option value="SY">Syrian Arab Republic</option>
                                                        <option value="TW">Taiwan, Province of China</option>
                                                        <option value="TJ">Tajikistan</option>
                                                        <option value="TZ">Tanzania, United Republic of</option>
                                                        <option value="TH">Thailand</option>
                                                        <option value="TL">Timor-Leste</option>
                                                        <option value="TG">Togo</option>
                                                        <option value="TK">Tokelau</option>
                                                        <option value="TO">Tonga</option>
                                                        <option value="TT">Trinidad and Tobago</option>
                                                        <option value="TN">Tunisia</option>
                                                        <option value="TR">Turkey</option>
                                                        <option value="TM">Turkmenistan</option>
                                                        <option value="TC">Turks and Caicos Islands</option>
                                                        <option value="TV">Tuvalu</option>
                                                        <option value="UG">Uganda</option>
                                                        <option value="UA">Ukraine</option>
                                                        <option value="AE">United Arab Emirates</option>
                                                        <option value="GB">United Kingdom</option>
                                                        <option value="US">United States</option>
                                                        <option value="UM">United States Minor Outlying Islands</option>
                                                        <option value="UY">Uruguay</option>
                                                        <option value="UZ">Uzbekistan</option>
                                                        <option value="VU">Vanuatu</option>
                                                        <option value="VE">Venezuela, Bolivarian Republic of</option>
                                                        <option value="VN">Viet Nam</option>
                                                        <option value="VG">Virgin Islands, British</option>
                                                        <option value="VI">Virgin Islands, U.S.</option>
                                                        <option value="WF">Wallis and Futuna</option>
                                                        <option value="EH">Western Sahara</option>
                                                        <option value="YE">Yemen</option>
                                                        <option value="ZM">Zambia</option>
                                                        <option value="ZW">Zimbabwe</option>
                                                    </select>
                                                </div>
                                                <div class="col-xs-6">
                                                    <label for="confirm_password" class="control-label">Mobile
                                                        : </label>
                                                    <input class="form-control" id="register_mobile"
                                                           name="Mobile" type="text"
                                                           required="" placeholder="+020101010101">
                                                </div>
                                            </div>
                                    </div>
                                    <div class="panel-footer">
                                        <button type="submit"
                                                class="btn btn-primary waves-effect waves-light"><i
                                                    class="fa fa-user-plus"></i> Submit
                                        </button>
                                        <button type="button"
                                                class="btn btn-default waves-effect pull-right "
                                                onclick="Custombox.close();"><i class="fa fa-times"></i>
                                            Close
                                        </button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal-demo text-left login-model">
                            <div class="custom-modal-dialog">
                                <div class="custom-modal-content">
                                    <div class="custom-modal-header">
                                        <button type="button" class="close" onclick="Custombox.close();"
                                                aria-hidden="true">×
                                        </button>
                                        <h4 class="custom-modal-title">Sign in
                                        </h4>
                                    </div>
                                    <div class="custom-modal-text">
                                        <form action="#" class="form-horizontal login-form"
                                              data-parsley-validate="" novalidate="">
                                            <div class="form-group ">
                                                <div class="col-xs-12">
                                                    <label for="username" class="control-label">Username
                                                        : </label>
                                                    <input class="form-control" id="username"
                                                           name="Username" type="text"
                                                           required="" placeholder="Username">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <label for="password" class="control-label">Password
                                                        : </label>
                                                    <input class="form-control" id="password"
                                                           name="Password" type="password"
                                                           required="" placeholder="Password">
                                                </div>
                                            </div>
                                            <div class="form-group m-t-20 m-b-0">
                                                <div class="col-sm-6">
                                                    <a data-animation="fadein" onclick="Custombox.close();" data-plugin="custommodal" data-overlayspeed="200"
                                                       data-overlaycolor="#36404a" href=".reset-model"
                                                       class="text-dark"><i class="fa fa-lock m-r-5"></i>
                                                        Forgot your password?</a>
                                                </div>

                                            </div>
                                    </div>
                                    <div class="panel-footer">
                                        <button type="submit"
                                                class="btn btn-primary waves-effect waves-light"><i
                                                    class="fa fa-sign-in"></i> Submit
                                        </button>
                                        <button type="button"
                                                class="btn btn-default waves-effect pull-right "
                                                onclick="Custombox.close();"><i class="fa fa-times"></i>
                                            Close
                                        </button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal-demo text-left reset-model">
                            <div class="custom-modal-dialog">
                                <div class="custom-modal-content">
                                    <div class="custom-modal-header">
                                        <button type="button" class="close" onclick="Custombox.close();"
                                                aria-hidden="true">×
                                        </button>
                                        <h4 class="custom-modal-title">Recover password
                                        </h4>
                                    </div>
                                    <div class="custom-modal-text">
                                        <form action="#" class="form-horizontal reset-form"
                                              data-parsley-validate="" novalidate="">
                                            <div class="form-group ">
                                                <div class="col-xs-12">
                                                    <label for="reset_email" class="control-label">Email
                                                        : </label>
                                                    <input class="form-control" id="reset_email"
                                                           name="Email" type="email"
                                                           required="" placeholder="email@domain.com">
                                                </div>
                                            </div>
                                            <div class="form-group m-t-20 m-b-0">
                                                <div class="col-sm-6">
                                                    <a data-animation="fadein" onclick="Custombox.close();" data-plugin="custommodal" data-overlayspeed="200"
                                                       data-overlaycolor="#36404a" href=".login-model"
                                                       class="text-dark"><i class="fa fa-lock m-r-5"></i>
                                                        Already have an account?</a>
                                                </div>

                                            </div>
                                    </div>
                                    <div class="panel-footer">
                                        <button type="submit"
                                                class="btn btn-primary waves-effect waves-light"><i
                                                    class="fa fa-sign-in"></i> Submit
                                        </button>
                                        <button type="button"
                                                class="btn btn-default waves-effect pull-right "
                                                onclick="Custombox.close();"><i class="fa fa-times"></i>
                                            Close
                                        </button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="modal-demo text-left new-item-model">
                        <div class="custom-modal-dialog">
                            <div class="custom-modal-content">
                                <div class="custom-modal-header">
                                    <button type="button" class="close" onclick="Custombox.close();"
                                            aria-hidden="true">×
                                    </button>
                                    <h4 class="custom-modal-title">Add New item
                                    </h4>
                                </div>
                                <div class="custom-modal-text">
                                    <form action="#" enctype="multipart/form-data"
                                          class="form-horizontal add-item-form" data-parsley-validate=""
                                          novalidate="">
                                        <div class="form-group ">
                                            <div class="col-xs-12">
                                                <label for="item_name" class="control-label">Name : </label>
                                                <input class="form-control" id="item_name"
                                                       name="Name" type="text" maxlength="32"
                                                       required="" placeholder="Asus Strix GTX 1070ti">
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="col-xs-12">
                                                <label for="item_category" class="control-label category-select">Category : </label>
                                                <select class="selectpicker show-tick" name="Category" onchange="changeBrands(this);"
                                                        data-style="btn-inverse"
                                                        id="item_category">
                                                    <?php
                                                    foreach (Store::$category_array as $category) {
                                                        ?>
                                                        <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group cateData hidden" id="cateData">

                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-6">
                                                <label for="item_cond" class="control-label"
                                                       style="margin-top: 4px;">Condition
                                                    : </label>
                                                <select class="selectpicker show-tick" name="Cond"
                                                        data-style="btn-inverse"
                                                        id="item_cond">
                                                    <option value="New" selected>New</option>
                                                    <option value="Used">Used</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-6">
                                                <label for="item_price" class="control-label">Price : </label>
                                                <input class="form-control" id="item_price"
                                                       name="Price" type="number"
                                                       required="" placeholder="1500">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <label for="item_desc">Description</label>
                                                <textarea class="form-control" id="item_desc"
                                                          name="Description"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <label for="item_images">Images</label>
                                                <input type="file" name="images[]" id="item_images" multiple
                                                       class="filestyle">
                                            </div>
                                        </div>
                                </div>
                                <div class="panel-footer">
                                    <button type="submit"
                                            class="btn btn-primary waves-effect waves-light"><i
                                                class="fa fa-user-plus"></i> Submit
                                    </button>
                                    <button type="button"
                                            class="btn btn-default waves-effect pull-right "
                                            onclick="Custombox.close();"><i class="fa fa-times"></i>
                                        Close
                                    </button>
                                </div>
                                </form>
                                <script type="application/javascript">
                                    function changeBrands(element) {
                                        var cate = $(element).val();
                                        console.log($(element));
                                       $.ajax({
                                            type: 'post',
                                            url: base_url + "?request=brands",
                                            data: {cate: cate},
                                            success: function (res) {
                                                var brands = $.parseJSON(res).Brands;
                                                var lastKey = Object.keys($.parseJSON(res)).sort().reverse()[0];
                                                var chipset = $.parseJSON(res)[lastKey];
                                                console.log(chipset);
                                                $('.cateData').html('');
                                                $('.cateData').removeClass('hidden');
                                                $.each($.parseJSON(res), function (key, value) {
                                                    var field_name = key;
                                                    if (key != 'Brands') {
                                                        field_name = 'extData';
                                                    }
                                                    var dom = '<div class="col-xs-6 '+key+'-select"><label for="item_'+key+'" class="control-label">'+key+' : </label><select class="form-control item_'+key+'" name="'+field_name+'" id="item_'+key+'"></select></div>';
                                                    $(".cateData").append(dom);
                                                });
                                                $.each(brands, function (key, value) {
                                                    var brands_options = '<option value="' + value + '">' + value + '</option>';
                                                    $(".item_Brands").append(brands_options);
                                                });
                                                $.each(chipset, function (key, value) {
                                                    var chipset_options = '<option value="' + value + '">' + value + '</option>';
                                                    $(".item_"+lastKey).append(chipset_options);
                                                });
                                            }
                                        });
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                    <ul class="nav navbar-nav navbar-right pull-right">
                        <?php
                        if (isset($_SESSION['account'])) {
                            ?>
                            <li class="dropdown top-menu-item-xs" onclick="notifications.update(0);">
                                <input type="hidden"
                                       value="<?php echo $app->get_new_notification($userData['Username'])[0]; ?>"
                                       id="new_notif">
                                <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light"
                                   data-toggle="dropdown" aria-expanded="false">
                                    <i class="icon-bell"></i>
                                    <span <?php if ($app->get_new_notification($userData['Username'])[0] != 0) { ?> style="display: block;" <?php } else { ?> style="display: none;"<?php } ?>
                                        class="upcoming_badge badge badge-xs badge-danger"><?php echo $app->get_new_notification($userData['Username'])[0]; ?></span>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-lg">
                                    <?php if ($app->get_notification($userData['Username'])[0] != 0) {
                                        ?>
                                        <li class="notifi-title"><span
                                                    class="label label-default pull-right">New <?php echo $app->get_new_notification($userData['Username'])[0]; ?></span>Notification
                                        </li>
                                    <?php } ?>
                                    <li class="list-group slimscroll-noti notification-list">
                                        <?php
                                        foreach ($app->get_notification($userData['Username'])[1] as $notification) {
                                            ?>
                                            <!-- list item-->
                                            <a href="<?php echo $notification['url']; ?>"
                                               data-user="<?php echo $notification['touser']; ?>"
                                               data-id="<?php echo $notification['id']; ?>" class="list-group-item old">
                                                <div class="media">
                                                    <div class="pull-left p-r-10">
                                                        <em class="fa <?php echo $app->notification_category($notification['category']); ?> noti-primary"></em>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5 class="media-heading"><?php echo $notification['title']; ?></h5>
                                                        <p class="m-0">
                                                            <small><?php echo $notification['time']; ?></small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>

                                        <?php } ?>
                                    </li>
                                </ul>

                            </li>
                            <li class="top-menu-item-xs"><a data-animation="fadein" data-plugin="custommodal"
                                                            data-overlayspeed="200"
                                                            data-overlaycolor="#36404a" href=".new-item-model"
                                                            class="waves-effect waves-light"><i class="md md-edit"></i>
                                    <text>Sell item</text>
                                </a></li>
                            <li class="top-menu-item-xs">
                                <a href="<?php echo $app->BASE_URL('account/messages'); ?>"
                                   class="waves-effect waves-light"><i class="fa fa-comments"></i>
                                    <text>Messenger</text>
                                </a>
                            </li>
                        <?php } ?>

                        <li class="dropdown top-menu-item-xs">
                            <a href="" class="dropdown-toggle profile  waves-effect waves-light"
                               data-toggle="dropdown"
                               aria-expanded="true"><i class="fa fa-user"></i><?php
                                if (!isset($user_logged)) {
                                    ?> Account <?php } else { ?>
                                    <text
                                            class="userData"><?php echo $user_logged . '</text>';
                                } ?></a>
                            <ul class="dropdown-menu">
                                <?php
                                if (!isset($user_logged)) {
                                    ?>
                                    <li><a data-animation="fadein" data-plugin="custommodal" data-overlayspeed="200"
                                           data-overlaycolor="#36404a" href=".login-model"><i
                                                    class="ti-user m-r-10 text-custom"></i>
                                            Login</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li><a data-animation="fadein" data-plugin="custommodal" data-overlayspeed="200"
                                           data-overlaycolor="#36404a" href=".register-model"><i
                                                    class="fa fa-user-plus m-r-10 text-warning"></i>
                                            Sign Up</a>
                                    </li>

                                <?php } else { ?>

                                    <li><a href="<?php echo $app->BASE_URL('account/manage-item'); ?>"><i
                                                    class="ti-menu-alt m-r-10 text-danger"></i>
                                            Manage items</a>
                                    </li>
                                    <li><a href="<?php echo $app->BASE_URL('account/messages'); ?>"><i
                                                    class="fa fa-envelope m-r-10 text-primary"></i>
                                            Messenger</a>
                                    </li>
                                    <li><a href="<?php echo $app->BASE_URL('account/settings'); ?>"><i
                                                    class="ti-settings m-r-10 text-warning"></i>
                                            My Account</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li><a href="<?php echo $app->BASE_URL('account/Logout'); ?>"><i
                                                    class="ti-power-off m-r-10 text-danger"></i>
                                            Logout</a>
                                    </li>

                                <?php } ?>
                                <li><a>Dark mode : <input id="ThemeColor" type="checkbox" <?php
                                        if ($_COOKIE['theme'] == 'dark') {
                                            echo 'checked onchange="changeTheme(\'light\');"';
                                        } else {
                                            echo 'onchange="changeTheme(\'dark\');"';
                                        }
                                ?>
                                                          data-secondary-color="#ebeff2"
                                                          data-plugin="switchery" data-color="#f05050" data-size="small"
                                                          data-switchery="true"></a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                    <form role="search" class="navbar-left app-search-sm hidden-sm">
                        <input type="text" name="search" placeholder="Search..." class="form-control">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="left side-menu">

        <div class="sidebar-inner slimscrollleft">
            <div id="sidebar-menu">
                <ul>
                    <li class="text-white menu-title"><i class="fa fa-list"></i> Categories</li>
                    <?php foreach (Store::$category_array as $cateogry) { ?>
                        <li>
                            <a href="<?php echo $app->BASE_URL('Category/' . $cateogry); ?>"
                               class="waves-effect waves-light">
                                <i class="fa fa-angle-right"></i> <?php echo $cateogry; ?></a>
                        </li>
                    <?php }
                    if (isset($_SESSION['Staff'])) {
                        ?>
                        <li class="text-white menu-title"><i class="fa fa-user-secret"></i> Staff Panel</li>
                        <li>
                            <a href="<?php echo $app->BASE_URL('Staff/items'); ?>" class="waves-effect waves-light">
                                <i class="fa fa-angle-right"></i> Pending items ( <?php echo count($app->getPendingItems()); ?> )</a>
                        </li>
                        <li>
                            <a href="<?php echo $app->BASE_URL('Staff/accounts'); ?>" class="waves-effect waves-light">
                                <i class="fa fa-angle-right"></i> Accounts</a>
                        </li>
                        <li>
                            <a href="<?php echo $app->BASE_URL('Staff/reports'); ?>" class="waves-effect waves-light">
                                <i class="fa fa-angle-right"></i> Items reports</a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="content-page">
        <div class="content">
            <div class="container">