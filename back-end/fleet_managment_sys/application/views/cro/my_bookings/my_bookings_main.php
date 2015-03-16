<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-------------------------------- CSS Files------------------------------------>
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/bootstrap-datetimepicker.css">
    <!-------------------------------- JS Files------------------------------------>
    <script type="text/javascript" src="<?= base_url();?>assets/js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/cro_operations.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>

    <!-- Moment libraries -->
    <script src="<?= base_url() ?>assets/js/moment/moment.js"></script>


    <!-- UIkit libraries -->
    <script src="<?= base_url() ?>assets/js/uikit/uikit.min.js"></script>
    <script src="<?= base_url() ?>assets/js/uikit/addons/notify.min.js"></script>

    <!-- autobahn websocket and WAMP -->
    <script src="<?= base_url() ?>assets/js/autobahn/autobahn.min.js"></script>

    <script src="<?= base_url() ?>assets/js/application_options.js"></script>
    <script src="<?= base_url() ?>assets/js/websocket/cro.js"></script>

    <script>
        setBaseURL('<?= base_url().'index.php/' ?>'); // TODO: use better method to set BASE_URL infact set all dynamic vars, in here order matters caz initializing applicatioOptions
    </script>

    <script>
        var docs_per_page = 100;
        var page = 1;
        var obj = null;
        var tp;
        var url = '<?= site_url(); ?>';

        function updateTime() {
//            console.log("DEBUG: call updateTime");
            var dynamicTimeDOMs = $('.dynamicTimeUpdate');
            var i = 0;
            for (; i < dynamicTimeDOMs.length; i++) {
                var dynamicTimeDOM = $(dynamicTimeDOMs[i]);
                //        var latestBooking = $('#liveOrdersList').find('a:first');
                var baseTime = dynamicTimeDOM.data('basetime');
//                console.log(dynamicTimeDOM);
                dynamicTimeDOM.html(moment.unix(baseTime).fromNow());
            }
        }


        (function ($) {
            $(window).load(function () {
                moment().format();
                updateTime();
                setInterval(updateTime, 1000);
            });
        })(jQuery);
    </script>
</head>
<body>
<div id="navBarField">
    <nav class="navbar navbar-default" role="navigation" style="margin-bottom: 0px">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Hao Cabs</a>
        </div>

        <ul class="nav navbar-nav">
            <li><a href="<?= site_url('cro_controller')?>" >CRO</a></li>
            <li class="active"><a href="<?= site_url('cro_controller/loadMyBookingsView')?>" >My Bookings</a></li>
            <li><a href="<?= site_url('cro_controller/loadBookingsView')?>" >Bookings</a></li>
            <li><a href="<?= site_url('cro_controller/loadMapView')?>" >Map</a></li>
            <li><a href="<?= site_url('cro_controller/loadLocationBoardView')?>" >Location Board</a></li>
            <li><a href="<?= site_url('cro_controller/getCabHeaderView')?>" >Cabs</a>
            <li><a href="<?= site_url('cro_controller/getAllPackagesView')?>" >Packages</a>
        </ul>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= $uName;?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= site_url('login/logout')?>">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</div>

<div class="container-fluid">
    <div class="row" style="background: #d7ddeb">
        <div class="col-lg-12" style="margin-top: 10px">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Bookings</h3>
                </div>
                <div class="panel-body" id="bookings">




                </div>
            </div>
        </div>
    </div>
</div>

<script>


        var data = {};
        url = url +"/cro_controller/getMyBookings";
        var view = ajaxPost(data,url);
        /*  Populate the New Booking field with the editing form */
        var bookingsDiv = document.getElementById('bookings');
        bookingsDiv.innerHTML = view.view.booking_summary;

</script>

    <script>

        function ajaxPost(data,urlLoc)    {
            var result=null;
            $.ajax({
                type: 'POST', url: urlLoc,
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                data: JSON.stringify(data),
                async: false,
                success: function(data, textStatus, jqXHR) {
                    result = JSON.parse(jqXHR.responseText);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if(jqXHR.status == 400) {
                        var message= JSON.parse(jqXHR.responseText);
                        $('#messages').empty();
                        $.each(messages, function(i, v) {
                            var item = $('<li>').append(v);
                            $('#messages').append(item);
                        });
                    } else {
                        alert('Unexpected server error.');
                    }
                }
            });
            return result;
        }
    </script>
</body>
</html>