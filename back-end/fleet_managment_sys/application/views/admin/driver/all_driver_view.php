<table class="table table-striped" >
    <tr>
        <th>Driver ID</th>
        <th>Calling Number</th>
        <th>Log Sheet Number</th>
        <th>Name</th>
        <th>User Name</th>
        <th>Pass</th>
        <th>NIC</th>
        <th>tp</th>
        <th>Can Logout</th>
        <th>Cab ID</th>
        <th>Cab Start Location</th>
        <th>Blocked</th>
    </tr>

    <?php foreach ($data as $item):?>

        <tr>
            <td><?= $item['userId'];?></td>
            <td><?php
                            if(!isset($item['callingNumber']) || $item['callingNumber'] == -1 || trim($item['callingNumber']) == ''){echo 'Not Assigned';}
                            else{echo $item['callingNumber'];}
                            ?></td>
            <td><?php
                            if(!isset($item['logSheetNumber']) || $item['logSheetNumber'] == -1 || trim($item['logSheetNumber']) == ''){echo 'Not Assigned';}
                            else{echo $item['logSheetNumber'];}
                            ?></td>
            <td><?= $item['name'];?></td>
            <td><?= $item['uName'];?></td>
            <td><?= $item['pass'];?></td>
            <td><?= $item['nic'];?></td>
            <td><?= $item['tp'];?></td>
            <td><?php if($item['logout']==true){echo "true";}else{echo "false";}?></td>
            <td><?php
                if(!array_key_exists("cabId", $item) || $item['cabId'] === "" || $item['cabId']==-1){
                    echo 'Not Assigned';
                }else{
                    echo $item['cabId'];
                }
                ?></td>
            <td><?php
                            if(!isset($item['startLocation']) || trim($item['startLocation']) == ''){echo 'Not Assigned';}
                            else{echo $item['startLocation'];}
                            ?></td>
            <td><?= $item['blocked'];?></td>
            <td><button type="button" class="btn btn-success" onclick="makeCROFormEditable(<?= $item['userId']; ?>,url, '<?php echo $item['user_type']; ?>')">Edit</button></td>
        </tr>

    <?php endforeach;?>
</table>

