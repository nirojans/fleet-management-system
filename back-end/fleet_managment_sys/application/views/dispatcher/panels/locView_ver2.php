<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        setBaseURL('<?= base_url().'index.php/' ?>');
    </script>
    <!-------------------------------- CSS Files------------------------------------>
    <!--    <link rel="stylesheet" type="text/css" href="--><?//= base_url();?><!--assets/css/bootstrap.css">-->
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/webLibs/bootstrapvalidator-dist-0.5.2/dist/css/bootstrapValidator.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/webLibs/bootstrap-timepicker/css/bootstrap-timepicker.css">



    <!-------------------------------- JS Files------------------------------------>
    <!--    <script type="text/javascript" src="--><?//= base_url();?><!--assets/js/jquery-1.10.2.js"></script>-->
    <!--    <script type="text/javascript" src="--><?//= base_url();?><!--assets/js/bootstrap.js"></script>-->
    <script type="text/javascript" src="<?= base_url();?>assets/js/cro_operations.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/webLibs/bootstrap-timepicker/js/bootstrap-timepicker.js" charset="UTF-8"></script>

    <script type="text/javascript" src="<?= base_url();?>assets/webLibs/bootstrapvalidator-dist-0.5.2/dist/js/bootstrapValidator.js" charset="UTF-8"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/webLibs/knockout/knockout-3.2.0.js"></script>

    <!--Do not play with the classes the following depedencies are used in JS External Scripts-->
    <!--element === input ||| class === cabId ===> Used to activate button at enter-->

    <style>
        input.locIdleInput{
            width: 50px;
            height: 26px;
            padding: 5px;
            display: inline;
            font-size: 13px;
        }
        input.locPobInput{
            width: 50px;
            height: 26px;
            padding: 5px;
            display: inline;
            font-size: 13px;
        }

        ul.cabs{
            list-style: none;
            padding: 0;
            margin: 0;
        }

        li.cab{
            display: inline;
        }

        .cabView{
            width: auto;
            min-width: 90px;
            display: inline;
            margin-bottom: 2%;
            margin-right: 2%;
            height: 28px;
            padding: 1px;

        }
        button.cabAdd{
            width: 25px;
            display: inline;
            height: 25px;
            padding: 1px;
            margin: 0;
        }

        .dropdown-menu2{

            left:-217%;
        }


        .dropdown-menu1{

            left:-45%;
        }
        .panel-heading{
            font-size: 150%;
        }




    </style>

</head>
<body>
<!--<h1 id="locationHeading" style="text-align: center; margin-bottom: 0">Location Board</h1>-->

<div id="LocationContainer" >

    <div style="background-color: #ffffff">
        <ul class="nav nav-tabs" style="position: fixed; background-color: #ffffff; width:100%;z-index:1">
            <li class="active"><a data-toggle="tab" href="#sectionA">Free</a></li>
            <li><a data-toggle="tab" href="#sectionB">Pending</a></li>
            <li><a data-toggle="tab" href="#sectionC">POB</a></li>
            <li><a data-toggle="tab" href="#sectionD">Inactive</a></li>
        </ul>
    </div>
    <div style="height: 7%">

    </div>
    <div class="tab-content">
        <div id="sectionA" class="tab-pane fade in active">
            <div id="idleContainer" class="tab-pane" style="padding: 2%">
                <div class="panel panel-success locationPanel">
                    <div class="panel-heading text-center">
                        <span>Available Cabs</span>
                    </div>
                    <div class="panel-body">

                        <div id="zonesContainer">
                            <div class="table-responsive" style="width:100%; margin:0">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th  class="col-md-2">Zone</th>
                                        <th  class="col-md-2">Add Cab</th>
                                        <th  class="col-md-8">Available Cabs</th>

                                    </tr>
                                    </thead>
                                    <tbody data-bind="foreach:Zones">
                                    <tr>
                                        <td class="col-md-2" data-bind="text:name" ></td>
                                        <td class="col-md-2">
                                            <input data-bind="attr:{id:id}, value:idle.cabId" class="form-control cabId locIdleInput" type="text" placeholder="Cab Id">
                                            <button data-bind="click:$root.addIdleCab" class="form-control cabAdd">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </td>
                                        <td class="col-md-8">
                                            <ul style="display: inline" class="cabs" data-bind="foreach:idle.cabs">
                                                <li style="display: inline">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-success dropdown-toggle cabView" data-toggle="dropdown" data-bind="click:$root.updateStatus">
                                                            <span data-bind="text:vehicleType"></span>
                                                            <span data-bind="text:id">2342 &nbsp;</span>
                                                            <span class="caret"></span>
                                                        </button>

                                                        <div class="dropdown-menu dropdown-menu1" role="menu" style="  padding: 10px; min-width: 400%; border-radius: 5px">

                                                            <div class="panel panel-success">
                                                                <div class="panel-heading">
                                                                    <h2 class="panel-title" data-bind="text:vehicleType + ' '+ id + ' Info' "></h2>
                                                                </div>

                                                                <div class="panel-body" style="padding: 3%">
                                                                    <div style="margin:0">
                                                                        <table class="table table-bordered" style="margin-bottom:2%">
                                                                            <thead>
                                                                            <tr>
                                                                                <th style="width:30%">Attribute</th>
                                                                                <th>Value</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody><!--
                                                                            <tr>
                                                                                <td><span>State</span></td>
                                                                                <td><span data-bind="text:state"></span></td>
                                                                            </tr>-->
                                                                            <tr>
                                                                                <td><span>Vehicle Type</span></td>
                                                                                <td><span data-bind="text:vehicleType"></span></td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td><span>Model</span></td>
                                                                                <td><span data-bind="text:model"></span></td>
                                                                            </tr>

                                                                            <!--tr>
                                                                                <td><span>Is Tinted?</span></td>
                                                                                <td><span data-bind="text:isTinted"></span></td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td><span>Is Marked?</span></td>
                                                                                <td><span data-bind="text:isMarked"></span></td>
                                                                            </tr-->
                                                                            <tr>
                                                                                <td><span>Vehicle Colour</span></td>
                                                                                <td><span data-bind="text:vehicleColor"></span></td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td><span>Information</span></td>
                                                                                <td><span data-bind="text:info"></span></td>
                                                                            </tr>



                                                                            </tbody>
                                                                        </table>

                                                                        <div class="row" style="float:right; margin:0">
                                                                            <button class="btn btn-success cabManipulate" data-bind="click:$root.dispatchCab.bind($data , $parent )">Assign Cab</button>
                                                                            <button class="btn btn-success cabManipulate" data-bind="click:$root.removeCabAndSetToNone.bind($data , $parent )">Remove</button>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="sectionB" class="tab-pane fade">
            <div id="pendingContainer" class="tab-pane" style="padding: 2%">
                <div>
                    <div class="panel panel-danger locationPanel">
                        <div class="panel-heading text-center">
                            <span>Driver Engaged - Passenger Pending</span>
                        </div>
                        <div class="panel-body" style="min-height: 65px">
                            <ul style="display: inline" class="cabs" data-bind="foreach:pendingCabs">
                                <li style="display: inline">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-danger dropdown-toggle cabView" data-toggle="dropdown" data-bind="click:$root.updateStatus">
                                            <span data-bind="text:vehicleType"></span>
                                            <span data-bind="text:id">2342 &nbsp;</span>
                                            <span class="caret"></span>
                                        </button>

                                        <div class="dropdown-menu dropdown-menu1" role="menu" style="  padding: 10px; min-width: 400%; border-radius: 5px">

                                            <div class="panel panel-danger">
                                                <div class="panel-heading">
                                                    <h2 class="panel-title" data-bind="text:vehicleType + ' '+ id + ' Info' "></h2>
                                                </div>

                                                <div class="panel-body" style="padding: 3%">
                                                    <div style="margin:0">
                                                        <table class="table table-bordered" style="margin-bottom:2%">
                                                            <thead>
                                                            <tr>
                                                                <th style="width:30%">Attribute</th>
                                                                <th>Value</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td><span>State</span></td>
                                                                <td><span data-bind="text:state"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td><span>Vehicle Type</span></td>
                                                                <td><span data-bind="text:vehicleType"></span></td>
                                                            </tr>

                                                            <tr>
                                                                <td><span>Model</span></td>
                                                                <td><span data-bind="text:model"></span></td>
                                                            </tr>

                                                            <!--tr>
                                                                <td><span>Is Tinted?</span></td>
                                                                <td><span data-bind="text:isTinted"></span></td>
                                                            </tr>

                                                            <tr>
                                                                <td><span>Is Marked?</span></td>
                                                                <td><span data-bind="text:isMarked"></span></td>
                                                            </tr-->
                                                            <tr>
                                                                <td><span>Vehicle Colour</span></td>
                                                                <td><span data-bind="text:vehicleColor"></span></td>
                                                            </tr>

                                                            <tr>
                                                                <td><span>Information</span></td>
                                                                <td><span data-bind="text:info"></span></td>
                                                            </tr>



                                                            </tbody>
                                                        </table>

                                                        <div class="row" style="float:right; margin:0">
                                                            <button class="btn btn-danger cabManipulate" data-bind="click:$root.removeCabAndSetToNone.bind($data , $parent )">Remove Cab</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div id="sectionC" class="tab-pane fade">
            <div id="pobContainer" class="tab-pane" style="padding: 2%">

                <div class="panel panel-warning locationPanel">
                    <div class="panel-heading text-center">
                        <span>POB - Forecasted Free Cabs</span>
                    </div>
                    <div class="panel-body">
                        <div id="pobZonesContainer">
                            <div class="table-responsive" style="width:100%; margin:0">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th  class="col-md-2">Destination Zone</th>
                                        <th  class="col-md-2">Add Cab</th>
                                        <th  class="col-md-8">Available Cabs</th>

                                    </tr>
                                    </thead>
                                    <tbody data-bind="foreach:PobZones">
                                    <tr>
                                        <td class="col-md-2" data-bind="text:name" ></td>
                                        <td class="col-md-2">

                                            <input data-bind="attr:{id:id}, value:pob.cabEta" class="form-control cabEta locPobInput" type="text" placeholder="ETA" >
                                            <input data-bind="attr:{id:id}, value:pob.cabId" class="form-control cabId locPobInput" type="text" placeholder="Cab Id">
                                            <button data-bind="click:$root.addPobCab" class="form-control cabAdd">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </td>
                                        <td class="col-md-8">
                                            <ul style="display: inline" class="cabs" data-bind="foreach:pob.cabs">
                                                <li style="display: inline">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-warning dropdown-toggle cabView" data-toggle="dropdown" data-bind="click:$root.updateStatus">
                                                            <span data-bind="text:vehicleType"></span>
                                                            <span data-bind="text:id">2342 &nbsp;</span>
                                                            <span class="caret"></span>
                                                        </button>

                                                        <div class="dropdown-menu dropdown-menu1" role="menu" style="  padding: 10px; min-width: 400%; border-radius: 5px">

                                                            <div class="panel panel-warning">
                                                                <div class="panel-heading">
                                                                    <h2 class="panel-title" data-bind="text:vehicleType + ' '+ id + ' Info' "></h2>
                                                                </div>

                                                                <div class="panel-body" style="padding: 3%">
                                                                    <div style="margin:0">
                                                                        <table class="table table-bordered" style="margin-bottom:2%">
                                                                            <thead>
                                                                            <tr>
                                                                                <th style="width:30%">Attribute</th>
                                                                                <th>Value</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <tr>
                                                                                <td><span>State</span></td>
                                                                                <td><span data-bind="text:state"></span></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><span>ETA</span></td>
                                                                                <td><span data-bind="text:eta"></span></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><span>Vehicle Type</span></td>
                                                                                <td><span data-bind="text:vehicleType"></span></td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td><span>Model</span></td>
                                                                                <td><span data-bind="text:model"></span></td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td><span>Colour</span></td>
                                                                                <td><span data-bind="text:vehicleColor"></span></td>
                                                                            </tr>

                                                                            <!--tr>
                                                                                <td><span>Is Tinted?</span></td>
                                                                                <td><span data-bind="text:isTinted"></span></td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td><span>Is Marked?</span></td>
                                                                                <td><span data-bind="text:isMarked"></span></td>
                                                                            </tr-->
                                                                            <tr>
                                                                                <td><span>Information</span></td>
                                                                                <td><span data-bind="text:info"></span></td>
                                                                            </tr>



                                                                            </tbody>
                                                                        </table>

                                                                        <div class="row" style="float:right; margin:0">
                                                                            <button class="btn btn-warning cabManipulate" data-bind="click:$root.setToIdleFromPob.bind($data , $parent )">Set Idle</button>
                                                                            <button class="btn btn-warning cabManipulate" data-bind="click:$root.removeCabAndSetToNone.bind($data , $parent )">Remove</button>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="sectionD" class="tab-pane fade">
            <div id="otherContainer" class="tab-pane" style="padding: 2%">

                <div class="panel panel-default locationPanel">
                    <div class="panel-heading text-center">
                        <span>Inactive Board</span>
                    </div>
                    <div class="panel-body">

                        <!--Others-->
                        <div id="otherContainer" >
                            <div class="table-responsive" style="width:100%; margin:0">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th  class="col-md-2">Category</th>
                                        <th  class="col-md-2">Add Cab</th>
                                        <th  class="col-md-8">Available Cabs</th>

                                    </tr>
                                    </thead>
                                    <tbody data-bind="foreach:Others">
                                    <tr>
                                        <td class="col-md-2" data-bind="text:name" ></td>
                                        <td class="col-md-2">
                                            <input data-bind="attr:{id:id}, value:cabId" class="form-control cabId locPobInput" type="text" placeholder="Cab Id">
                                            <button data-bind="click:$root.addOtherCab" class="form-control cabAdd">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </td>
                                        <td class="col-md-8">
                                            <ul style="display: inline" class="cabs" data-bind="foreach:cabs">
                                                <li style="display: inline">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-defaultdropdown-toggle cabView" data-toggle="dropdown" data-bind="click:$root.updateStatus">
                                                            <span data-bind="text:vehicleType"></span>
                                                            <span data-bind="text:id">2342 &nbsp;</span>
                                                            <span class="caret"></span>
                                                        </button>

                                                        <div class="dropdown-menu dropdown-menu1" role="menu" style="  padding: 10px; min-width: 400%; border-radius: 5px">

                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h2 class="panel-title" data-bind="text:vehicleType + ' '+ id + ' Info' "></h2>
                                                                </div>

                                                                <div class="panel-body" style="padding: 3%">
                                                                    <div style="margin:0">
                                                                        <table class="table table-bordered" style="margin-bottom:2%">
                                                                            <thead>
                                                                            <tr>
                                                                                <th style="width:30%">Attribute</th>
                                                                                <th>Value</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <!--<tr>
                                                                                <td><span>State</span></td>
                                                                                <td><span data-bind="text:state"></span></td>
                                                                            </tr>--><!--
                                                                            <tr>
                                                                                <td><span>ETA</span></td>
                                                                                <td><span data-bind="text:eta"></span></td>
                                                                            </tr>-->
                                                                            <tr>
                                                                                <td><span>Vehicle Type</span></td>
                                                                                <td><span data-bind="text:vehicleType"></span></td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td><span>Model</span></td>
                                                                                <td><span data-bind="text:model"></span></td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td><span>Colour</span></td>
                                                                                <td><span data-bind="text:vehicleColor"></span></td>
                                                                            </tr>

                                                                            <!--tr>
                                                                                <td><span>Is Tinted?</span></td>
                                                                                <td><span data-bind="text:isTinted"></span></td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td><span>Is Marked?</span></td>
                                                                                <td><span data-bind="text:isMarked"></span></td>
                                                                            </tr-->
                                                                            <tr>
                                                                                <td><span>Information</span></td>
                                                                                <td><span data-bind="text:info"></span></td>
                                                                            </tr>



                                                                            </tbody>
                                                                        </table>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="height: 80%">

    </div>



</div>




<script type="text/javascript" src="<?= base_url();?>assets/js/LocationBoardScripts/ViewModel.js" charset="UTF-8"></script>
<script type="text/javascript">
    $('.timePicker').timepicker({
        defaultTime: false
    });
</script>

</body>
</html>