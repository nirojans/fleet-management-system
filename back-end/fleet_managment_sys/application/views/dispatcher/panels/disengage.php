<script>
    //TODO: move this scripts to separate file like dispatcher.js in assets file

    function disengageCab(orderRefId) {

        var disengageReason =$('input[name=cancelReason]:checked').val();
        console.log("DEBUG: cancelReason = "+disengageReason);
        closeAll();
        $.UIkit.notify({
            message: "Disengaging order <b>" + orderRefId + "</b>",
            status: 'info',
            timeout: 3000,
            pos: 'top-center'
        });
        $.post('dispatcher/disengageCab', {refId: orderRefId,'disengageReason' : disengageReason}).done(
        function (disengagedOrder) {
            console.log(disengagedOrder);
            console.log("DEBUG: response");
            var newLocation = $('#newLocation').data('location');
            var cabId = $('#newLocation').data('cabid');

            var orderDOM = $('#dispatchedOrdersList').find('#' + orderRefId);
            $(orderDOM).fadeOut();
            $('#dispatchedOrdersList').find('#' + orderRefId).remove();
            unDispatchedOrders[disengagedOrder.refId] = disengagedOrder;
            addNewOrder(disengagedOrder);
            closeAll();
            $.UIkit.notify({
                message: "Order: <b>" + orderRefId + "</b> has been disengaged!",
                status: 'warning',
                timeout: 3000,
                pos: 'top-center'
            });
            locVM.setToIdleFromStringParams(newLocation,cabId);

        }

    ).
        fail(
            function () {
                $.UIkit.notify({
                    message: "Can't cancel Order: <b>" + orderRefId + "</b> Something went wrong!",
                    status: 'danger',
                    timeout: 3000,
                    pos: 'top-center'
                });
            }
        );

    }

    function resendSms(cabId,orderId){

        if(confirm("Are you sure you want to resend SMS to driver(Only)?")){
            console.log("Confirmed!");

            closeAll();
            $.UIkit.notify({
                message: "Resending message ....",
                status: 'info',
                timeout: 3000,
                pos: 'bottom-center'
            });
            $.post('dispatcher/resendDispatchSms', {orderId: orderId,'cabId' : cabId}).done(
                function (data) {
                    console.log(data);
                    closeAll();
                    $.UIkit.notify({
                        message: "Message resend to cab number <b>" + cabId + "</b>!",
                        status: 'warning',
                        timeout: 3000,
                        pos: 'bottom-center'
                    });
                }

            ).
                fail(
                function () {
                    $.UIkit.notify({
                        message: "Can't resend sms Something went wrong!",
                        status: 'danger',
                        timeout: 3000,
                        pos: 'bottom-center'
                    });
                }
            );
            return true;
        }
        else{
            console.log("Not confirmed!");
            return false;
        }
    }
</script>
<div class="modal-header"
     style="cursor: move;background: #f9f9f9;-webkit-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);-moz-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);">
    <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">
        <!-- TODO: Trigger bootstrap tooltip $('#aboutTileUrl').tooltip(); to enable tooltip -->
        Booking #<i><?= $newOrder['refId'] ?></i>
    </h4>
</div>
<div class="modal-body">

    <p class="text-info text-center">Booking details <button type="button" class="btn btn-primary btn-xs" onclick="resendSms('<?= $newOrder['cab']['cabId'] ?>','<?= $newOrder['refId'] ?>')" >Resend SMS</button></p>

    <div class="row">
        <div class="col-md-6 well well-sm">
            <?php foreach ($newOrder['address'] as $key => $addressComponents) : ?>
                <div class="input-group input-group-sm" style="margin-bottom: 5px;">
                    <span style="width: 30%" class="input-group-addon"><?= $key ?></span>
                    <input class="form-control text-center" disabled type="text" value="<?= $addressComponents ?>"/>
                </div>
            <?php endforeach ?>

        </div>
        <div class="col-md-6">
<!--            <img class="img-responsive center-block"-->
<!--                 src="--><?//= base_url() ?><!--assets/img/cabs/--><?//= $newOrder['vType'] ?><!--.png" alt="--><?//= $newOrder['vType'] ?><!--">-->
<!---->
<!--            <p class="text-center">-->
<!--                <span class="label label-success">Type:--><?//= $newOrder['vType'] ?><!--</span>-->
<!--            </p>-->
            <p class="text-info text-center"> <b>Cab Details</b> </p><hr style="padding: 0px;margin: 0px" />

            Cab ID: <span class="text-success"> <?= $newOrder['cab']['cabId'] ?> </span> <br/> <hr style="padding: 0px;margin: 0px" />
            Plate No: <span class="text-success"> <?= $newOrder['cab']['plateNo'] ?> </span> <br/> <hr style="padding: 0px;margin: 0px" />
            Model: <span class="text-success"> <?= $newOrder['cab']['model'] ?> </span><br/><hr style="padding: 0px;margin: 0px" />
            Type: <span class="text-success"> <?= $newOrder['cab']['vType'] ?> </span> <br/> <hr style="padding: 0px;margin: 0px" />
            Info No: <span class="text-success"> <?= $newOrder['cab']['info'] ?> </span><br/><hr style="padding: 0px;margin: 0px" />
            Status: <span class="text-success"> <?= $newOrder['cab']['state'] ?> </span><br/><hr style="padding: 0px;margin: 0px" />
            Color: <span class="text-success"> <?= $newOrder['cab']['color'] ?> </span><br/>

        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <ul class="list-group">
                <li class="list-group-item">
                    <?= getBadge($newOrder['isVip']) ?>
                    VIP
                </li>

                <li class="list-group-item">
                    <?= getBadge($newOrder['isVih']) ?>
                    VIH
                </li>

                <li class="list-group-item">
                    <?= getBadge($newOrder['isTinted']) ?>
                    Tinted
                </li>

                <li class="list-group-item">
                    <?= getBadge($newOrder['isUnmarked']) ?>
                    Unmarked
                </li>
            </ul>
        </div>
        <div class="col-md-6">

            <div class="input-group input-group-sm">
                <span class="input-group-addon">Remarks:</span>
                <input class="form-control" disabled type="text"
                       value="<?= $newOrder['remark'] ?>"/>
            </div>
            <br>

            <div class="input-group input-group-sm">
                <span class="input-group-addon">Dispatch before:</span>
                <input style="text-align: right" class="form-control" disabled type="text"
                       value="<?= $newOrder['dispatchB4'] ?>"/>
                <span class="input-group-addon">Min</span>
            </div>
            <br>

            <div class="input-group input-group-sm">
                <span class="input-group-addon">Order status:</span>
                <input class="form-control" disabled type="text"
                       value="<?= $newOrder['status'] ?>"/>
            </div>
            <br>

            <div class="input-group input-group-sm">
                <span class="input-group-addon">CRO ID:</span>
                <input class="form-control" disabled type="text"
                       value="<?= $newOrder['croId'] ?>"/>
            </div>
            <br>

        </div>

        <div style="margin-bottom: -15px" class="btn-group btn-group-justified">
            <div class="btn-group">
                <button style="background-color: #f0ad4e;color: #000000" type="button" class="btn  btn-default"
                        onclick="$('#commonModal').modal('show').find('.modal-content').load('dispatcher/disengage_reason/<?= $newOrder['refId'] ?>');return false;">Disengage cab
                </button>
            </div>

            <div class="btn-group">
                <button style="background-color: #f02700;color: #000000" type="button" class="btn  btn-default"
                        onclick="$('#commonModal').modal('show').find('.modal-content').load('dispatcher/cancel_reason/<?= $newOrder['refId'] ?>');return false;">Cancel order
                </button>
            </div>
            <div class="btn-group">
            <button style="background-color: #f4f4f4;" type="button" class="btn  btn-default" onclick="$('#commonModal').modal('show').find('.modal-content').load('dispatcher/finish_confirm/<?= $newOrder['refId'] ?>');return false;">Finish Order</button>
            </div>
        </div>
    </div>
</div>
<?php
function getBadge($status)
{
    $status = (bool)$status;
    if ($status) {
        $returnBadge = '<span class="badge alert-info"><span style="color: #5cb85c" class="glyphicon glyphicon-ok"></span></span>';
    } else {
        $returnBadge = '<span class="badge alert-warning"><span style="color: #d9534f" class="glyphicon glyphicon-remove"></span></span>';
    }
    return $returnBadge;
}

?>