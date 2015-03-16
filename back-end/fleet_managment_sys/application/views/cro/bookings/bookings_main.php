<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-------------------------------- CSS Files------------------------------------>
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/webLibs/bootstrapvalidator-dist-0.5.2/dist/css/bootstrapValidator.css">

    <!-------------------------------- JS Files------------------------------------>
    <script type="text/javascript" src="<?= base_url();?>assets/js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/cro_operations.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/webLibs/bootstrapvalidator-dist-0.5.2/dist/js/bootstrapValidator.js" charset="UTF-8"></script>


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
        var docs_per_page= 100 ;
        var page = 1 ;
        var obj = null;
        var tp;
        var url = '<?= site_url(); ?>';
        var bookingObj = null;
        var customerObj = null;
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
            <li ><a href="<?= site_url('cro_controller')?>">CRO</a></li>
            <li><a href="<?= site_url('cro_controller/loadMyBookingsView')?>" >My Bookings</a></li>
            <li class="active"><a href="<?= site_url('cro_controller/loadBookingsView')?>" >Bookings</a></li>
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

    <div class="row" style="background: #d7ddeb; min-height: 1000px">


        <div class="col-lg-12" style="margin-top: 10px;" id="bookingSearch" >
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">Booking Search</h5>
                </div>

                <div class="panel-body" >

                    <div class="col-lg-4">
                        <form class="form-inline" role="form">
                            <div class="form-group">
                                <label for="refIdSearch" class="sr-only">Reference ID</label>
                                <input type="text" class="form-control" id="refIdSearch" placeholder="REF ID">
                            </div>
                            <button type="submit" class="btn btn-default" onsubmit="bookingsOperations('getBookingById');return false;" onclick="bookingsOperations('getBookingById');return false;">Search</button>
                        </form>
                    </div>

                    <div class="col-lg-4">
                        <form class="form-inline" role="form">
                            <div class="form-group">
                                <label for="customerName" class="sr-only">Customer Name</label>
                                <input type="text" class="form-control" id="customerName" placeholder="Customer Name">
                            </div>
                            <button type="submit" class="btn btn-default" onsubmit="bookingsOperations('getCustomerNames');return false;"
                                    onclick="bookingsOperations('getCustomerNames');return false;">Search</button>
                        </form>
                    </div>

                    <div class="col-lg-4">
                        <form class="form-inline" role="form">
                            <div class="form-group">
                                <label for="townSearch" class="sr-only">Address[Town]</label>
                                <input type="text" class="form-control" id="townSearch" placeholder="Address[Town]">
                            </div>
                            <button type="submit" class="btn btn-default" onsubmit="bookingsOperations('getBookingByTown');return false;" onclick="bookingsOperations('getBookingByTown');return false;">Search</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-lg-12" style="margin-top: 10px" id="searchDetails">


        </div>
    </div>

    <script>

        getAdvancedBookingsView();
        function getAdvancedBookingsView(){
            var controllerUrl = url + '/cro_controller/getAdvancedBookingsView';
            var data = {};
            var result = ajaxPost(data , controllerUrl , false);
            $('#searchDetails').html(result.view.advanced_bookings_view);
        }

        function bookingsOperations(request){

            if(request == 'getBookingByTown'){
                url = url + '/cro_controller/getSearchByTownView';
                var town= $('#townSearch').val();
                var  data={'town' : town};
                var result = ajaxPost(data , url , false);
                if(result.statusMsg == 'true')
                    $('#searchDetails').html(result.view.bookings_by_address_view);
                else
                    alert('Bookings for the Town Not Available ');
            }


            if(request == 'getCustomerNames'){
                url = url + '/cro_controller/getSearchByNamesViews';
                var name= $('#customerName').val();
                var  data={'name' : name};
                var result = ajaxPost(data , url , false);
                if(result.statusMsg == 'true')
                    $('#searchDetails').html(result.view.customers_by_name_view);
                else
                    alert('Customer Name Does Not Exists');
            }

            if(request == 'getBookingById'){
                url = url + '/cro_controller/getBookingByRefIdView';
                var refId= $('#refIdSearch').val();
                var  data={'refId' : refId}
                var result = ajaxPost(data , url , false);
                if(result.statusMsg == 'true')
                    $('#searchDetails').html(result.view.advanced_bookings_view);
                else
                    alert('Booking ID does not exists');
            }

        }


        function ajaxPost(data,urlLoc, asynchronicity)    {
            var result=null;
            $.ajax({
                type: 'POST', url: urlLoc,
                contentType: 'application/json; charset=utf-8',
                data: JSON.stringify(data),
                async: asynchronicity ? true : false,
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