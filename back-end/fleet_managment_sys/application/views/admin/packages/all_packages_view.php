<table class="table table-striped" >
    <tr>
        <th>Package Id</th>
        <th>Package Name</th>
        <th>Drop Fee</th>
        <th>Both Way Fee</th>
        <th>Guest Carrier Fee</th>
        <th>Out Side Fee</th>
        <th>Info</th>
        <th>Action</th>


    </tr>


    <?php foreach ($data as $item):?>
        <?php if($item['feeType'] == 'airport') {?>
        <tr>
            <td><p id="<?= $item['packageId'];?>"><?= $item['packageId'];?></p></td>
            <td><p id="<?= $item['packageName'];?>"><?= $item['packageName'];?></p></td>
            <td><?= $item['dropFee'];?></td>
            <td><?= $item['bothwayFee'];?></td>
            <td><?= $item['guestCarrierFee'];?></td>
            <td><?= $item['outsideFee'];?></td>
            <td><?= $item['info'];?></td>
            <td><button type="submit" class="btn btn-default" onclick="makePackagesFormEditable('<?= $item['packageId'];?>')">Edit</button></td>
        </tr>
        <?php } ?>
    <?php endforeach;?>
</table>

<table class="table table-striped" >
    <tr>
        <th>Package Id</th>
        <th>Package Name</th>
        <th>Distance</th>
        <th>Hours</th>
        <th>Fee</th>
        <th>Info</th>
        <th>Action</th>


    </tr>


    <?php foreach ($data as $item):?>
        <?php if($item['feeType'] == 'day') {?>
            <tr>
                <td><p id="<?= $item['packageId'];?>"><?= $item['packageId'];?></p></td>
                <td><p id="<?= $item['packageName'];?>"><?= $item['packageName'];?></p></td>
                <td><?= $item['km'];?></td>
                <td><?= $item['hours'];?></td>
                <td><?= $item['fee'];?></td>
                <td><?= $item['info'];?></td>
                <td><button type="submit" class="btn btn-default" onclick="makePackagesFormEditable('<?= $item['packageId'];?>')">Edit</button></td>
            </tr>
        <?php } ?>
    <?php endforeach;?>
</table>
