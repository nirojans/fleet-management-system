<script>
    //TODO: move this scripts to separate file like dispatcher.js in assets file
    function allowDispatchCab(refId) {
        closeAll();
//        $("#newOrdersPane").fadeOut('slow');
        $.UIkit.notify({
            message: "Order: " + refId + " selected for dispatch!",
            status: 'success',
            timeout: 0,
            pos: 'top-center'
        });
        currentDispatchOrderRefId = refId;
    }

    function cancelOrder(orderRefId) {


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
        <div class="col-md-3">

            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?= $customerProfile['title'] . ". " . $customerProfile['name'] ?> </h3>
                </div>
                <div class="panel-body">
                    <span >Job Count  :</span>
                    <span class="text-primary"><?= $customerProfile['tot_job'] ?></span>
                    <br/>

                    <span >Cancel [T]  :</span>
                    <span class="text-danger"><?= $customerProfile['tot_cancel'] ?></span>
                    <br/>

                    <span >Cancel [D]  :</span>
                    <span class="text-danger"><?= $customerProfile['dis_cancel'] ?></span>
                    <br/>

                </div>
            </div>
        </div>
        <div class="col-md-3">
            <ul class="list-group">
                <?php if($newOrder['isVip']): ?>
                    <li class="list-group-item">
                        <?= getBadge($newOrder['isVip']) ?>
                        VIP
                    </li>
                <?php endif ?>

                <?php if($newOrder['isVih']): ?>
                    <li class="list-group-item">
                        <?= getBadge($newOrder['isVih']) ?>
                        VIH
                    </li>
                <?php endif ?>

                <?php if($newOrder['isTinted']): ?>
                    <li class="list-group-item">
                        <?= getBadge($newOrder['isTinted']) ?>
                        Tinted
                    </li>
                <?php endif ?>

                <?php if($newOrder['isUnmarked']): ?>
                    <li class="list-group-item">
                        <?= getBadge($newOrder['isUnmarked']) ?>
                        Unmarked
                    </li>
                <?php endif ?>

            </ul>
        </div>

    </div>
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

        <div style="margin-bottom: -15px" class="btn-group btn-group-justified">
            <div class="btn-group">
                <button style="background-color: #f4f4f4;" type="button" class="btn btn-default"
                        onclick="allowDispatchCab(<?= $newOrder['refId'] ?>)">Cancel Booking
                </button>
            </div>
            <div class="btn-group">
                <button style="background-color: #d9534f;color: #ffffaa" type="button" class="btn  btn-default"
                        onclick="confirmBooking(<?= $newOrder['refId'] ?>);">Confirm Booking
                </button>
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