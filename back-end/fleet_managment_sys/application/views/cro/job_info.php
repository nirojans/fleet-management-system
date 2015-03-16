<div class="panel panel-default">
    <div class="panel-heading" style="padding: 1px">
        <h5 class="panel-title">Job Information</h5>
    </div>
    <div class="panel-body" >
        <?php if(isset($live_booking) ):?>
            <?php $index=sizeof($live_booking)-1;?>
            <div class="col-lg-12" style="padding-left: 1px; padding-right: 1px;" id="bookingStatus">

                <div class="col-lg-12" style="padding: 1px ;">
                    <div class="well well-sm" style="background-color: #e3e3e4"><span class="col-lg-offset-4" >Pending Bookings <?= sizeof($live_booking);?></span> </div>
                </div>


                <div class="panel panel-default col-lg-5" style="padding: 1px">

                    <div class="panel-body" style="padding: 1px">
                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">Status</span>
                                <span class="col-lg-8" style="padding: 1px">
                                    <span id="jobStatus" class="label label-default"><?= $live_booking[$index]['status'];?></span>
                                </span>
                        </div>

                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">Ref. ID</span>
                            <span class="col-lg-8" style="padding: 1px"><span class="badge" id="jobRefId"><?= $live_booking[$index]['refId']; ?></span></span>
                        </div>


                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">V Type</span>
                            <span id="jobVehicleType" class="col-lg-8" style="padding: 1px"><?= $live_booking[$index]['vType']; ?></span>
                        </div>


                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">Payment</span>
                            <span id="jobPayType" class="col-lg-8" style="padding: 1px"><?= $live_booking[$index]['payType'];?></span>
                        </div>

                        <div class="col-lg-12" style="padding: 1px">
                            <div class="well well-sm"><span class="col-lg-offset-3">Vehicle Details</span> </div>
                        </div>

                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">Driver ID</span>
                            <span id="jobDriverId" class="col-lg-8" style="padding: 1px">
                                <?php if($live_booking[$index]['driverId'] == '-' )echo 'NOT_ASSIGNED';else echo $live_booking[$index]['driverId'];?>
                            </span>
                        </div>

                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">Cab ID</span>
                            <span id="jobCabId" class="col-lg-8" style="padding: 1px">
                                <?php if($live_booking[$index]['cabId'] == '-' )echo 'NOT_ASSIGNED';else echo $live_booking[$index]['cabId']; ?>
                            </span>
                        </div>

                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">Driver Tp</span>
                            <span id="jobDriverTp" class="col-lg-8" style="padding: 1px"><?= $live_booking[$index]['driverTp'];?></span>
                        </div>

                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">[C]Color</span>
                            <span id="jobCabColor" class="col-lg-8" style="padding: 1px"><?= $live_booking[$index]['cabColor'];?></span>
                        </div>

                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">Plate No</span>
                            <span id="jobCabPlateNo" class="col-lg-8" style="padding: 1px"><?= $live_booking[$index]['cabPlateNo'];?></span>
                        </div>

                </div>
                </div>

                <div class="panel panel-default col-lg-7 " style="padding: 1px;">
                <div class="panel-body" style="padding: 1px">
                    <span class="col-lg-3" style="padding: 1px">Address</span>
                    <span class="col-lg-9" style="padding: 1px">
                        <a href="#newBooking" id="jobAddress" onclick="operations('fillAddressToBooking', '<?= $live_booking[$index]['_id']?>')">
                            <?= implode(", ", $live_booking[$index]['address']);?>
                        </a>
                    </span>

                    <span class="col-lg-3" style="padding: 1px">Remark</span>
                    <span id="jobRemark" class="col-lg-9" style="padding: 1px"><?= $live_booking[$index]['remark']?></span>

                    <span class="col-lg-3" style="padding: 1px">Destination</span>
                    <span id="jobDestination" class="col-lg-9" style="padding: 1px"><?= $live_booking[$index]['destination']?></span>

                    <span class="col-lg-3" style="padding: 1px">Call Up</span>
                    <span id="jobCallUpPrice" class="col-lg-9" style="padding: 1px"><?= $live_booking[$index]['callUpPrice']?> /=</span>

                    <span class="col-lg-3" style="padding: 1px">Specs</span>
                    <span id="jobSpecifications" class="col-lg-9" style="padding: 1px">
                        <?php if($live_booking[$index]['isVip'])echo 'VIP | ';?>
                        <?php if($live_booking[$index]['isVih'])echo  'VIH | ';?>
                        <?php if($live_booking[$index]['isUnmarked']) echo 'UNMARK |'?>
                        <?php if($live_booking[$index]['isTinted']) echo 'Tinted'?> &nbsp;
                    </span>

                    <span class="col-lg-3" style="padding: 1px">Paging[B]</span>
                    <span id="jobPagingBoard" class="col-lg-9" style="padding: 1px"><?php echo $live_booking[$index]['pagingBoard'];?></span>

                    <div class="col-lg-12" style="padding: 1px">
                        <div class="well well-sm"><span class="col-lg-offset-3">Time Details</span> </div>
                    </div>

                    <span class="col-lg-3" style="padding: 1px">Book Time</span>
                    <span id="jobBookTime" class="col-lg-9" style="padding: 1px">
                        <?php echo date('jS-M-y  H:i', $live_booking[$index]['bookTime']->sec);?>
                    </span>

                    <span class="col-lg-3" style="padding: 1px">Call Time</span>
                    <span id="jobCallTime" class="col-lg-9" style="padding: 1px">
                        <?php echo date('jS-M-y  H:i', $live_booking[$index]['callTime']->sec);?>
                    </span>

                    <span class="col-lg-3" style="padding: 1px">Dispatch</span>
                    <span id="jobDispatchB4" class="col-lg-9" style="padding: 1px">
                        <?= $live_booking[$index]['dispatchB4'];?> mins
                    </span>
                </div>
            </div>

                <div class="col-lg-12" style="margin-top: 5px ; padding: 1px">

                <div class="btn-group btn-group-justified" role="group" aria-label="...">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default btn-sm" id="jobEditButton"
                            onclick="operations('authenticateUser', '<?= $live_booking[$index]['_id'];?>','editBooking')">
                            <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Update
                        </button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default btn-sm" id="jobInquireButton"
                                onclick="operations('addInquireCall', '<?= $live_booking[$index]['_id'];?>')">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Inquire
                        </button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default btn-sm" id="jobComplaintButton"
                                onclick="operations('addComplaint', '<?= $live_booking[$index]['refId'];?>')">
                            <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Complaint
                        </button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default btn-sm" id="jobCancelButton"
                                onclick="operations('authenticateUser','<?= $live_booking[$index]['_id'];?>','cancel')">
                            <span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Cancel
                        </button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default btn-sm" id="jobConfirmSmsResendButton"
                                onclick="operations('resendConfirmationSms', '<?= $live_booking[$index]['refId'];?>')">
                            <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Resend SMS
                        </button>
                    </div>
                </div>
            </div>
            </div>
        <?php endif;?>

        <div class="col-lg-12" style="max-height: 150px ; overflow: auto; font-size: 12px">
            <?php if(isset($live_booking) && sizeof($live_booking) != 1):?>
                <table class="table table-striped" style="margin-top: 3%;">
                    <tr>
                        <th>Status</th>
                        <th>Ref ID</th>
                        <th>Call Time</th>
                        <th>Book Time</th>
                        <th>Address</th>
                        <th>Remark</th>
                    </tr>
                    <?php foreach(array_reverse($live_booking) as $item):?>
                        <tr>
                            <td><a href="#" onclick="changeJobInfoViewByRefId('<?= $item['_id']?>')"><?= $item['status'];?></a></td>
                            <td><?= $item['refId'];?></td>
                            <td><?=  date('jS-M-y  H:i', $item['callTime']->sec);?></td>
                            <td><?=  date('jS-M-y  H:i', $item['bookTime']->sec);?></td>
                            <td>
                                <a href="#newBooking" onclick="operations('fillAddressToBooking', '<?= $item['_id']?>')">
                                    <?= implode(", ", $item['address']);?>
                                </a>
                            </td>
                            <td><?= $item['remark'];?></td>
                        </tr>

                    <?php endforeach?>
                </table>
            <?php endif;?>
        </div>

        <?php if(!(isset($live_booking)) && isset($history_booking) && sizeof($history_booking) != 0 ):?>
            <div class="col-lg-12" style="padding-left: 1px; padding-right: 1px;" id="bookingStatus">
                <?php $index=sizeof($history_booking)-1;?>


                <div class="col-lg-12" style="padding: 1px ;">
                    <div class="well well-sm" style="background-color: #B5B5B6"><span class="col-lg-offset-4" >No Pending Bookings</span> </div>
                </div>

                <div class="panel panel-default col-lg-5" style="padding: 1px">

                    <div class="panel-body" style="padding: 1px">

                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">Status</span>
                                <span class="col-lg-8" style="padding: 1px">
                                    <span id="jobStatus" class="label label-default"><?= $history_booking[$index]['status'];?></span>
                                </span>
                        </div>

                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">Ref. ID</span>
                            <span class="col-lg-8" style="padding: 1px"><span class="badge" id="jobRefId"><?= $history_booking[$index]['refId']; ?></span></span>
                        </div>


                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">V Type</span>
                            <span id="jobVehicleType" class="col-lg-8" style="padding: 1px"><?= $history_booking[$index]['vType']; ?></span>
                        </div>


                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">Payment</span>
                            <span id="jobPayType" class="col-lg-8" style="padding: 1px"><?= $history_booking[$index]['payType'];?></span>
                        </div>

                        <div class="col-lg-12" style="padding: 1px">
                            <div class="well well-sm"><span class="col-lg-offset-3">Vehicle Details</span> </div>
                        </div>

                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">Driver ID</span>
                            <span id="jobDriverId" class="col-lg-8" style="padding: 1px">
                                <?php if($history_booking[$index]['driverId'] == '-' )echo 'NOT_ASSIGNED';else echo $history_booking[$index]['driverId'];?>
                            </span>
                        </div>

                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">Cab ID</span>
                            <span id="jobCabId" class="col-lg-8" style="padding: 1px">
                                <?php if($history_booking[$index]['cabId'] == '-' )echo 'NOT_ASSIGNED';else $history_booking[$index]['cabId']; ?>
                            </span>
                        </div>

                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">Driver Tp</span>
                            <span id="jobDriverTp" class="col-lg-8" style="padding: 1px"><?= $history_booking[$index]['driverTp'];?></span>
                        </div>

                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">[C]Color</span>
                            <span id="jobCabColor" class="col-lg-8" style="padding: 1px"><?= $history_booking[$index]['cabColor'];?></span>
                        </div>

                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">Plate No</span>
                            <span id="jobCabPlateNo" class="col-lg-8" style="padding: 1px"><?= $history_booking[$index]['cabPlateNo'];?></span>
                        </div>

                    </div>
                </div>

                <div class="panel panel-default col-lg-7 " style="padding: 1px;">
                    <div class="panel-body" style="padding: 1px">
                        <span class="col-lg-3" style="padding: 1px">Address</span>
                    <span class="col-lg-9" style="padding: 1px">
                        <a href="#newBooking" id="jobAddress" onclick="operations('fillAddressToBookingFromHistory', '<?= $history_booking[$index]['_id']?>')">
                            <?= implode(", ", $history_booking[$index]['address']);?>
                        </a>
                    </span>

                        <span class="col-lg-3" style="padding: 1px">Remark</span>
                        <span id="jobRemark" class="col-lg-9" style="padding: 1px"><?= $history_booking[$index]['remark']?></span>

                        <span class="col-lg-3" style="padding: 1px">Destination</span>
                        <span id="jobDestination" class="col-lg-9" style="padding: 1px"><?= $history_booking[$index]['destination']?></span>

                        <span class="col-lg-3" style="padding: 1px">Call Up</span>
                        <span id="jobCallUpPrice" class="col-lg-9" style="padding: 1px"><?= $history_booking[$index]['callUpPrice']?> /=</span>

                        <span class="col-lg-3" style="padding: 1px">Specs</span>
                    <span id="jobSpecifications" class="col-lg-9" style="padding: 1px">
                        <?php if($history_booking[$index]['isVip'])echo 'VIP | ';?>
                        <?php if($history_booking[$index]['isVih'])echo  'VIH | ';?>
                        <?php if($history_booking[$index]['isUnmarked']) echo 'UNMARK |'?>
                        <?php if($history_booking[$index]['isTinted']) echo 'Tinted'?>
                    </span>

                        <span class="col-lg-3" style="padding: 1px">Paging[B]</span>
                        <span id="jobPagingBoard" class="col-lg-9" style="padding: 1px"><?php echo $history_booking[$index]['pagingBoard'];?></span>

                        <div class="col-lg-12" style="padding: 1px">
                            <div class="well well-sm"><span class="col-lg-offset-3">Time Details</span> </div>
                        </div>

                        <span class="col-lg-3" style="padding: 1px">Book Time</span>
                    <span id="jobBookTime" class="col-lg-9" style="padding: 1px">
                        <?php echo date('jS-M-y  H:i', $history_booking[$index]['bookTime']->sec);?>
                    </span>

                        <span class="col-lg-3" style="padding: 1px">Call Time</span>
                    <span id="jobCallTime" class="col-lg-9" style="padding: 1px">
                        <?php echo date('jS-M-y  H:i', $history_booking[$index]['callTime']->sec);?>
                    </span>

                        <span class="col-lg-3" style="padding: 1px">Dispatch</span>
                    <span id="jobDispatchB4" class="col-lg-9" style="padding: 1px">
                        <?= $history_booking[$index]['dispatchB4'];?> mins
                    </span>
                    </div>
                </div>

            </div>

        <?php endif;?>

    </div>
</div>
