<script>
    /* To generate timestamp http://www.timestampgenerator.com/*/
    var eventTime = 1420243199; // Timestamp - Sun, 21 Apr 2013 13:00:00 GMT
    var currentTime = moment().unix(); // Timestamp - Sun, 21 Apr 2013 12:30:00 GMT
    var diffTime = eventTime - currentTime;
    var duration = moment.duration(diffTime * 1000, 'milliseconds');
    var interval = 1000;

    $("#countdown .days").html(duration.days());
    $("#countdown .hours").html(duration.hours());
    $("#countdown .minutes").html(duration.minutes());
    $("#countdown .seconds").html(duration.seconds());
    setInterval(function () {
        duration = moment.duration(duration - interval, 'milliseconds');
//        console.log(duration.days() + ":" + duration.hours() + ":" + duration.minutes() + ":" + duration.seconds());
        $("#countdown .days").html(duration.days());
        $("#countdown .hours").html(duration.hours());
        $("#countdown .minutes").html(duration.minutes());
        $("#countdown .seconds").html(duration.seconds());
    }, interval);
</script>

<div class="modal-header"
     style="cursor: move;background: #f9eaca;-webkit-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);-moz-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);">
    <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title text-center">
        <!-- TODO: Trigger bootstrap tooltip $('#aboutTileUrl').tooltip(); to enable tooltip -->
        Hao City Cabs System <span class="label label-default">Scheduled System Maintenance</span>
    </h4>
</div>
<div class="modal-body">

    <div class="panel panel-default" style="border: none;min-height: 20%;">
        <div class="panel-body">

            <p class="text-justify">
                In an effort to keep the systems up to date and as functional for you as possible,
                we will be undergoing scheduled maintenance starting
                tomorrow <span class="text-primary"> 00:00H UTC+05:30, Monday 26-January, 2015.</span>
                and completing
                at <span class="text-primary"> 03:00H UTC+05:30, Monday 26-January, 2015.</span>.
            </p>

            <p class="text-center">
                <span class="badge"> Duration:</span> Up to 3 hours to complete(Until 03:00H UTC +05:30, Monday 26-January, 2015).
            </p>

            <p class="text-justify">
                We apologize for any inconvenience that may cause.
            </p>


            <p class="text-right text-muted">
                For enquiries, please contact via the contact button below.
            </p>

        </div>
    </div>


    <div class="row">
        <div style="margin-bottom: -15px" class="btn-group btn-group-justified">
            <div class="btn-group">
                <button style="background-color: #ffffff;" type="button" class="btn btn-default"
                        onclick="$('.modal').modal('hide');">Close
                </button>
            </div>
            <div class="btn-group">
                <button style="background-color: #d4f0db;" type="button" class="btn btn-default"
                        onclick="$('#commonModal').modal('show').find('.modal-content').load('<?= site_url('notice/feedback_form') ?>');return false">
                    Contact us
                </button>
            </div>
        </div>
    </div>
</div>


































