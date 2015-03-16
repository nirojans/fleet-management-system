<script>
    function finishOrder(orderRefId){
        var orderDOM = $('#dispatchedOrdersList').find('#' + orderRefId);
        $(orderDOM).fadeOut();
        $('#dispatchedOrdersList').find('#' + orderRefId).remove();

        $.get("dispatcher/finish_order/"+orderRefId, function (response) {
            $.UIkit.notify({
                message: "Order: <b>" + orderRefId + "</b> has been finished!",
                status: 'info',
                timeout: 3000,
                pos: 'top-center'
            });

            closeAll();
        });
    }
</script>
<div class="modal-header"
     style="cursor: move;background: #f9f9f9;-webkit-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);-moz-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);">
    <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">
        <!-- TODO: Trigger bootstrap tooltip $('#aboutTileUrl').tooltip(); to enable tooltip -->
        Manually finish order <?= $order['refId'] ?>
    </h4>
</div>

<div class="modal-body">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <!--            <img class="img-responsive center-block"-->
            <!--                 src="--><? //= base_url() ?><!--assets/img/cabs/-->
            <? //= $order['vType'] ?><!--.png" alt="--><? //= $order['vType'] ?><!--">-->
            <!---->
            <!--            <p class="text-center">-->
            <!--                <span class="label label-success">Type:--><? //= $order['vType'] ?><!--</span>-->
            <!--            </p>-->
            <p class="text-info text-center"><b>Cab Details</b></p>
            <hr style="padding: 0px;margin: 0px"/>

            Cab ID: <span class="text-success"> <?= $cab['cabId'] ?> </span> <br/>
            <hr style="padding: 0px;margin: 0px"/>
            Booking # <span class="text-success"> <?= $order['refId'] ?> </span><br/>
            <hr style="padding: 0px;margin: 0px"/>
            Plate No: <span class="text-success"> <?= $cab['plateNo'] ?> </span> <br/>
            <hr style="padding: 0px;margin: 0px"/>
            Model: <span class="text-success"> <?= $cab['model'] ?> </span><br/>
            <hr style="padding: 0px;margin: 0px"/>
            Type: <span class="text-success"> <?= $cab['vType'] ?> </span> <br/>
            <hr style="padding: 0px;margin: 0px"/>
            Status: <span class="text-success"> <?= $cab['state'] ?> </span><br/>
            <hr style="padding: 0px;margin: 0px"/>
            Color: <span class="text-success"> <?= $cab['color'] ?> </span><br/>

        </div>
    </div>
    <div class="row">

        <?php if($order['status'] == "POB" or $order['status'] == "AT_THE_PLACE"): ?>
            <br/>
            <div class="alert alert-warning alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <strong>WARNING!</strong> This order state is <span class="label label-info" > <?= $order['status'] ?> </span>, cancel if you are sure about the cancellation.
            </div>
        <?php endif ?>

        <div style="margin-bottom: -15px" class="btn-group btn-group-justified">
            <div class="btn-group">
                <button style="background-color: #d9534f;" type="button" class="btn btn-default"
                        onclick="finishOrder(<?= $order['refId'] ?>)">Finish order
                </button>
            </div>

            <div class="btn-group">
                <button style="background-color: #f0e6e8;" type="button" class="btn btn-default" onclick="closeAll()">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>