<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Booking History</h3>
    </div>
    <div class="panel-body" >
        <div class="col-lg-12" style="max-height: 200px ; overflow: auto">
            <?php if(isset($history_booking) && sizeof($history_booking) != 0):?>
                <table class="table table-striped" ><tr>
                        <th>Status</th>
                        <th>Ref ID</th>
                        <th>Call Time</th>
                        <th>Book Time</th>
                        <th>Address</th>
                        <th>Driver Id</th>
                        <th>Cab Id</th>
                        <th>Remark</th>
                    </tr>
                    <?php foreach (array_reverse($history_booking) as $item):?>
                        <tr>
                            <td><?= $item['status'];?></td>
                            <td><?= $item['refId'];?></td>
                            <td><?=  date('H:i:s Y-m-d ', $item['callTime']->sec);?></td>
                            <td><?=  date('H:i:s Y-m-d ', $item['bookTime']->sec);?></td>
                            <td>
                                <a href="#newBooking" onclick="operations('fillAddressToBookingFromHistory', '<?= $item['_id']?>');return false;">
                                    <?= implode(", ", $item['address']);?>
                                </a>
                            </td>
                            <td><?= $item['driverId'];?></td>
                            <td><?= $item['cabId'];?></td>
                            <td><?= $item['remark'];?></td>
                        </tr>
                    <?php endforeach;?>

                </table>
            <?php endif?>

            <?php if(!isset($history_booking)):?>
                <div class="col-lg-offset-5 col-lg-5">
                    <h4>No previous bookings made</h4>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>

