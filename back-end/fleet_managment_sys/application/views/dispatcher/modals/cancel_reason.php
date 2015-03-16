<script>

    function cancelOrder(orderRefId) {
        var cancelReason = $('input[name=cancelReason]:checked').val();
        console.log("DEBUG:");
        console.log(cancelReason);

//        var confirmation = confirm("Are you sure you want to cancel this order!");
//        if (!confirmation) {
//            return false;
//        }

        closeAll();
        $("#orderBuilder").html('');
        $.post('dispatcher/cancelOrder', {refId: orderRefId, 'cancelReason': cancelReason}).done(
            function () {
                $("#orderBuilder").html('');

                var newLocation = $('#newLocation').data('location');
                var cabId = $('#newLocation').data('cabid');

                closeAll();
                var orderDOM = $('#liveOrdersList').find('#' + orderRefId);
                $(orderDOM).fadeOut();
                $('#liveOrdersList').find('#' + orderRefId).remove();
                $('#dispatchedOrdersList').find('#' + orderRefId).remove();
                delete unDispatchedOrders[orderRefId];
                $.UIkit.notify({
                    message: "Order: <b>" + orderRefId + "</b> has been canceled!",
                    status: 'success',
                    timeout: 3000,
                    pos: 'top-center'
                });

                locVM.setToIdleFromStringParams(newLocation,cabId);

            }
        ).
            fail(
            function () {
                $.UIkit.notify({
                    message: "Can't cancel Order: <b>" + orderRefId + "</b> Something went wrong!",
                    status: 'danger',
                    timeout: 3000,
                    pos: 'top-center'
                });
            }
        );

    }


    var locationsExtractor = function (zones) {
        return function findMatches(q, cb) {
            var matches, substrRegex;

            // an array that will be populated with substring matches
            matches = [];
            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(zones, function (i, zone) {
                if (substrRegex.test(zone.name)) {
                    // the typeahead jQuery plugin expects suggestions to a
                    // JavaScript object, refer to typeahead docs for more info
                    matches.push({value: zone.name});
                }
            });

            cb(matches);
        };
    };

    $('#newLocationSearch').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'states',
            displayKey: 'value',
            source: locationsExtractor(LocationBoard.zones)
        }).on('typeahead:selected', function ($e, datum) {
            console.log("DEBUG: on selected");
            $("#newLocation").html(datum["value"]);
        }).on('typeahead:autocompleted', function ($e, datum) {
            console.log("DEBUG: on auto");
            $("#newLocation").html(datum["value"]);
        }
    );

</script>

<div class="modal-header"
     style="cursor: move;background: #f9f9f9;-webkit-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);-moz-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);">
    <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">
        <!-- TODO: Trigger bootstrap tooltip $('#aboutTileUrl').tooltip(); to enable tooltip -->
        Confirm Cancel For Reference ID <?= $order['refId'] ?>
    </h4>
</div>


<div class="modal-body">


    <div class="col-md-5">
        <form role="form">

            <div class="form-group">
                <label class="radio-inline">
                    <input type="radio" id="cancel1Radio" name="cancelReason" value="Appointment Cancelled"> Appointment
                    Cancelled
                </label> </br>
                <label class="radio-inline">
                    <input type="radio" id="cancel2Radio" name="cancelReason" value="Cancelled By Customer"> Cancelled
                    By Customer
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
                    <input type="radio" id="cancel4Radio" name="cancelReason" value="Unavoidable Circumstances">
                    Unavoidable Circumstances
                </label> </br>
                <label class="radio-inline">
                    <input type="radio" id="cancel4Radio" name="cancelReason" value="Duplicate Booking"> Duplicate
                    Booking
                </label> </br>
                <label class="radio-inline">
                    <input type="radio" id="cancel4Radio" name="cancelReason" value="Picked By another company car">
                    Picked By another company car
                </label> </br>
                <label class="radio-inline">
                    <input type="radio" id="cancel4Radio" name="cancelReason" value="No vehicles at location"> No
                    vehicles at location
                </label> </br>
            </div>
        </form>
    </div>
    <div class="col-md-7">
        <div class="row">

            <div class="form-group form-group">
                <label class="col-md-3 control-label" for="newLocationSearch">Zone</label>

                <div class="col-md-9">
                    <input class="form-control" type="text" id="newLocationSearch" placeholder="Location Name"
                           autocomplete="off">
                </div>
            </div>
        </div>

        <div class="row text-center">
            <br/>
            <button id="newLocation" data-cabid="<?= $order['cabId'] ?>" data-location="<?= $cab['zone'] ?>" type="button" class="btn btn-info"></button>
        </div>

        <?php if($order['status'] == "POB" or $order['status'] == "AT_THE_PLACE"): ?>
            <br/>
            <div class="alert alert-warning alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <strong>WARNING!</strong> This order state is <span class="label label-info" > <?= $order['status'] ?> </span>, cancel if you are sure about the cancellation.
            </div>
        <?php endif ?>
    </div>
    <div class="row">
        <div style="margin-bottom: -15px" class="btn-group btn-group-justified">
            <div class="btn-group">
                <button style="background-color: #d9534f;" type="button" class="btn btn-default"
                        onclick="cancelOrder(<?= $order['refId'] ?>)">Confirm cancellation
                </button>
            </div>

            <div class="btn-group">
                <button style="background-color: #f0e6e8;" type="button" class="btn btn-default" onclick="closeAll()">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>