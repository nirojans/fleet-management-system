<form role="form" id="editCab">
    <div class="form-group">
        <label for="cabId">Cab ID</label>
        <input type="text" class="form-control" id="cabId"  readonly="readonly" value="<?= $cabId;?>">
    </div>
    <div class="form-group">
        <label for="plateNo">Plate Number</label>
        <input type="text" class="form-control" id="plateNo" placeholder="Enter Number" value="<?= $plateNo;?>">
    </div>
    <div class="form-group">
        <label for="model">Model</label>
        <input type="text" class="form-control" id="model" placeholder="Enter Model" value="<?= $model;?>">
    </div>
    <div class="form-group">
        <label for="vType">Vehicle Type</label>
        <input type="text" class="form-control" id="vType" placeholder="Enter Vehicle Type" value="<?= $vType;?>">
    </div>
    <div class="form-group">
        <label for="color">Color</label>
        <input type="text" class="form-control" id="color" placeholder="Enter Color" value="<?= $color;?>">
    </div>
    <div class="form-group">
        <label for="info">Information</label>
        <input type="text" class="form-control" id="info" placeholder="Enter Info" value="<?= $info;?>">
    </div>
    <div class="form-group">
        <label for="cabId">User ID</label>
        <input type="text" class="form-control" id="userId"  readonly="readonly" value="<?php if(!isset($userId) || $userId === 'empty'){echo 'empty';}else {echo $userId;}?>">
    </div>
    <button type="submit" class="btn btn-default" onclick="updateCab(url, docs_per_page , page )">Save</button>
    <button type="submit" class="btn btn-default" onclick="deleteCab(<?= $cabId;?>)">Delete</button>
</form>

