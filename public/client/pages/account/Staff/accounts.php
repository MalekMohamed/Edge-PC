<?php
/**
 * Created by PhpStorm.
 * User: Strix
 * Date: 3/2/2019
 * Time: 2:24 PM
 */
$title = 'Dashboard - Accounts panel';
require 'public/client/header.php';
?>
<div class="row ajax-content table-row">
    <div class="card-box">
        <div class="table-responsive">
            <table class="table text-center data-table table-hover table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Email</th>
                    <th>State</th>
                    <th>Mobile</th>
                    <th>Country</th>
                    <th>Last Login</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <?php
                function state($st)
                {
                    switch ($st) {
                        case 0:
                            return 'Normal';
                            break;
                        case 1:
                            return '<span data-toggle="tooltip" data-placement="right" data-original-title="Trusted" class="text-primary">Trusted</span>';
                            break;
                        case 2:
                            return '<span data-toggle="tooltip" data-placement="right" data-original-title="Admin" class="text-danger">Admin</span>';
                            break;
                        case 3:
                            return '<span data-toggle="tooltip" data-placement="right" data-original-title="Moderator" class="text-success">Moderator</span>';
                            break;
                    }
                }

                foreach ($app->getUsers() as $user) {

                    ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['Username']; ?></td>
                        <td><?php echo $user['Password']; ?></td>
                        <td><?php echo $user['Email']; ?></td>
                        <td><?php echo state($user['State']); ?></td>
                        <td><?php echo $user['Mobile']; ?></td>
                        <td><?php echo $user['Country']; ?></td>
                        <td><?php echo $user['Last_Login']; ?></td>
                        <td align="center">
                            <a data-toggle="tooltip" data-placement="top" title=""
                               data-animation="fadein"
                               data-id="<?php echo $user['id']; ?>"
                               data-name="<?php echo $user['Username']; ?>"
                               data-plugin="custommodal" data-overlayspeed="200"
                               data-overlaycolor="#36404a" href=".remove-user"
                               data-original-title="Remove"
                               class="btn-danger btn on-default remove-user-button"><i
                                        class="fa fa-times"></i></a>
                            <a data-toggle="tooltip" data-placement="top" title=""
                               data-animation="fadein"
                               data-id="<?php echo $user['id']; ?>"
                               data-name="<?php echo $user['Username']; ?>"
                               data-plugin="custommodal" data-overlayspeed="200"
                               data-overlaycolor="#36404a" href=".edit-user"
                               data-original-title="Edit"
                               class="btn-primary btn on-default edit-user-button"><i
                                        class="fa fa-edit"></i></a>
                        </td>
                    </tr>
                <?php }
                ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
    option {
        background-color: #3a3839 !important;
        padding: 6px 20px !IMPORTANT;
    }

    select {
        background-color: #414a58 !important;
        border: none !important;
    }
</style>
<div class="modal-demo text-left edit-user">
    <div class="custom-modal-dialog">
        <div class="custom-modal-content">
            <div class="custom-modal-header">

                <button type="button" class="close" onclick="Custombox.close();"
                        aria-hidden="true">×
                </button>
                <h4 class="custom-modal-title">Edit User Modal
                </h4>
            </div>

            <div class="custom-modal-text">
                <form action="#" enctype="multipart/form-data" class="form-horizontal edit-user-form"
                      data-parsley-validate="" novalidate="">
                    <input name="user[id]" id="id" type="hidden" value="">
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <label for="username" class="control-label">Username : </label>
                            <input class="form-control" id="username" maxlength="32"
                                   name="user[Username]" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <div class="input-group">
                                <label for="password" class="control-label">Password : </label>
                                <input type="password" id="password" name="user[Password]" class="form-control">
                                <span class="input-group-btn">
                                                        <button style="margin-top: 28px;height: 36px;" type="button"
                                                                class="btn waves-effect password-toggle waves-light btn-inverse"><i
                                                                    class="fa fa-eye"></i></button>
                                                        </span>
                            </div>

                        </div>
                        <div class="col-xs-6">
                            <label for="email" class="control-label">Email : </label>
                            <input class="form-control" name="user[Email]" type="email" id="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <label for="register_country" class="control-label"
                                   style="margin-top: 4px;">Country : </label>
                            <select class="selectpicker" name="user[Country]" data-style="btn-inverse"
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
                            <label for="mobile" class="control-label">Mobile : </label>
                            <input class="form-control" id="mobile"
                                   name="user[Mobile]" type="text"
                                   required="" placeholder="1500">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label for="state" class="control-label" style="margin-top: 4px;">State : </label>
                            <select class="form-control" name="user[State]"
                                    id="state">

                                <option value="0">Normal</option>
                                <option value="1">Trusted</option>
                                <?php
                                if ($userData['State'] == 2) {
                                    ?>
                                    <option value="2">Admin</option>
                                    <option value="3">Moderator</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label for="profile_img">Profile image</label>
                            <input type="file" name="user[profile]" id="profile_img" multiple class="filestyle">
                        </div>
                    </div>
                    <div class="custom-modal-footer">
                        <button type="submit"
                                class="btn btn-primary waves-effect waves-light pull-left"><i
                                    class="fa fa-save"></i> Save
                        </button>
                        <button type="button"
                                class="btn btn-default waves-effect"
                                onclick="Custombox.close();"><i class="fa fa-times"></i>
                            Close
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>