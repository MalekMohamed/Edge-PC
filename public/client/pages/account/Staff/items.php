<?php
/**
 * Created by PhpStorm.
 * User: Strix
 * Date: 3/2/2019
 * Time: 10:53 AM
 */

if (!isset($user_logged)) {
    header("Location: ../index.php");
}
$title = 'Dashboard - Items panel';
require 'public/client/header.php';
?>
<div class="row ajax-content table-row">
    <div class="card-box">
        <div class="table-responsive">
            <table class="table text-center data-table table-hover table-bordered">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Owner</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <?php
                foreach ($app->getPendingItems() as $item) { ?>
                    <tr>
                        <td><?php echo $item['Name']; ?></td>
                        <td><?php echo $item['Brand']; ?></td>
                        <td><?php echo $item['Category']; ?></td>
                        <td><?php echo number_format($item['Price']); ?></td>
                        <td><?php echo $item['User']; ?></td>
                        <td><?php echo Store::status($item['Status']); ?></td>
                        <td align="center">
                            <a href="<?php echo $app->BASE_URL('Products/' . numhash($item['ID'])); ?>"
                               class="btn-inverse btn on-default" data-toggle="tooltip" data-placement="top" title="" data-original-title="View item"><i
                                        class="fa fa-eye"></i></a>

                                <a data-toggle="tooltip" data-placement="top" title=""
                                   data-animation="fadein"
                                   data-id="<?php echo numhash($item['ID']); ?>"
                                   data-name="<?php echo $item['Name']; ?>"
                                   data-plugin="custommodal" data-overlayspeed="200"
                                   data-overlaycolor="#36404a" href=".remove-item"
                                   data-original-title="Decline"
                                   class="btn-danger btn on-default remove-item-button"><i
                                        class="fa fa-times"></i></a>
                            <a data-toggle="tooltip" data-placement="top" title=""
                               data-animation="fadein"
                               data-id="<?php echo numhash($item['ID']); ?>"
                               data-name="<?php echo $item['Name']; ?>"
                               data-plugin="custommodal" data-overlayspeed="200"
                               data-overlaycolor="#36404a" href=".edit-item"
                               data-original-title="Edit this"
                               class="btn-primary hidden btn on-default edit-item-button"><i
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
<div class="modal-demo text-left decline-item">
    <div class="custom-modal-dialog">
        <div class="custom-modal-content">
            <div class="custom-modal-header">

                <button type="button" class="close" onclick="Custombox.close();"
                        aria-hidden="true">×
                </button>
                <h4 class="custom-modal-title">Decline item
                </h4>
            </div>

            <div class="custom-modal-text text-inverse">
                <form action="" method="POST" class="decline-item-form">
                    <input id="decline-item" name="id" type="hidden" value="">
                    <span class="text-center"> Are you sure you want decline this Item ( <a class="decline-item"></a>
                        ) ? </span><br>
                    <label for="reason" class="control-label">Reason : </label>
                    <textarea class="form-control" id="reason" name="reason"></textarea>

            </div>

            <div class="custom-modal-footer">

                <button type="submit"
                        class="btn btn-danger waves-effect waves-light pull-left"><i
                        class="fa fa-trash"></i> Remove
                </button>
                </form>
                <button type="button" class="btn btn-default waves-effect"
                        onclick="Custombox.close();"><i class="fa fa-times"></i> Close
                </button>

            </div>

        </div>
    </div>
</div>
<div class="modal-demo text-left approve-item">
    <div class="custom-modal-dialog">
        <div class="custom-modal-content">
            <div class="custom-modal-header">

                <button type="button" class="close" onclick="Custombox.close();"
                        aria-hidden="true">×
                </button>
                <h4 class="custom-modal-title">Approve item
                </h4>
            </div>

            <div class="custom-modal-text text-inverse">
                <form action="" method="POST" class="approve-item-form">
                    <input id="approve-item" name="id" type="hidden" value="">
                    Are you sure you want approve this item ( <a class="approve-item"></a>
                    ) ?

            </div>

            <div class="custom-modal-footer">

                <button type="submit"
                        class="btn btn-success waves-effect waves-light pull-left"><i
                            class="fa fa-check"></i> Approve
                </button>
                </form>
                <button type="button" class="btn btn-default waves-effect"
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
