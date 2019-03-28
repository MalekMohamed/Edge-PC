<?php
$data['id'] = numhash(filter_var($_GET['value'], FILTER_SANITIZE_NUMBER_INT));
$item = $app->get_items($data)[0];
$user = $app->get_user($item['User'])['User']['Data'];
$title = !empty($item['Name']) ? $app->siteName . ' - ' . $item['Name'] : $app->siteName;
if (!empty($item)) {
    require 'public/client/header.php';
    if ($item['Status'] != 0 || $item['Status'] != 3 && ($user_logged == $item['User'] || $userData['State'] == 2)) {
        $ad_images = explode('-', $item['images']);
        foreach ($ad_images as $image) {
            if (file_exists('public/uploads/images/' . numhash($item['ID']) . '/' . $image)) {
                $images = 'public/uploads/images/' . numhash($item['ID']) . '/' . $image;
                $image_found = true;
            } else {
                $images = 'public/uploads/images/no-thumbnail.png';
                $image_found = false;
            }
        }
        ?>
        <link href="<?php echo $app->BASE_URL('public/assets/css/smoothproducts.css'); ?>"
              rel="stylesheet" type="text/css">
        <div class="row ajax-content">
            <div class="col-xs-12">
                <div class="card-box product-detail-box">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="sp-loading"><img
                                        src="<?php echo $app->BASE_URL('public/assets/images/sp-loading.gif'); ?>"
                                        alt=""><br>LOADING IMAGES
                            </div>
                            <div class="sp-wrap">
                                <a href="<?php echo $app->BASE_URL('public/uploads/images/' . numhash($item['ID']) . '/' . $ad_images[0]); ?>"><img
                                            src="<?php echo $app->BASE_URL('public/uploads/images/' . numhash($item['ID']) . '/' . $ad_images[0]); ?>"
                                            alt=""></a>
                            </div>

                        </div>

                        <div class="col-sm-8">
                            <div class="product-right-info">
                                <h2 class="price-title font-35 text-white"><b><?php echo $item['Name']; ?></b></h2>
                                <h3 class="pull-right text-danger" style="margin-top: -40px">
                                    <b><?php echo number_format($item['Price']); ?> L.E</b></h3>
                                <h5 class="m-t-20">
                                    <b>By <?php echo account::State($item['User'], $app->UserRates($item['User'])); ?></b></h5>
                                <hr>
                                <table class="table table-hover m-0">
                                    <thead>
                                    <tr>
                                        <th>Condition</th>
                                        <th>Brand</th>
                                        <?php
                                        if (key(Store::$category_data[$item['Category']]) != 'Brands') {
                                            ?>
                                            <th><?php echo key(Store::$category_data[$item['Category']]); ?></th>
                                            <?php
                                        }
                                        ?>
                                        <th>
                                            Rating
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?php echo $item['Cond']; ?></td>
                                        <td><?php echo $item['Brand']; ?></td>
                                        <?php
                                        if (key(Store::$category_data[$item['Category']]) != 'Brands') {
                                            ?>
                                            <td><?php echo !empty($item['extData']) ? $item['extData'] : Store::$category_data[$item['Category']][key(Store::$category_data[$item['Category']])][0]; ?></td>
                                            <?php
                                        }
                                        ?>

                                        <td>
                                            <div class='rating-stars'
                                                 data-total="<?php echo number_format($app->ItemRates($item['ID'])); ?>"
                                                 data-item="<?php echo numhash($item['ID']); ?>">
                                                <ul id='stars'>
                                                    <li class='star star-1' title='Poor' data-value='1'>
                                                        <i class='fa fa-star fa-fw'></i>
                                                    </li>
                                                    <li class='star star-2' title='Fair' data-value='2'>
                                                        <i class='fa fa-star fa-fw'></i>
                                                    </li>
                                                    <li class='star star-3' title='Good' data-value='3'>
                                                        <i class='fa fa-star fa-fw'></i>
                                                    </li>
                                                    <li class='star star-4' title='Excellent' data-value='4'>
                                                        <i class='fa fa-star fa-fw'></i>
                                                    </li>
                                                    <li class='star star-5' title='WOW!!!' data-value='5'>
                                                        <i class='fa fa-star fa-fw'></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <script type="application/javascript">
                                            function showRates(value) {
                                                $('#stars').children('li.star').each(function (e) {
                                                    if (e <= value) {
                                                        $('.star-' + e).addClass('selected');
                                                    } else {
                                                        $('.star-' + e).removeClass('hover');
                                                    }
                                                });
                                            }
                                            showRates($('.rating-stars').data('total'));
                                        </script>
                                    </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <h5 class="font-600">Product Description</h5>

                                <?php echo $item['Description']; ?>
                                <hr>
                                <?php if ($image_found == true) { ?>
                                    <h5 class="font-600">More Images</h5>

                                    <div class="owl-carousel owl-theme" id="owl-multi">
                                        <?php
                                        $i = 1;
                                        foreach ($ad_images as $img) {
                                            if (file_exists('public/uploads/images/' . numhash($item['ID']) . '/' . $img)) {
                                                $ad_image = 'public/uploads/images/' . numhash($item['ID']) . '/' . $img;

                                                if ($ad_image != $images && $img != '') {
                                                    ?>
                                                    <div class="item">
                                                        <a href="<?php echo $app->BASE_URL($ad_image); ?>"
                                                           class="popup"
                                                           title="<?php echo $item['Name']; ?> Preview <?php echo $i; ?>">
                                                            <img src="<?php echo $app->BASE_URL($ad_image); ?>"
                                                                 class="thumb-img img-responsive"
                                                                 alt="<?php echo $item['Name']; ?> Preview <?php echo $i; ?>">
                                                        </a>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            $i++;
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>

                                <div class="m-t-30">
                                    <a data-toggle="tooltip" data-placement="top" title=""
                                       data-animation="fadein"
                                       data-id="<?php echo numhash($item['ID']); ?>"
                                       data-plugin="custommodal" data-overlayspeed="200"
                                       data-overlaycolor="#36404a" href=".report-item"
                                       data-original-title="Report this item"
                                       class="btn-danger btn on-default report-item-button"><i
                                                class="fa fa-exclamation-triangle"></i></a>

                                    <a data-toggle="tooltip" data-placement="top" title=""
                                       href="<?php echo $app->BASE_URL('account/messenger/' . numhash($item['ID']) . '-' . $item['User']); ?>"
                                       data-original-title="Contact User"
                                       class="btn btn-white waves-effect waves-light m-l-10">
                                                     <span class="btn-label"><i class="fa fa-envelope-o"></i>
                                                   </span>Send Message
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div> <!-- end card-box/Product detai box -->
            </div> <!-- end col -->
            <div class="modal-demo text-left report-item">
                <div class="custom-modal-dialog">
                    <div class="custom-modal-content">
                        <div class="custom-modal-header">

                            <button type="button" class="close" onclick="Custombox.close();"
                                    aria-hidden="true">×
                            </button>
                            <h4 class="custom-modal-title">Report ( <?php echo $item['Name']; ?> )
                            </h4>
                        </div>

                        <div class="custom-modal-text">
                            <form action="" method="POST" class="report-item-form">
                                <input name="id" type="hidden" value="<?php echo numhash($item['ID']); ?>">
                                <div class="form-group">
                                    <label for="reason" class="control-label">Reason : </label>
                                    <select class="form-control" id="reason" name="reason">
                                        <option value="Wrong information" selected>Wrong information</option>
                                        <option value="Scam">Scam</option>
                                        <option value="Another reason">Another reason</option>
                                        <option value="Item already sold">Item already sold</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <textarea name="reason_text" maxlength="255" id="reason_text"
                                              placeholder="additional comment" class="form-control"></textarea>
                                </div>
                        </div>

                        <div class="panel-footer">

                            <button type="submit"
                                    class="btn btn-danger waves-effect waves-light"><i
                                        class="fa fa-exclamation-triangle"></i> Report
                            </button>
                            </form>
                            <button type="button" class="btn btn-default waves-effect pull-right "
                                    onclick="Custombox.close();"><i class="fa fa-times"></i> Close
                            </button>

                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-demo text-left contact-item">
                <div class="custom-modal-dialog">
                    <div class="custom-modal-content">
                        <div class="custom-modal-header">

                            <button type="button" class="close" onclick="Custombox.close();"
                                    aria-hidden="true">×
                            </button>
                            <h4 class="custom-modal-title">Buy ( <?php echo $item['Name']; ?> )
                            </h4>
                        </div>

                        <div class="custom-modal-text">

                            <form action="" method="POST" class="contact-form">
                                <input name="id" type="hidden" value="<?php echo numhash($item['ID']); ?>">
                                <div class="form-group">
                                    <button type="button" onclick="$(this).text('0<?php echo $user['Mobile']; ?>');"
                                            class="btn btn-block btn-lg btn-inverse waves-effect waves-light">Show
                                        Mobile Number
                                    </button>
                                </div>
                                <div class="form-group">
                                    <textarea name="contact_msg" maxlength="255" id="contact_msg"
                                              placeholder="Enter your message here"
                                              class="form-control">Hello <?php echo $item['User']; ?>, i want to buy ( <?php echo $item['Name']; ?> ). &#13;&#10;Please contact me asap.</textarea>
                                </div>
                        </div>

                        <div class="panel-footer">

                            <button type="submit"
                                    class="btn btn-primary waves-effect waves-light"><i
                                        class="fa fa-send"></i> Send
                            </button>
                            </form>
                            <button type="button" class="btn btn-default waves-effect pull-right "
                                    onclick="Custombox.close();"><i class="fa fa-times"></i> Close
                            </button>

                        </div>

                    </div>
                </div>
            </div>
            <?php
            $dat['user'] = $item['User'];
            $dat['Status'] = 'true';
            $others = $app->get_items($dat);
            if (!empty($others)) {
                ?>
                <div class="col-xs-12" style="margin-bottom: 50px">
                    <hr>
                    <h5 class="font-600"><?php echo $item['User']; ?>`s Ads</h5>

                    <?php
                    foreach ($others as $ad) {
                        if ($ad['ID'] != $item['ID'] && $ad['Status'] != 0 && $ad['Status'] != 3) {
                            $ad_image = explode('-', $ad['images']);
                            $image_found = false;
                            foreach ($ad_image as $image) {
                                if ($image_found != true) {
                                    if (file_exists('public/uploads/images/' . numhash($ad['ID']) . '/' . $image)) {
                                        $ad_image = 'public/uploads/images/' . numhash($ad['ID']) . '/' . $image;
                                        $image_found = true;
                                    } else {
                                        $ad_image = 'public/uploads/images/no-thumbnail.png';
                                        $image_found = false;
                                    }
                                }
                            }
                            ?>
                            <div class="col-md-4 col-xl-3 static-products">
                                <div class="product-list-box thumb">
                                    <a class="image-popup"
                                       href="<?php echo $app->BASE_URL('Products/' . numhash($ad['ID'])); ?>">
                                        <img src="<?php echo $app->BASE_URL($ad_image); ?>"
                                             alt="product-pic" class="thumb-img"></a>
                                    <div class="price-tag">
                                        <?php echo number_format($ad['Price']); ?> L.E
                                        <br>
                                        <?php echo Store::status($ad['Status']); ?>
                                    </div>
                                    <div class="detail">
                                        <a href="<?php echo $app->BASE_URL('Products/' . numhash($ad['ID'])); ?>"
                                           class="text-white price-title m-0"> <?php echo $ad['Name']; ?></a>
                                        <h5 class="m-0"><span
                                                    class="text-muted"> <?php echo $ad['Category']; ?> , <?php echo $ad['Cond']; ?></span>
                                        </h5>
                                        <h5 class="m-b-5"><?php echo $ad['Date']; ?></h5>

                                    </div> <!-- end row -->
                                </div> <!-- end product info-->
                            </div>
                        <?php }
                    }
                    ?>
                </div>
            <?php } ?>
        </div>
        </div>

    <?php } else {
        $url = $app->BASE_URL('403');
        header("Location: $url");
    }
} else {
    $url = $app->BASE_URL('404');
    header("Location: $url");
} ?>

