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
?>
<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <div class="row pag" data-perpage="<?php echo $app->per_page; ?>"></div>
        </div> <!-- end card-box -->
    </div> <!-- end col-->
</div>
<script>
    function n(s){
        $.ajax({
            type:"post",
            url:"<?php echo $app->BASE_URL('controllers/ajax.php');?>?request=search",
            data:s,
            beforeSend:function(){
                $(".ajax-content").html("");
                    $(".ajax-content").html('<div class="block-disabled"><div class="loader-1"></div></div>');
                    },
            success:function(e){
                var i=$.parseJSON(e);
                $(".block-disabled").remove();
                $('.app-search').find('.form-control').val('<?php echo $data;?>');
                window.history.pushState("", "Search result for "+s.split("=")[1], orign+'search/'+s.split("=")[1]),console.log(e),"undefined"!=i.data&&($(".ajax-content").data("counter",i.data.length),$.each(i.data,function(e,i){var n='<div class="col-md-4 col-xl-3 static-products"><div class="product-list-box thumb '+i.Brand+" "+i.Cond+'"><a class="image-popup" href="'+i.link+'"><img src="'+i.images+'" alt="product-pic" class="thumb-img"></a><div class="price-tag">'+i.Price+" L.E<br>"+i.Status+'</div><div class="detail"><a href="'+i.link+'" class="text-white price-title m-0"> '+i.Name+'</a><h5 class="m-0"><span class="text-muted"> '+i.Category+" , "+i.Cond+", "+i.Brand+'</span></h5><h5 class="m-b-5">'+i.Date+"</h5></div></div></div>";$(".ajax-content").append(n)}),Math.round($(".ajax-content").data("counter")/$(".pag").data("perpage"))<=1&&($(".bootpag").html(""),$(".bootpag").append('<li data-lp="1" class="prev disabled"><a href="javascript:void(0);">«</a></li>'),$(".bootpag").append('<li data-lp="1" class="active"><a href="javascript:void(0);">1</a></li>'),$(".bootpag").append('<li data-lp="1" class="next disabled"><a href="javascript:void(0);">»</a></li>')),$(".ajax-content").attr("data-search",$(".app-search input").val()),$(".content-page .content").append("</div></div>"))}})}
    n('search=<?php echo $data;?>');
</script>
<div class="row ajax-content"  data-counter="6">

</div>
