<script type="text/javascript" src="<?= base_url();?>assets/js/jquery-1.10.2.js"></script>
<form role="form" id="createDispatcher">
    <div class="form-group">
        <label for="name">Package Name</label>
        <input type="text" class="form-control" id="packageName" placeholder="Enter Package Name">
    </div>

    <div class="form-group">
        <label class="col-xs-3 control-label">Fee Type</label>
        <div class="col-xs-9">
            <div class="radio">
                <label>
                    <input id="airport" checked name="feeType" onclick="document.getElementById('dayFeeDiv').style.display = 'none';document.getElementById('airportFeeDiv').style.display = 'block';"  value="airport" type="radio">
                    Air Port</label>
            </div>
            <div class="radio">
                <label>
                    <input id="day"  name="feeType" onclick="document.getElementById('airportFeeDiv').style.display = 'none';document.getElementById('dayFeeDiv').style.display = 'block';" value="day" type="radio">
                    Day</label>
            </div>
        </div>
    <div class="form-group" id="airportFeeDiv">
        <label for="fee">Drop Fee</label>
        <input type="text" class="form-control" id="dropFee" placeholder="Enter Fee"><br>
        <label for="fee">Both Way Fee</label>
        <input type="text" class="form-control" id="bothwayFee" placeholder="Enter Fee"><br>
        <label for="fee">Guest Carrier Fee</label>
        <input type="text" class="form-control" id="guestCarrierFee" placeholder="Enter Fee"><br>
        <label for="fee">outside Fee</label>
        <input type="text" class="form-control" id="outsideFee" placeholder="Enter Fee"><br>
    </div>
        <div class="form-group" id="dayFeeDiv" style="display: none">
            <label for="fee">Distance</label>
            <input type="text" class="form-control" id="km" placeholder="Enter distance"><br>
            <label for="fee">Hours</label>
            <input type="text" class="form-control" id="hours" placeholder="Enter Hours"><br>
            <label for="fee">Fee</label>
            <input type="text" class="form-control" id="fee" placeholder="Enter Fee"><br>
        </div>
    <div class="form-group">
        <label for="info">Info</label>
        <input type="text" class="form-control" id="info" placeholder="Enter Info">
    </div>
    <button type="submit" id="dispatcher" class="btn btn-default" onclick="createNewPackage();return false;"
        onsubmit="createNewPackage();return false;">Save</button>
</form>