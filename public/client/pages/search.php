<?php
/**
 * Created by PhpStorm.
 * User: Strix
 * Date: 3/27/2019
 * Time: 12:23 PM
 */
$data = filter_var($_GET['data'],FILTER_SANITIZE_STRING);
$title = !empty($data) ? 'Search result : ' . $data : $app->siteName;
require 'public/client/header.php';
$items = $app->search($data);
?>
<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <div class="row pag" data-perpage="<?php echo $app->per_page; ?>"></div>
        </div> <!-- end card-box -->
    </div> <!-- end col-->
</div>
<div class="row ajax-content"  data-counter="<?php echo count($items); ?>">
    <?php

    foreach ($items as $item) {
        if ($item['Status'] != 0 && $item['Status'] != 3) {
            $ad_image = explode('-', $item['images']);
            $image_found = false;
            foreach ($ad_image as $image) {
                if ($image_found != true) {
                    if (file_exists('public/uploads/images/' . numhash($item['ID']) . '/' . $image)) {
                        $images = 'public/uploads/images/' . numhash($item['ID']) . '/' . $image;
                        $image_found = true;
                    } else {
                        $images = 'public/uploads/images/no-thumbnail.png';
                        $image_found = false;
                    }
                }
            }
            ?>
            <div class="col-md-4 col-xl-3 static-products">
                <div class="product-list-box thumb  <?php echo $item['Brand']; ?> <?php echo $item['Cond']; ?>">
                    <a class="image-popup" href="<?php echo $app->BASE_URL('Products/' . numhash($item['ID'])); ?>">
                        <img src="<?php echo $app->BASE_URL($images); ?>"
                             alt="product-pic" class="thumb-img"></a>
                    <div class="price-tag">
                        <?php echo number_format($item['Price']); ?> L.E
                        <br>
                        <?php echo Store::status($item['Status']); ?>
                    </div>
                    <div class="detail">
                        <a href="<?php echo $app->BASE_URL('Products/' . numhash($item['ID'])); ?>"
                           class="text-white price-title m-0"> <?php echo $item['Name']; ?></a>
                        <h5 class="m-0"><span
                                class="text-muted"> <?php echo $item['Category']; ?> , <?php echo $item['Cond']; ?> , <?php echo $item['Brand']; ?></span>
                        </h5>
                        <h5 class="m-b-5"><?php echo $item['Date']; ?></h5>

                    </div> <!-- end row -->
                </div> <!-- end product info-->
            </div> <!-- end card-box-->
        <?php }
    }

    ?>

</div>
