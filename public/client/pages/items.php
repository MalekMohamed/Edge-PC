<?php
$cate = filter_var($_GET['category'], FILTER_SANITIZE_STRING);
if (in_array($cate, Store::$category_array)) {
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $data['cate'] = $cate;
    $data['Status'] = 0;
    $title = !empty($cate) ? $app->siteName . ' - ' . $cate : $app->siteName;
    require 'public/client/header.php';
    $cateData = Store::$category_data[$cate];
    if ($cate == 'Others') {
        $cateData['Brands'] = Store::$Brands;
    }
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-lg-8">
                        <form class="form-inline sorting-form">
                            <div class="form-group col-sm-6">
                                <label for="status-select" class="mr-2">Sort By</label>
                                <input type="hidden" value="<?php echo $cate; ?>" name="cate" id="category">
                                <select class="custom-select form-control" name="sort" id="status-select">
                                    <option value="Date" selected>Date</option>
                                    <option value="PriceLow">Price Low</option>
                                    <option value="PriceHigh">Price High</option>
                                    <option value="Cond">Condition</option>
                                </select>
                                <label for="brand-select" class="mr-2">Brands</label>
                                <input type="hidden" value="All" name="brand" id="brand">
                                <select class="custom-select form-control" id="brand-select">
                                    <option value="All" selected>All</option>
                                     <?php foreach ($cateData['Brands'] as $brands) { ?>
                                        <option value="<?php echo $brands;?>"><?php echo $brands;?></option>
                                    <?php } ?>
                                </select>
                                <button type="submit"
                                        class="btn btn-primary waves-effect waves-light"><i
                                            class="fa fa-check"></i> Apply
                                </button>
                            </div>
                        </form>
                    </div>

                </div> <!-- end row -->
                <div class="row pag" data-perpage="<?php echo $app->per_page; ?>"></div>
            </div> <!-- end card-box -->
        </div> <!-- end col-->
    </div>

    <div class="row ajax-content" data-cate="<?php echo $cate; ?>" data-sort="Date" data-brand="All" data-counter="<?php echo count($app->get_items($data)); ?>">

        <?php
        $data['page'] = $page;
        foreach ($app->get_items($data) as $item) {
            if ($item['Status'] != 0 && $item['Status'] != 3 && $item['Status'] != 4) {
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
                <div class="col-md-4 col-xl-3 static-products ">
                    <div class="product-list-box thumb <?php echo $item['Brand']; ?> <?php echo $item['Cond']; ?>">
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
                                        class="text-muted"> <?php echo $item['Category']; ?> , <?php echo $item['Cond']; ?>, <?php echo $item['Brand']; ?></span>
                            </h5>
                            <h5 class="m-b-5"><?php echo $item['Date']; ?></h5>

                        </div> <!-- end row -->
                    </div> <!-- end product info-->
                </div> <!-- end card-box-->

            <?php }
        }
        ?>
    </div>

    </div>
<?php } else {
    $url = $app->BASE_URL('errors/404');
    header("Location: $url");
} ?>

