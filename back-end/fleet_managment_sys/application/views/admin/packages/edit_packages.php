<form role="form" id="editDispatchers">
    <div class="form-group">
        <label for="packageId">Package Id</label>
        <input type="text" class="form-control" id="packageId" readonly value="<?= $packageId;?>">
    </div>
    <div class="form-group">
        <label for="packageName">Package Name</label>
        <input type="text" class="form-control" id="packageName" placeholder="Enter Name"  value="<?= $packageName;?>">
    </div>
    <div class="form-group">
        <label for="feeType">Fee Type</label>
        <input type="text" class="form-control" id="feeType" readonly value="<?= $feeType;?>">
    </div>
    <?php if($feeType == 'airport'){ ?>
        <div class="form-group">
            <label for="fee">Drop Fee</label>
            <input type="text" class="form-control" id="dropFee" placeholder="Enter Fee" value="<?= $dropFee;?>">
        </div>
        <div class="form-group">
            <label for="fee">Both Way Fee</label>
            <input type="text" class="form-control" id="bothwayFee" placeholder="Enter Fee" value="<?= $bothwayFee;?>">
        </div>
        <div class="form-group">
            <label for="fee">Guest Carrier Fee</label>
            <input type="text" class="form-control" id="guestCarrierFee" placeholder="Enter Fee" value="<?= $guestCarrierFee;?>">
        </div>
        <div class="form-group">
            <label for="fee">Out Side Fee</label>
            <input type="text" class="form-control" id="outsideFee" placeholder="Enter Fee" value="<?= $outsideFee;?>">
        </div>
    <?php }else{ ?>

        <div class="form-group">
            <label for="fee">Distance</label>
            <input type="text" class="form-control" id="km" placeholder="Enter Distance" value="<?= $km;?>">
        </div>
        <div class="form-group">
            <label for="fee">Hours</label>
            <input type="text" class="form-control" id="hours" placeholder="Enter Hours" value="<?= $hours;?>">
        </div>
        <div class="form-group">
            <label for="fee">Both Way Fee</label>
            <input type="text" class="form-control" id="fee" placeholder="Enter Fee" value="<?= $fee;?>">
        </div>

    <?php } ?>
    <div class="form-group">
        <label for="info">Info</label>
        <input type="text" class="form-control" id="info" placeholder="Enter Info" value="<?= $info;?>">
    </div>
    <button type="submit" class="btn btn-default" onclick="updatePackage('<?php echo $packageId;?>');return false;"
            onsubmit="updatePackage('<?php echo $packageId;?>');return false;">Save</button>
    <button type="submit" class="btn btn-default" onclick="deletePackage('<?php echo $packageId;?>');return false;"
            onsubmit="deletePackage('<?php echo $packageId;?>');return false;">Delete</button>
</form>