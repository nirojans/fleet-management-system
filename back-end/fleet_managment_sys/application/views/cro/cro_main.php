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
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/uikit/uikit.min.css"/>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/uikit/addons/uikit.addons.min.css"/>

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
    <!-- Show notices to user -->
    <script src="<?= base_url() ?>assets/js/notice/notice.js"></script>
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
        var historyBookingObj = null;
        var customerObj = null;
        var airportPackagesObj = null;
        var dayPackagesObj = null;
        var sessionFirstBooking = null;

        </script>
    <style>
        .nts-label{

            /*font-size: 75%;*/
            padding: .2em 16px .3em;
            margin: 0 12px;
            font-size: 15px;
            font-weight: bold;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25em;
            background-color: #777;
        }

        .nts-label-value{
            display: inline;
        }


        .nts-label-small{

            /*font-size: 75%;*/
            padding: 0.4em 3px .5em;
            margin: 0 0px;
            font-size: 12px;
            font-weight: bold;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25em;
            background-color: #777;
        }

        .nts-label-value-small{
            display: inline;
        }

    </style>
</head>
<body>
<div id="navBarField">
    <nav class="navbar navbar-default" role="navigation" style="margin-bottom: 0px">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Hao Cabs - CRO</a>
        </div>

        <ul class="nav navbar-nav">
            <li class="navbar-form navbar-left" style="padding: 0">  <!--<a href="<?/*= site_url('cro_controller')*/?>">CRO</a>-->

                <div class="btn-group">
                    <button type="button" data-bind="click:updateNumbers" class="btn btn-success dropdown-toggle cabView" data-toggle="dropdown" >
                        <span>Get Number</span>
                        <span class="caret"></span>
                    </button>

                    <div class="dropdown-menu dropdown-menu1" role="menu" style="  padding: 10px; border-radius: 5px">

                        <div style="margin:0">
                            <table class="table table-hover" style="margin-bottom:2%">
                                <thead>
                                <tr>
                                    <th style="text-align: right; min-width: 97px">Time</th>
                                    <th>Number</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody data-bind="foreach:currentNumbers">
                                <tr>
                                    <td data-bind="text:readableTimeStamp" style="padding: 13px; text-align: right;"><span>2014/10/23</span></td>
                                    <td data-bind="text:number" style="padding: 13px ; text-align: right;"><span>0772866596</span></td>
                                    <td ><button data-bind="click:$root.assignNumber" class="btn btn-default">Assign Number</button></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </li>

            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="tel" class="form-control" placeholder="Mobile / LandLine" id="tpSearch" autofocus>
                </div>
                <input type="submit" id="submitNumber" class="btn btn-default" onclick="operations('getCustomer');return false" onsubmit="operations('getCustomer');return false" value="Submit" />
            </form>

            <li><a href="<?= site_url('cro_controller/loadMyBookingsView')?>" target="_blank" >My Bookings</a></li>
            <li><a href="<?= site_url('cro_controller/loadBookingsView')?>" target="_blank" >Bookings</a></li>
            <li><a href="<?= site_url('cro_controller/loadMapView')?>" target="_blank">Map</a></li>
            <li><a href="<?= site_url('cro_controller/loadLocationBoardView')?>" target="_blank">Location Board</a></li>
            <li><a href="<?= site_url('cro_controller/getCabHeaderView')?>" target="_blank">Cabs</a>
            <li><a href="<?= site_url('cro_controller/getAllPackagesView')?>" target="_blank">Packages</a>
<!--            <li><a href="" onclick="forCro()">Packages</a>-->

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

        <div class="col-lg-12" style="margin-top: 10px">

            <div class="col-lg-6" style="margin-top: 10px; padding: 2px" id="jobInfo" >

            </div>

            <div class="col-lg-6" style="padding: 2px;">

                <div class="col-lg-12" style="margin-top: 10px; padding: 2px" id="callCenterInfo">
                    <div class="panel panel-default" xmlns="http://www.w3.org/1999/html">
                        <div class="panel-heading" style="padding: 1px">
                            <h5 class="panel-title">Call Center Information</h5>
                        </div>
                        <div class="panel-body" >

                            <div class="col-lg-3">
                                <img style='float:left;width:134px;height:128px' src="<?= base_url() ?>assets/img/phone.png" />
                            </div>

                            <div class="col-lg-4">
                                <p style="margin: 0 0 3px;"><span class="label label-default" style="font-size: 83%; ">Total Calls <?= $callStat['totalCalls']?></span> </p>
                                <p style="margin: 0 0 3px;"><span class="label label-info" style="font-size: 83%; ">Total Answered Calls <?= $callStat['answeredCalls']?></span></p>
                                <p style="margin: 0 0 3px;"><span class="label label-success" style="font-size: 83%;">Total Active Calls <?= $callStat['activeCalls']?></span></p>
                                <p style="margin: 0 0 3px;"><span class="label label-success" style="font-size: 83%;">My Active Calls <?= $callStat['croActiveCalls']?></span></p>
                                <p style="margin: 0 0 3px;"><span class="label label-default" style="font-size: 83%; ">Total Missed Calls <?= $callStat['missedCalls']?></span></p>
                                <p style="margin: 0 0 3px;">My Hires <span class="badge"><?= $callStat['croHires']?></span></p>
                            </div>

                            <div class="col-lg-5">
                                <h1>Total Hires
                                <span class="glyphicon glyphicon-circle-arrow-up" aria-hidden="true"> <?= $callStat['totalHires']?></span></h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12" style="margin-top: 10px; padding: 2px" id="customerInformation">

                </div>

            </div>

        </div>



        <div class="col-lg-12" style="margin-top: 10px"  id="newBooking">
            <!--div class="col-lg-offset-3 col-lg-7" style="margin-top: 10%">
                <img style="width: 80%" src="<?= base_url() ?>assets/img/hao-logo-small.png">
            </div-->
        </div>

        <div class="col-lg-8" style="margin-top: 10px" id="bookingHistory">

        </div>

        <div class="col-lg-4" style="margin-top: 10px" id="callHistory">

        </div>
    </div>
    <script>
        function operations(request, param1, param2){
            if(request=="editCus"){
                editCustomerInfoEditView( url , param1 );
            }
            if(request == 'updateCusInfo'){
                updateCustomerInfo( url );
                getCustomerInfoView( url , tp);
            }
            if(request == 'getCustomerFromPABX'){
                tp = param1;
                sessionFirstBooking = true;
                getCustomerInfoView( url , tp , true);
            }
            if(request == 'getCustomer'){
                tp = $('#tpSearch').val();
                sessionFirstBooking = true;
                getCustomerInfoView( url , tp);
            }
            ///////////////////TODO: Implement To Identify a called customer
            // WHY IS  THIS METHOD IS USED FOR ???????/ WHEN THERE IS A GETCUSTOMERFROMPABXMETHOD IS PRESENT
            if(request == 'getCalledCustomer'){
                tp = $('#tpSearch').val();
                sessionFirstBooking = true;
                getCustomerInfoView( url , tp,param1);
            }
            ///////////////////
            if(request == 'createCusInfo'){
                createCusInfo( url );
                getCustomerInfoView(url , tp );
            }
            if(request == 'validateBooking'){
                if(validateBooking(url,tp)){
                    $('#modalConfirm').modal('show');
                }
                else{
                    return false;
                }
            }
            if(request == 'createBooking'){
                $('#modalConfirm').modal('hide');
                createBooking(url , tp);
                getCustomerInfoView(url , tp );
                alert('Booking successfully Created');
            }
            if(request == 'cancel'){
                getCancelConfirmationView(url ,param1);
            }
            if(request == 'confirmCancel'){
                confirmCancel(url , tp ,param1);
            }
            if(request == 'resendConfirmationSms'){
                sendBookingConfirmationDetails(url , param1);
                getCustomerInfoView(url , tp );
            }
            if(request == 'denyCancel'){
                getCustomerInfoView(url, param1);
            }
            if(request == 'authenticateUser'){
                var relevantData = param1;//Any data related tot he next operations to be pasased as parameters
                var finalOperation = param2;//the next operation to be performed
                $('#modalPass').children("span#metaRelevantData").text(param1);
                $('#modalPass').children("span#metaFinalOperation").text(param2);
                $('#modalPass').modal('show');
                initAdminAuthenticateModalUi();
            }
            if(request == 'editBooking'){
                getEditBookingView(url,param1);
            }
            if(request == 'updateBooking'){
                updateBooking(url,param1);
                getCustomerInfoView(url , tp);
            }
            if(request == 'changeJobInfoView'){
                changeJobInfoViewByRefId(param1)
            }
            if(request == 'addUser'){
                addUserToCooperateProfile(url , tp );
            }
            if(request == 'fillAddressToBooking'){
                fillAddressToBooking(param1);
                // Initializing the UI Init again disables the check box reappearing for call up price in new booking
                return;
            }
            if(request == 'fillAddressToBookingFromHistory'){
                fillAddressToBookingFromHistory(param1);
                return;
            }
            if(request == 'addInquireCall'){
                addInquireCall(url ,param1);
                getCustomerInfoView(url , tp);
            }
            if(request == 'addComplaint'){
                addComplaint(url,param1);
                getCustomerInfoView(url , tp);
            }
            uiInit();
        }
    </script>


    <!-- Modal For Order Confirmation -->
    <div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h2 class="modal-title" id="myModalLabel">Confirm Booking Details<span id="bookingId" class="nts-label-value modalConfirm"></span></h2>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div >


                            <div style="margin:4px 30px 20px">
                                    <legend style="margin:0;; border-bottom: transparent">Location Details</legend>

                                    <div class="list-group-item" style="overflow:auto; border-top-left-radius: 4px; border-top-right-radius: 4px">
                                        <div class="col-md-3" style="padding: 0 "><div class="nts-label ">No</div></div>
                                        <div class="col-md-9" style="padding: 0 10px"><span id="no" class="nts-label-value modalConfirm">54/2 54/2 54/2</span></div>
                                    </div>
                                    <div class="list-group-item" style="overflow:auto">
                                        <div class="col-md-3" style="padding: 0"><div class="nts-label " >Road</div></div>
                                        <div class="col-md-9" style="padding: 0 10px"><span id="road" class="nts-label-value  modalConfirm">Awesome Road Awesome Road Awesome Road Awesome Road Awesome Road</span></div>
                                    </div>
                                    <div class="list-group-item" style="overflow:auto">
                                        <div class="col-md-3" style="padding: 0"><div class="nts-label  ">City</div></div>
                                        <div class="col-md-9" style="padding: 0 10px"><span id="city" class="nts-label-value  modalConfirm">Colombo Colombo</span></div>
                                    </div>

                                    <div class="list-group-item" style="overflow:auto">
                                        <div class="col-md-3" style="padding: 0"><div class="nts-label  " >Town</div></div>
                                        <div class="col-md-9" style="padding: 0 10px"><span id="town"  class="nts-label-value  modalConfirm">Town X</span></div>
                                    </div>
                                    <div class="list-group-item" style="overflow:auto">
                                        <div class="col-md-3" style="padding: 0"><div class="nts-label " >Land Mark</div></div>
                                        <div class="col-md-9" style="padding: 0 10px"><span id="landMark" class="nts-label-value  modalConfirm">Clocktower Clocktower  Clocktower Clocktower</span></div>
                                    </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <div style="margin:4px 30px 20px">
                                <div class="col-md-6" style="padding: 0px 5px 0 0px;" >
                                    <legend style="margin:0;; border-bottom: transparent">Dispatch Details</legend>

                                    <div class="list-group-item" style="overflow:auto; border-top-left-radius: 4px; border-top-right-radius: 4px">
                                        <div class="col-md-5" style="padding: 0 "><div  id="landMark" class="nts-label-small ">Remark</div></div>
                                        <div id="remark" class="col-md-7" style="padding: 0 10px"><span id="remark"  class="nts-label-value modalConfirm">Alert be on time!</span></div>
                                    </div>
                                    <div class="list-group-item" style="overflow:auto">
                                        <div class="col-md-5" style="padding: 0"><div class="nts-label-small  " >Dispatch Before</div></div>
                                        <div class="col-md-7" style="padding: 0 10px"><span id="dispatchB4"  class="nts-label-value modalConfirm">30</span></div>
                                    </div>
                                    <div class="list-group-item" style="overflow:auto">
                                        <div class="col-md-5" style="padding: 0"><div class="nts-label-small ">Call Up</div></div>
                                        <div class="col-md-7" style="padding: 0 10px"><span id="callUpPrice" class="nts-label-value modalConfirm">-</span></div>
                                    </div>

                                    <div class="list-group-item" style="overflow:auto">
                                        <div class="col-md-5" style="padding: 0"><div class="nts-label-small " >Paging Board</div></div>
                                        <div class="col-md-7" style="padding: 0 10px"><span id ="pagingBoard" class="nts-label-value modalConfirm">-</span></div>
                                    </div>

                                </div>

                                <div class="col-md-6" style="padding: 0px 0px 0 5px">
                                    <legend style="margin:0; border-bottom: transparent">Booking Details</legend>

                                    <div class="list-group-item" style="overflow:auto; border-top-left-radius: 4px; border-top-right-radius: 4px">
                                        <div class="col-md-5" style="padding: 0 "><div class="nts-label-small">Vehicle Type</div></div>
                                        <div class="col-md-7" style="padding: 0 10px"><span id ="vehicleType"  class="nts-label-value modalConfirm">Nano</span></div>
                                    </div>
                                    <div class="list-group-item" style="overflow:auto">
                                        <div class="col-md-5" style="padding: 0"><div class="nts-label-small" >Payment Type</div></div>
                                        <div class="col-md-7" style="padding: 0 10px"><span id ="payentType" class="nts-label-value modalConfirm">Cash</span></div>
                                    </div>
                                    <div class="list-group-item" style="overflow:auto">
                                        <div class="col-md-5" style="padding: 0"><div class="nts-label-small ">Booking Time</div></div>
                                        <div class="col-md-7" style="padding: 0 10px"><span  id ="bTime" class="nts-label-value modalConfirm">03:56</span></div>
                                    </div>

                                    <div class="list-group-item" style="overflow:auto">
                                        <div class="col-md-5" style="padding: 0"><div class="nts-label-small " >Booking Date</div></div>
                                        <div class="col-md-7" style="padding: 0 10px"><span id ="bDate" class="nts-label-value modalConfirm">2014-11-29</span></div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="row">
                        <div style="margin:4px 30px 20px">
                            <div style="padding: 0px 5px 0 0px;" >
                                <legend style="margin:0;; border-bottom: transparent">Booking Requirements</legend>

                                <div class="list-group-item" style="overflow:auto; border-top-left-radius: 4px; border-top-right-radius: 4px">
                                    <div class="col-md-7" style="padding: 0 10px"><span id="requirements" class="nts-label-value modalConfirm">VIP | Tinted</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="return false;"  class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" onclick="operations('createBooking');" class="btn btn-default">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Generic Modal For Admin Password Prompt -->
    <div class="modal fade" id="modalPass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <span id="metaRelevantData" style="visibility: hidden"></span>
        <span id="metaFinalOperation" style="visibility: hidden"></span>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h2 class="modal-title" id="myModalLabel">Enter Admin Password</h2>
                </div>
                <div class="modal-body">
                    <div class="row" style="padding: 35px">
                        <div class="form-group">
                            <label for="pwd">Admin Password:</label>
                            <input type="password" class="form-control" id="pwd">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="return false;"  class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" onclick="autherizeAdmin(); return false;" class="btn btn-default">Ok</button>
                </div>
            </div>
        </div>
    </div>

</body>

<script type="text/javascript" src="<?= base_url();?>assets/js/CroScripts/ViewModel.js"></script>
</html>

