<div class="col-lg-9" >
    <h4>Confirm Cancel For Reference ID <?= $refId?></h4>
    <form role="form">

        <div class="form-group">
            <label class="radio-inline">
                <input type="radio" id="cancel1Radio" name="cancelReason" value="Appointment Cancelled"> Appointment Cancelled
            </label> </br>
            <label class="radio-inline">
                <input type="radio" id="cancel2Radio" name="cancelReason" value="Cancelled By Customer"> Cancelled By Customer
            </label> </br>
            <label class="radio-inline">
                <input type="radio" id="cancel3Radio" name="cancelReason" value="Got a Lift"> Got a Lift
            </label> </br>
            <label class="radio-inline">
                <input type="radio" id="cancel4Radio" name="cancelReason" value="Delayed By Base"> Delayed By Base
            </label> </br>
            <label class="radio-inline">
                <input type="radio" id="cancel4Radio" name="cancelReason" value="No Response"> No Response
            </label> </br>
            <label class="radio-inline">
                <input type="radio" id="cancel4Radio" name="cancelReason" value="Unavoidable Circumstances"> Unavoidable Circumstances
            </label> </br>
            <label class="radio-inline">
                <input type="radio" id="cancel4Radio" name="cancelReason" value="Duplicate Booking"> Duplicate Booking
            </label> </br>
            <label class="radio-inline">
                <input type="radio" id="cancel4Radio" name="cancelReason" value="Picked By another company car"> Picked By another company car
            </label> </br>
            <label class="radio-inline">
                <input type="radio" id="cancel4Radio" name="cancelReason" value="No vehicles at location"> No vehicles at location
            </label> </br>
        </div>

    </form>
</div>

<div class="col-lg-3">
    <div class="form-group">
        <div class="checkbox">
            <label>
                <input type="checkbox" id="sendSms"> Dont Send SMS
            </label>
        </div>
    </div>
    <div class="btn-group btn-group-justified">
        <div class="btn-group">
            <button type="button" class="btn btn-danger" onclick="operations('confirmCancel', '<?php echo $_id; ?>')">Confirm Cancel</button>
        </div>
    </div>
    <div class="btn-group btn-group-justified" style="margin-top: 10%">
        <div class="btn-group">
            <button type="button" class="btn btn-success" onclick="operations('denyCancel')">Deny Cancel</button>
        </div>
    </div>
</div>