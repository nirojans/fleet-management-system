<div class="col-lg-12">

    <div class="panel panel-danger">
        <!-- Default panel contents -->
        <div class="panel-heading text-center">Not Dispatched</div>

    <table class="table table-striped" >
        <tr>
            <th>Ref #</th>
            <th>R.Q Time</th>
            <th>MR</th>
            <th>Address</th>
            <th>Agent</th>
            <th>Inquiries</th>
            <th>DIM</th>
            <th>VIH</th>
            <th>VIP</th>
            <th>Cop</th>
        </tr>

        <?php foreach ($data as $item):?>
            <?php if($item['status'] == 'START'):?>
            <tr>
                <td id="refId"><?= $item['refId'] ?></td>
                <td id="rqTime"><?= date('jS-M-y  H:i', $item['bookTime']->sec) ?></td>
                <td class="dynamicTimeUpdate" data-basetime="<?= $item['bookTime']->sec ?>" id="mr">MR</td>
                <td id="address"><?= implode(", ", $item['address']) ?></td>
                <td id="agent"><?= $item['croId'] ?></td>
                <td><?= $item['inqCall'] ?></td>
                <td><?= getBadge(false) ?></td>
                <td><?= getBadge($item['isVih']) ?></td>
                <td><?= getBadge($item['isVip']) ?></td>
                <td><?= getBadge(false) ?></td>
            </tr>
            <?php endif;?>
        <?php endforeach;?>

    </table>
        </div>
    </div>

<div class="col-lg-12">
    <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading text-center">Message not copied</div>

            <table class="table table-striped" >
                <tr>
                    <th>Ref #</th>
                    <th>R.Q Time</th>
                    <th>MST</th>
                    <th>Cab #</th>
                    <th>Driver mobile</th>
                    <th>Address</th>
                    <th>Agent</th>
                    <th>Inquiries</th>
                    <th>DIM</th>
                    <th>VIH</th>
                    <th>VIP</th>
                    <th>Cop</th>
                </tr>

                <?php foreach ($data as $item):?>
                    <?php if($item['status'] == 'MSG_NOT_COPIED'):?>
                        <tr>
                            <td id="refId"><?= $item['refId'] ?></td>
                            <td id="rqTime"><?= date('jS-M-y  H:i', $item['bookTime']->sec) ?></td>
                            <td id="mst"><?= date('jS-M-y  H:i', $item['dispatchTime']->sec) ?></td>
                            <td id="cabId"><?= $item['cabId'] ?></td>

                            <td id="driverMobile"><?php $driver = $this->user_dao->getUser($item['driverId'],'driver'); echo($driver['tp']) ?></td>

                            <td id="address"><?= implode(", ", $item['address']) ?></td>
                            <td id="agent"><?= $item['croId'] ?></td>
                            <td>Inquiries</td>
                            <td><?= getBadge(false) ?></td>
                            <td><?= getBadge($item['isVih']) ?></td>
                            <td><?= getBadge($item['isVip']) ?></td>
                            <td><?= getBadge(false) ?></td>
                        </tr>
                    <?php endif;?>
                <?php endforeach;?>
            </table>
    </div>
</div>

<div class="col-lg-12">
    <div class="panel panel-success">
        <!-- Default panel contents -->
        <div class="panel-heading text-center">Message Copied</div>

            <table class="table table-striped" >
                <tr>
                    <th>Ref #</th>
                    <th>R.Q Time</th>
                    <th>MST</th>
                    <th>Cab #</th>
                    <th>Driver mobile</th>
                    <th>Address</th>
                    <th>Agent</th>
                    <th>Inquiries</th>
                    <th>DIM</th>
                    <th>VIH</th>
                    <th>VIP</th>
                    <th>Cop</th>
                </tr>

                <?php foreach ($data as $item):?>
                    <?php if($item['status'] == 'MSG_COPIED'):?>
                        <tr>
                            <td id="refId"><?= $item['refId'] ?></td>
                            <td id="rqTime"><?= date('jS-M-y  H:i', $item['bookTime']->sec) ?></td>
                            <td id="mst"><?= date('jS-M-y  H:i', $item['dispatchTime']->sec) ?></td>
                            <td id="cabId"><?= $item['cabId'] ?></td>

                            <td id="driverMobile"><?php $driver = $this->user_dao->getUser($item['driverId'],'driver'); echo($driver['tp']) ?></td>

                            <td id="address"><?= implode(", ", $item['address']) ?></td>
                            <td id="agent"><?= $item['croId'] ?></td>
                            <td>Inquiries</td>
                            <td><?= getBadge(false) ?></td>
                            <td><?= getBadge($item['isVih']) ?></td>
                            <td><?= getBadge($item['isVip']) ?></td>
                            <td><?= getBadge(false) ?></td>
                        </tr>
                    <?php endif;?>
                <?php endforeach;?>

            </table>
        </div>
</div>

<div class="col-lg-12">
<div class="panel panel-info">
    <!-- Default panel contents -->
    <div class="panel-heading text-center">At the Place</div>

    <!-- Table -->
    <table class="table" id="AT_THE_PLACE">
        <thead>
        <tr>
            <th>Ref #</th>
            <th>R.Q Time</th>
            <th>Message copied time</th>
            <th>Cab #</th>
            <th>Driver mobile</th>
            <th>Address</th>
            <th>Agent</th>
            <th>Inquiries</th>
            <th>DIM</th>
            <th>VIH</th>
            <th>VIP</th>
            <th>Cop</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $item):?>
        <?php if($item['status'] == 'AT_THE_PLACE'):?>
                <tr id="<?= $item['refId'] ?>">
                    <td id="refId"><?= $item['refId'] ?></td>
                    <td id="rqTime"><?= date('jS-M-y  H:i', $item['bookTime']->sec) ?></td>
                    <td id="mct"><?= date('jS-M-y  H:i', $item['dispatchTime']->sec) ?></td>
                    <td id="cabId"><?= $item['cabId'] ?></td>

                    <td id="driverMobile"><?php $driver = $this->user_dao->getUser($item['driverId'], 'driver');
                        echo($driver['tp']) ?></td>

                    <td id="address"><?= implode(", ", $item['address']) ?></td>
                    <td id="agent"><?= $item['cro']['name'] ?></td>
                    <td><?= $item['inqCall'] ?></td>
                    <td><?= getBadge(false) ?></td>
                    <td><?= getBadge($item['isVih']) ?></td>
                    <td><?= getBadge($item['isVip']) ?></td>
                    <td><?= getBadge(false) ?></td>
                </tr>
            <?php endif; endforeach;  ?>
        </tbody>
    </table>
</div>
</div>

<div class="col-lg-12">
    <div class="panel panel-success">
        <!-- Default panel contents -->
        <div class="panel-heading text-center">POB</div>
            <table class="table table-striped" >
        <tr>

            <th>Ref #</th>
            <th>R.Q Time</th>
            <th>POB Time</th>
            <th>On hire time</th>
            <th>Cab #</th>
            <th>Driver mobile</th>
            <th>Address</th>
            <th>Agent</th>
            <th>Inquiries</th>
            <th>DIM</th>
            <th>VIH</th>
            <th>VIP</th>
            <th>Cop</th>

            <th>Location</th>

        </tr>

        <?php foreach ($data as $item):?>
            <?php if($item['status'] == 'POB'):?>
                <tr>
                    <td id="refId"><?= $item['refId'] ?></td>
                    <td id="rqTime"><?= date('jS-M-y  H:i', $item['dispatchTime']->sec) ?></td>
                    <td id="mct"><?= date('jS-M-y  H:i', $item['lastUpdatedOn']->sec) ?></td>
                    <td class="dynamicTimeUpdate" data-basetime="<?= $item['lastUpdatedOn']->sec ?>" id="mr">ONH</td>
                    <td id="cabId"><?= $item['cabId'] ?></td>

                    <td id="driverMobile"><?php $driver = $this->user_dao->getUser($item['driverId'], 'driver');
                        echo($driver['tp']) ?></td>

                    <td id="address"><?= implode(", ", $item['address']) ?></td>
                    <td id="agent"><?php if(isset($item['cro']['name'] ))echo $item['cro']['name']; else '-' ?></td>
                    <td><?= $item['inqCall'] ?></td>
                    <td><?= getBadge(false) ?></td>
                    <td><?= getBadge($item['isVih']) ?></td>
                    <td><?= getBadge($item['isVip']) ?></td>
                    <td><?= getBadge(false) ?></td>
                    <td>N/A</td>
                    <!--                    TODO: remove isset check after all the orders have dispatcherId attribute -->

                </tr>
            <?php endif;?>
        <?php endforeach;?>

    </table>
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
