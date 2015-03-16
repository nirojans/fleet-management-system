<script>
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
            $("#newLocation").data('location',datum["value"]);

        }).on('typeahead:autocompleted', function ($e, datum) {
            console.log("DEBUG: on auto");
            $("#newLocation").html(datum["value"]);
            $("#newLocation").data('location',datum["value"]);
        }
    );
</script>
<div class="modal-header"
     style="cursor: move;background: #f9f9f9;-webkit-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);-moz-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);">
    <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">
        <!-- TODO: Trigger bootstrap tooltip $('#aboutTileUrl').tooltip(); to enable tooltip -->
        Confirm Disengage For cab ID <?= $order['cabId'] ?>
    </h4>
</div>


<div class="modal-body">
    <div class="col-md-5">
        <form role="form">

            <div class="form-group">

                <label class="radio-inline">
                    <input type="radio" id="cancel2Radio" name="cancelReason" value="Customer Request"> Customer request
                </label> </br>
                <label class="radio-inline">
                    <input type="radio" id="cancel3Radio" name="cancelReason" value="Found another vehicle closer to location"> Found another vehicle closer to location
                </label> </br>
                <label class="radio-inline">
                    <input type="radio" id="cancel4Radio" name="cancelReason" value="Vehicle breakdown"> Vehicle breakdown
                </label> </br>
                <label class="radio-inline">
                    <input type="radio" id="cancel4Radio" name="cancelReason" value="No Response"> No Response
                </label> </br>
                <label class="radio-inline">
                    <input type="radio" id="cancel4Radio" name="cancelReason" value="Driver refused"> Driver refused
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
            <button id="newLocation" type="button" data-cabid="<?= $order['cabId'] ?>" data-location="<?= $cab['zone'] ?>" class="btn btn-info"></button>

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
                        onclick="disengageCab(<?= $order['refId'] ?>)">Confirm disengage
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