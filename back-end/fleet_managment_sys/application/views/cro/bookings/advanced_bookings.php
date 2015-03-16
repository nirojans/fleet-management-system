<div class="panel panel-default">
    <div class="panel-heading">
        <h5 class="panel-title">Advanced Bookings</h5>
    </div>

    <div class="panel-body" >
<?php if(isset($data) && sizeof($data) != 0):?>
    <table class="table table-striped" ><tr>
            <th>Status</th>
            <th>Ref ID</th>
            <th>Telephone</th>
            <th>Call Time</th>
            <th>Book Time</th>
            <th>Address</th>
            <th>Driver Id</th>
            <th>Cab Id</th>
            <th>Remark</th>
            <th>Cooperate</th>
        </tr>
        <?php foreach (array_reverse($data) as $item):?>
            <tr>
                <td><?= $item['status'];?></td>
                <td><?= $item['refId'];?></td>
                <td><?= $item['tp'];?></td>
                <td><?=  date('jS-M-y  H:i', $item['callTime']->sec);?></td>
                <td><?=  date('jS-M-y  H:i', $item['bookTime']->sec);?></td>
                <td><?= implode(", ", $item['address']);?></td>
                <td><?= $item['driverId'];?></td>
                <td><?= $item['cabId'];?></td>
                <td><?= $item['remark'];?></td>
                <td><?php if($item['bookingType'] == "Personal") echo "No" ; else "Yes" ;?></td>
            </tr>
        <?php endforeach;?>

    </table>
<?php endif?>

<?php if(!isset($data)):?>
    <div class="col-lg-offset-5 col-lg-5">
        <h4>No Advanced Bookings Available </h4>
    </div>
<?php endif;?>
    </div>

</div>