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
    <script type="text/javascript" src="<?= base_url();?>assets/webLibs/knockout/knockout-3.2.0.js"></script>


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

        var docs_per_page= 100;
        var page = 1;
        var obj = null;
        var url = '<?php echo site_url(); ?>';

    </script>
    <script>
        setBaseURL('<?= base_url().'index.php/' ?>');

        function getCabViewCRO(){

            var cabId = document.getElementById("cabIdSearch").value;
            var cab = { 'cabId' : parseInt(cabId) };
            var url = '<?php echo site_url("cab_retriever/getCabSearchViewCRO"); ?>';
            var result = ajaxPostCro(cab,url);
            var div = document.getElementById('tableDiv');
            div.innerHTML = result.view.table_content;

        }

        function getAllCabs(){
            var url = '<?php echo site_url("/cab_retriever/getAllCabsViewCRO"); ?>';
            var skip = docs_per_page * (page-1);
            var data = {"skip" : skip , "limit" : docs_per_page};
            var view = ajaxPostCro(data,url);
            var div = document.getElementById('tableDiv');
            div.innerHTML = view.view.table_content;

        }
    </script>

    <style>



        input.locInput{
            width:65%;
            display: inline;
        }

        ul.cabs{
            list-style: none;
            padding: 0;
            margin: 0;
            list-style-type: none;
        }

        li.cab{
            display: inline;
        }

        .cabView{
            width: auto;
            display: inline;
            margin-bottom: 2%;
            margin-right: 2%;

        }
        button.cabAdd{
            width: auto;
            display: inline;
            margin-bottom: 5px;

        }

        .dropdown-menu2{

            left:-217%;
        }



        .dropdown-menu1{

            left:-45%;
        }




    </style>
</head>
<body>
<div id="navBarField">
    <nav class="navbar navbar-default" role="navigation" style="margin-bottom: 0px">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Hao Cabs</a>
        </div>

        <ul class="nav navbar-nav">
            <li><a href="<?= site_url('cro_controller')?>">CRO</a></li>
            <li><a href="<?= site_url('cro_controller/loadMyBookingsView')?>" >My Bookings</a></li>
            <li><a href="<?= site_url('cro_controller/loadBookingsView')?>" >Bookings</a></li>
            <li><a href="<?= site_url('cro_controller/loadMapView')?>" >Map</a></li>
            <li><a href="<?= site_url('cro_controller/loadLocationBoardView')?>" >Location Board</a></li>
            <li class="active" ><a href="<?= site_url('cro_controller/getCabHeaderView')?>" >Cabs</a>
            <li><a href="<?= site_url('cro_controller/getAllPackagesView')?>" >Packages</a>    
        </ul>



        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Link</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$uName;?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= site_url('login/logout')?>">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</div>




<div class="col-lg-12" style="margin-top: 10px;" id="bookingSearch" >
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5 class="panel-title">Cab Search</h5>
        </div>

        <div class="panel-body" >

            <div class="col-lg-4">
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label for="cabIdSearch" class="sr-only">Cab ID</label>
                        <input type="text" class="form-control" id="cabIdSearch" placeholder="Cab ID">
                    </div>
                    <button type="button" class="btn btn-default"  onclick="getCabViewCRO();">Search</button>
                </form>
            </div>

        </div>
        <div id="tableDiv">
            <script>getAllCabs();</script>
        </div>
    </div>

</div>
</body>