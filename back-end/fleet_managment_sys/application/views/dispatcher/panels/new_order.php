<script>
    //TODO: move this scripts to separate file like dispatcher.js in assets file
    var dispatchDetails = {};
    function allowDispatchCab(refId) {
//        closeAll();
//        $("#newOrdersPane").fadeOut('slow');
        /* $.UIkit.notify({
         message: "Order: " + refId + " selected for dispatch!",
         status: 'success',
         timeout: 0,
         pos: 'top-center'
         });
         currentDispatchOrderRefId = refId;*/

        var zone = dispatchDetails.zone;
        var cab = dispatchDetails.cab;

        var dispatchNotify = $.UIkit.notify({
            message: '<span style="color: dodgerblue">Dispatching order <b>' + refId + '</b></span>',
            status: 'warning',
            timeout: 0,
            pos: 'top-center'
        });

        sendingData = {};
        sendingData.cabId = cab.id;
        sendingData.orderId = refId;
        $("#orderBuilder").html('');
        $.post('dispatcher/dispatchVehicle', sendingData, function (dispatchedOrder) {
            console.log(dispatchedOrder);
            setTimeout(function () {
                dispatchNotify.close()
            }, 3000);
            dispatchNotify.status('success');
            dispatchNotify.content("Order Dispatched successfully!");

            var orderDOM = $('#liveOrdersList').find('#' + sendingData.orderId);
            $(orderDOM).fadeOut().remove();


            var dispatchedOrderUnixTimeStamp = dispatchedOrder.dispatchTime.sec;
            var orderBookingTime = moment.unix(dispatchedOrderUnixTimeStamp);

            var $fromNowSpan = $("<span>", {class: "text-warning fromNow"});
            var $orderStatus = $("<span>", {class: "label label-info"}).text(dispatchedOrder.status);
            var $labelSpan = $("<span>", {class: "label label-info"}).css({float: 'right'}).text(dispatchedOrder.refId);

            var $order = $("<a>", {
                id: dispatchedOrder.refId,
                class: "list-group-item",
                onclick: "disengageOrder(this.id);return false"
            })
                .attr('data-bookTime', dispatchedOrderUnixTimeStamp).text(orderBookingTime.format('Do-MMM-YY  H:mm')).append($fromNowSpan).append($orderStatus).append($labelSpan);

            $order.appendTo('#dispatchedOrdersList .mCSB_container');

            delete unDispatchedOrders[dispatchedOrder.refId];

            // TODO: dehan's work i have done a temp fix
            cab.state = "MSG_NOT_COPIED";
            zone.idle.cabs.remove(cab);
            locVM.pendingCabs.push(cab);
        });


    }

    function delayInform(refId) {
//        console.log("refId = "+refId);
        closeAll();
        var minutes = $('#delayInforMinutes').val();
        $.post('dispatcher/delayInform', {refId: refId, minutes: minutes}, function (response) {
            $.UIkit.notify({
                message: "Delay informed to all CROs",
                status: 'success',
                timeout: 3000,
                pos: 'top-center'
            });
        });
    }
</script>
<div class="modal-body">

    <p class="text-info text-center">Booking details of #<?= $newOrder['refId'] ?></p>

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

            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?= $customerProfile['title'] . ". " . $customerProfile['name'] ?> </h3>
                </div>
                <div class="panel-body">
                    <span>Job Count  :</span>
                    <span class="text-primary"><?= $customerProfile['tot_job'] ?></span>
                    <br/>

                    <span>Cancel [T]  :</span>
                    <span class="text-danger"><?= $customerProfile['tot_cancel'] ?></span>
                    <br/>

                    <span>Cancel [D]  :</span>
                    <span class="text-danger"><?= $customerProfile['dis_cancel'] ?></span>
                    <br/>
                    <!--                        <img class="img-responsive center-block" src="-->
                    <? //= base_url() ?><!--assets/img/cabs/--><? //= $newOrder['vType'] ?><!--.png" alt="-->
                    <? //= $newOrder['vType'] ?><!--">-->

                </div>
            </div>
        </div>

    </div>


    <div class="row">
        <div class="btn-group btn-group-justified" role="group" aria-label="Justified button group">
            <?php if ($newOrder['isVip']): ?>

                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default">
                        VIP <?= getBadge($newOrder['isVip']) ?>
                    </button>
                </div>
            <?php endif ?>


            <?php if ($newOrder['isVih']): ?>

                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default">
                        VIH <?= getBadge($newOrder['isVih']) ?>

                    </button>
                </div>
            <?php endif ?>

            <?php if ($newOrder['isTinted']): ?>

                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default">
                        Tinted <?= getBadge($newOrder['isTinted']) ?>
                    </button>
                </div>
            <?php endif ?>

            <?php if ($newOrder['isUnmarked']): ?>

                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default">
                        Unmarked <?= getBadge($newOrder['isUnmarked']) ?>
                    </button>
                </div>
            <?php endif ?>

        </div>

    </div>
    <br/>


    <div class="row">

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

            <div class="input-group input-group-sm">
                <span class="input-group-addon">Type:</span>
                <input class="form-control" disabled type="text"
                       value="<?= $newOrder['vType'] ?>"/>
            </div>
            <br>

            <div class="input-group input-group-sm">
                <span class="input-group-addon" style="padding: 0px;margin: 0px;width: 90px;">
                    <button class="btn btn-warning btn-xs" type="button"
                            onclick="delayInform(<?= $newOrder['refId'] ?>)">Delay inform
                    </button>
                </span>
                <input id="delayInforMinutes" autocomplete="off" type="text" class="form-control"
                       style="text-align: right" placeholder="Request minutes"/>
                <span class="input-group-addon">min</span>
            </div>
        </div>


        <div class="col-md-6" id="assignedCab">
            <div class="well well-sm text-center">
                Select a cab.
            </div>
        </div>

        <div style="margin-bottom: -15px" class="btn-group btn-group-justified">
            <div class="btn-group">
                <button style="background-color: #428bca;color: rgb(202, 255, 215);" type="button"
                        class="btn btn-default"
                        onclick="allowDispatchCab(<?= $newOrder['refId'] ?>)">Confirm and dispatch
                </button>
            </div>
            <div class="btn-group">
                <button style="background-color: #f0ad4e;color: #000000" type="button" class="btn  btn-default"
                        onclick="$('#commonModal').modal('toggle').find('.modal-content').load('dispatcher/cancel_reason/<?= $newOrder['refId'] ?>');return false;">Cancel order
                </button>
            </div>
            <!--<div class="btn-group">-->
            <!--<button style="background-color: #f4f4f4;" type="button" class="btn  btn-default" onclick="closeAll()">Cancel</button>-->
            <!--</div>-->
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