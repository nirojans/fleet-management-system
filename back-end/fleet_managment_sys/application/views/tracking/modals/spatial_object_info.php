<script type="text/javascript">
    $(
        function () {
            drawChart();
            $("#spatial_object_info_wrapper").draggable({
                handle: ".panel-heading"
            });
        }
    );

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['Speed', 5]
        ]);

        var options = {
            width: 300, height: 120,
            greenFrom: 10, greenTo: 70,
            yellowFrom: 75, yellowTo: 90,
            redFrom: 90, redTo: 120,
            minorTicks: 10
        };

        var chart = new google.visualization.Gauge(document.getElementById('gchart_div'));

        chart.draw(data, options);

        setInterval(function () {
            data.setValue(0, 1, 40 + Math.round(60 * Math.random()));
            chart.draw(data, options);
        }, 1000);
    }
</script>
<div class="col-md-3" id="spatial_object_info_wrapper" style="margin-left: 5px">
    <div class="panel panel-default">
        <div class="panel-heading" style="cursor: move">
            <i class="fa fa-times" style="color: cadetblue;float: right;cursor: pointer;" onclick="$('#spatial_object_info').fadeOut('slow')"></i>
            <h3 class="panel-title">Cab Information</h3>
            </div>
        <div class="list-group">
            <div class="list-group-item">
                <div class="row">
                    <div class="col-md-6">
                        <i style="background: darkgrey;color: floralwhite;padding: 10px;border-radius: 50%"
                           class="fa fa-taxi fa-5x"></i>
                    </div>
                    <div class="col-md-6">
                        <div id="gchart_div"></div>
                    </div>

                </div>
            </div>
            <div class="list-group-item">
                <div class="row">
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <td>Cab ID</td>
                            <td>***</td>
                        </tr>

                        <tr>
                            <td>UserId</td>
                            <td>@twitter</td>
                        </tr>

                        <tr>
                            <td>Plate No</td>
                            <td>TE-STING</td>
                        </tr>

                        <tr>
                            <td>Model</td>
                            <td>TE</td>
                        </tr>

                        <tr>
                            <td>Color</td>
                            <td>Black</td>
                        </tr>

                        <tr>
                            <td>Info</td>
                            <td>@twitter</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="panel-footer" style="padding: 4px;">
            <div class="btn-group btn-group-justified">
                <div class="btn-group">
                    <button class="btn btn-default btn-xs">
                        <i class="fa fa-history"></i>
                        History
                    </button>
                </div>
                <div class="btn-group">
                    <button class="btn btn-default btn-xs">
                        <i class="fa fa-taxi"></i>
                        Orders path
                    </button>
                </div>
                <div class="btn-group">
                    <button class="btn btn-default btn-xs">
                        <i class="fa fa-mobile"></i>
                        Contact Driver
                    </button>
                </div>
            </div>
        </div>
    </div>


</div>