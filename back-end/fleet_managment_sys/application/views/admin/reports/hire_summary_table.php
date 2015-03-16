<table class="table table-striped" >
    <tr>
        <th>Cab ID</th>
        <th>Driver ID</th>
        <th>Calling No</th>
        <th>Log Sheet No</th>
        <th>Time On</th>
        <th>Time Off</th>
        <th>No Of Hires</th>
        <th>Cancel</th>
        <th>Drop</th>
        <th>BothWay</th>
        <th>Guest Carrier</th>
        <th>Out Side</th>
        <th>PACK</th>
        <th>Others</th>
        <th>Remarks</th>

    </tr>


    <?php foreach ($data as $item):?>

        <tr>
            <td><?= $item['cabId'];?></td>
            <td><?= $item['userId'];?></td>
            <td><?= $item['callingNumber'];?></td>
            <td><?php if(isset($item['logSheetNumber'])) {echo $item['logSheetNumber'];}else{echo "-1";}?></td>
            <td><?= $item['timeOn'];?></td>
            <td><?= $item['timeOut'];?></td>
            <td><?= $item['hires'];?></td>
            <td><?= $item['cancel'];?></td>
            <td><?= $item['drop'];?></td>
            <td><?= $item['bothway'];?></td>
            <td><?= $item['guestCarrier'];?></td>
            <td><?= $item['outside'];?></td>
            <td><?= $item['day'];?></td>
            <td><?= $item['normal'];?></td>
            <td></td>

        </tr>

    <?php endforeach;?>
</table>