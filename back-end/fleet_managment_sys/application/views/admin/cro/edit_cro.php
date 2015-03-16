<form role="form" id="editCROs">
    <div class="form-group">
        <label for="userId">CRO ID</label>
        <input type="text" class="form-control" id="userId"  readonly="readonly" value="<?= $userId;?>">
    </div>
    <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" class="form-control" id="name" placeholder="Enter Full Name" value="<?= $name;?>">
    </div>
    <div class="form-group">
        <label for="uName">User Name</label>
        <input type="text" class="form-control" id="uName" placeholder="Enter User Name" value="<?= $uName;?>">
    </div>
    <div class="form-group">
        <label for="pass">PassWord</label>
        <input type="text" class="form-control" id="pass" placeholder="Enter PassWord" value="<?= $pass;?>">
    </div>
    <div class="form-group">
        <label for="nic">NIC Number</label>
        <input type="text" class="form-control" id="nic" placeholder="Enter NIC Number" value="<?= $nic;?>">
    </div>
    <div class="form-group">
        <label for="tp">Telephone Number</label>
        <input type="text" class="form-control" id="tp" placeholder="Enter Telephone Number" value="<?= $tp;?>">
    </div>
    <div class="form-group">
        <label for="blocked">Blocked</label>
        <select class="form-control" id="blocked" placeholder="Blocked ?" >
            <option <?php if($blocked=='true')echo "selected";?> value="true">Yes</option>
            <option <?php if($blocked=='false')echo "selected";?> value="false">No</option>
        </select>
    </div>

    <button type="button" class="btn btn-default" onclick="updateCRO('<?php echo $user_type?>');return false;">Save</button>
    <button type="button" class="btn btn-default" onclick="deleteCRO('<?php echo $userId?>','<?php echo $user_type?>');return false;">Delete</button>
</form>