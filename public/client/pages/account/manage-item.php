<?php
/**
 * Created by PhpStorm.
 * User: Legacy
 * Date: 7/15/2018
 * Time: 2:45 PM
 */
if (!isset($user_logged)) {
    header("Location: ../index.php");
}
$title = $app->siteName . ' - Manage items';
require 'public/client/header.php';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="btn-group pull-right m-t-15">
            <a class="btn btn-default waves-effect waves-light" data-animation="fadein" data-plugin="custommodal"
               data-overlayspeed="200"
               data-overlaycolor="#36404a" href=".new-item-model">Add Item <span class="m-l-5"><i
                            class="fa fa-plus"></i></span>
            </a>
        </div>

        <h4 class="page-title">Your Items</h4>
        <ol class="breadcrumb">
            <li>
                <a href="#">Account</a>
            </li>
            <li class="active">
                Manage items
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="card-box">
        <div class="table-responsive">
        <table class="table text-center data-table table-hover table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Price</th>
                <th>Condition</th>
                <th>Date</th>

                <th>Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            <?php
            $data['user'] = $user_logged;
            foreach ($app->get_items($data) as $item) { ?>
                <tr>
                    <td><?php echo $item['Name']; ?></td>
                    <td><?php echo $item['Brand']; ?></td>
                    <td><?php echo $item['Category']; ?></td>
                    <td><?php echo number_format($item['Price']); ?></td>
                    <td><?php echo $item['Cond']; ?></td>
                    <td><?php echo $item['Date']; ?></td>
                    <td><?php echo Store::status($item['Status']); ?><br><?php echo $item['reason']; ?></td>
                    <td align="center">
                        <a href="<?php echo $app->BASE_URL('Products/' . numhash($item['ID'])); ?>"
                           class="btn-inverse btn on-default" data-toggle="tooltip" data-placement="top" title="" data-original-title="View item"><i
                                    class="fa fa-eye"></i></a>
                        <?php if ($item['Status'] != 3) { ?>
                            <a data-toggle="tooltip" data-placement="top" title=""
                               data-animation="fadein"
                               data-id="<?php echo numhash($item['ID']); ?>"
                               data-name="<?php echo $item['Name']; ?>"
                               data-plugin="custommodal" data-overlayspeed="200"
                               data-overlaycolor="#36404a" href=".remove-item"
                               data-original-title="Remove this item"
                               class="btn-danger btn on-default remove-item-button"><i
                                        class="fa fa-trash"></i></a>
                        <?php } ?>
                        <a data-toggle="tooltip" data-placement="top" title=""
                           data-animation="fadein"
                           data-id="<?php echo numhash($item['ID']); ?>"
                           data-name="<?php echo $item['Name']; ?>"
                           data-plugin="custommodal" data-overlayspeed="200"
                           data-overlaycolor="#36404a" href=".edit-item"
                           data-original-title="Edit this"
                           class="btn-primary btn on-default edit-item-button"><i
                                    class="fa fa-edit"></i></a></td>
                </tr>
            <?php }
            ?>

            </tbody>
        </table>
    </div>
    </div>
</div>
<div class="modal-demo text-left remove-item">
    <div class="custom-modal-dialog">
        <div class="custom-modal-content">
            <div class="custom-modal-header">

                <button type="button" class="close" onclick="Custombox.close();"
                        aria-hidden="true">×
                </button>
                <h4 class="custom-modal-title">Remove item
                </h4>
            </div>

            <div class="custom-modal-text">
                <form action="" method="POST" class="remove-item-form">
                    <input id="remove-item" name="id" type="hidden" value="">
                    Are you sure you want Remove this Item ( <a class="remove-item"></a>
                    ) ? <br>
                    <h3 class="text-danger">Remember this cannot be Undone</h3>

            </div>

            <div class="custom-modal-footer">

                <button type="submit"
                        class="btn btn-danger waves-effect waves-light"><i
                            class="fa fa-trash"></i> Remove
                </button>
                </form>
                <button type="button" class="btn btn-default waves-effect pull-right "
                        onclick="Custombox.close();"><i class="fa fa-times"></i> Close
                </button>

            </div>

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
<div class="modal-demo text-left edit-item">
    <div class="custom-modal-dialog">
        <div class="custom-modal-content">
            <div class="custom-modal-header">

                <button type="button" class="close" onclick="Custombox.close();"
                        aria-hidden="true">×
                </button>
                <h4 class="custom-modal-title">Edit Item Modal
                </h4>
            </div>

            <div class="custom-modal-text">
                <form action="#" enctype="multipart/form-data" class="form-horizontal edit-item-form" data-parsley-validate="" novalidate="">
                    <input name="id" id="item_id" type="hidden" value="">
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <label for="item_name" class="control-label">Name : </label>
                            <input class="form-control" id="item_name" maxlength="32"
                                   name="Name" type="text">
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
                    <div class="form-group cateData hidden">

                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <label for="item_cond" class="control-label" style="margin-top: 4px;">Condition
                                : </label>
                            <select class="form-control" name="Cond"
                                    id="item_cond">
                                <option value="New">New</option>
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
                            <textarea class="form-control" id="item_desc" name="Description"></textarea>
                        </div>
                    </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label for="item_status">Status</label>
                                <select class="form-control show-tick" name="Status" data-style="btn-inverse"
                                        id="item_status">
                                    <option value="1">Available</option>
                                    <option value="2">Sold</option>
                                </select>
                            </div>
                        </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label for="item_images2">Images</label>
                            <input type="file" name="reimages[]" id="item_images2" multiple class="filestyle">
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