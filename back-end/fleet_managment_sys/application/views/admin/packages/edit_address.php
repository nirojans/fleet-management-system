<form role="form" id="createCab">
    <div class="form-group">
        <label for="addressId">Address Id</label>
        <input type="text" class="form-control" id="addressId" readonly value="<?= $addressId;?>">
    </div>
    <div class="form-group">
        <label for="addressName">Address Name</label>
        <input type="text" class="form-control" id="addressName" placeholder="Enter Name" value="<?= $addressName;?>">
    </div>
    <div class="form-group">
        <label for="city">City</label>
        <input type="text" class="form-control" id="city" placeholder="Enter City" value="<?= $city;?>">
    </div>
    <div class="form-group">
        <label for="town">Town</label>
        <input type="text" class="form-control" id="town" placeholder="Enter Town" value="<?= $town;?>" >
    </div>
    <div class="form-group">
        <label for="road">Road</label>
        <input type="text" class="form-control" id="road" placeholder="Enter road" value="<?= $road;?>">
    </div>
    <button type="submit" class="btn btn-default" onclick="updateAddress('<?php echo $addressId;?>');return false;"
            onsubmit="updateAddress('<?php echo $addressId;?>');return false;">Save</button>
    <button type="submit" class="btn btn-default" onclick="deleteAddress('<?php echo $addressId;?>');return false;"
            onsubmit="deleteAddress('<?php echo $addressId;?>');return false;">Delete</button>
</form>
