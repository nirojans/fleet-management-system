<table class="table table-striped" >
    <tr>
        <th>Cab ID</th>
        <th>Plate Number</th>
        <th>Vehicle Type</th>
        <th>Model</th>
        <th>Info</th>
        <th>Driver ID</th>
        <th>Calling Number</th>
        <th>Log Sheet Number</th>
        <th>Cab Start Location</th>       

    </tr>
    <tr>
        <?php if(isset($cabId)){ ?>
        <td><?= $cabId?></td>
        <td><?= $plateNo?></td>
        <td><?= $vType?></td>
        <td><?= $model?></td>
        <td><?= $info;?></td>
        <td><?php if(!isset($userId) || $userId === 'empty' || $userId == -1){echo 'empty';}else {echo $userId;}?></td>
        <td><?php if(!isset($callingNumber) || $callingNumber == -1 ){echo 'empty';}else {echo $callingNumber;}?></td>
        <td><?php if(!isset($logSheetNumber) || $logSheetNumber == -1 ){echo 'empty';}else {echo $logSheetNumber;}?></td>
        <td><?= $startLocation;?></td>
        <td><button type="button" class="btn btn-success" onclick="makeCabFormEditable(<?php echo $cabId;?>,url)">Edit</button></td>
        <?php } ?>
    </tr>

    
</table>

<!--<div class="col-lg-10">

  
    <div class="btn-group btn-group-justified">
        <div class="btn-group">
            <button type="button" class="btn btn-success" onclick="makeCabFormEditable(<?php echo $cabId;?>,url)">Edit</button>
        </div>
    </div>    
</div>-->