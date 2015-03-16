


    <table class="table table-striped" >
        <tr>
            <th>cab ID</th>
            <th>Plate Number</th>
            <th>Vehicle Type</th>
            <th>Model</th>
            <th>Info</th>
            <th>User ID</th>
            <th>Cab Start Location</th>

        </tr>
        <?php if(isset($cabId)){ ?>
            <tr>
                <td><?= $cabId;?></td>
                <td><?= $plateNo;?></td>
                <td><?= $vType;?></td>
                <td><?= $model;?></td>
                <td><?= $info;?></td>
                <td><?php if(!isset($userId) || $userId === 'empty' ){echo 'empty';}else {echo $userId;}?></td>
                <td><?= $startLocation;?></td>
            </tr>
        <?php } ?>
    </table>
