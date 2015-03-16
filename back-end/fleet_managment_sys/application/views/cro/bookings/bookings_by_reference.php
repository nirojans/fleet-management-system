<div class="col-lg-12" style="padding: 1px">
    <div class="panel panel-default" style="padding: 1px">
        <div class="panel-body" style="padding: 1px">
            <div class="col-lg-6" style="padding: 1px">
    <div class="panel panel-default">
        <div class="panel-heading" style="padding: 1px">
            <h5 class="panel-title">Job Information</h5>
        </div>
        <div class="panel-body" >
            <div class="col-lg-12" style="padding-left: 1px; padding-right: 1px;" id="bookingStatus">
                <div class="panel panel-default col-lg-5" style="padding: 1px">

                    <div class="panel-body" style="padding: 1px">
                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">Status</span>
                                <span class="col-lg-8" style="padding: 1px">
                                    <span id="jobStatus" class="label label-default"><?= $status;?></span>
                                </span>
                        </div>

                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">Ref. ID</span>
                            <span class="col-lg-8" style="padding: 1px"><span class="badge" id="jobRefId"><?= $refId; ?></span></span>
                        </div>


                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">V Type</span>
                            <span id="jobVehicleType" class="col-lg-8" style="padding: 1px"><?= $vType; ?></span>
                        </div>


                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">Payment</span>
                            <span id="jobPayType" class="col-lg-8" style="padding: 1px"><?= $payType;?></span>
                        </div>

                        <div class="col-lg-12" style="padding: 1px">
                            <div class="well well-sm"><span class="col-lg-offset-3">Vehicle Details</span> </div>
                        </div>

                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">Driver ID</span>
                    <span id="jobDriverId" class="col-lg-8" style="padding: 1px">
                        <?php if($driverId == '-' )echo 'NOT_ASSIGNED';else echo $driverId;?>
                    </span>
                        </div>

                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">Cab ID</span>
                    <span id="jobCabId" class="col-lg-8" style="padding: 1px">
                        <?php if($cabId == '-' )echo 'NOT_ASSIGNED';else echo $cabId; ?>
                    </span>
                        </div>

                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">Driver Tp</span>
                    <span id="jobDriverTp" class="col-lg-8" style="padding: 1px">
                        <?php if($driverId != '-'){
                            $driver = $this->user_dao->getUser($driverId,'driver');
                            echo($driver['tp']);
                        }else{
                            echo '-';
                        } ?>
                    </span>
                        </div>

                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">[C]Color</span>
                    <span id="jobCabColor" class="col-lg-8" style="padding: 1px">
                        <?php if($cabId != '-'){
                            $cab = $this->cab_dao->getCab($cabId);
                            echo($cab['color']);
                        }else{
                            echo '-';
                        } ?>
                        </div>

                        <div class="col-lg-12">
                            <span class="col-lg-4" style="padding: 1px">Plate No</span>
                    <span id="jobCabPlateNo" class="col-lg-8" style="padding: 1px">
                        <?php if($cabId != '-'){
                            $cab = $this->cab_dao->getCab($cabId);
                            echo($cab['plateNo']);
                        }else{
                            echo '-';
                        } ?>
                    </span>
                        </div>

                    </div>
                </div>

                <div class="panel panel-default col-lg-7 " style="padding: 1px;">
                    <div class="panel-body" style="padding: 1px">
                        <span class="col-lg-3" style="padding: 1px">Address</span>
                    <span class="col-lg-9" style="padding: 1px">
                        <?= implode(", ", $address);?>
                    </span>

                        <span class="col-lg-3" style="padding: 1px">Remark</span>
                        <span id="jobRemark" class="col-lg-9" style="padding: 1px"><?= $remark?></span>

                        <span class="col-lg-3" style="padding: 1px">Destination</span>
                        <span id="jobDestination" class="col-lg-9" style="padding: 1px"><?= $destination?></span>

                        <span class="col-lg-3" style="padding: 1px">Call Up</span>
                        <span id="jobCallUpPrice" class="col-lg-9" style="padding: 1px"><?= $callUpPrice?> /=</span>

                        <span class="col-lg-3" style="padding: 1px">Specs</span>
                    <span id="jobSpecifications" class="col-lg-9" style="padding: 1px">
                        <?php if($isVip)echo 'VIP | ';?>
                        <?php if($isVih)echo  'VIH | ';?>
                        <?php if($isUnmarked) echo 'UNMARK |'?>
                        <?php if($isTinted) echo 'Tinted'?> &nbsp;
                    </span>

                        <span class="col-lg-3" style="padding: 1px">Paging[B]</span>
                        <span id="jobPagingBoard" class="col-lg-9" style="padding: 1px"><?php echo $pagingBoard;?></span>

                        <div class="col-lg-12" style="padding: 1px">
                            <div class="well well-sm"><span class="col-lg-offset-3">Time Details</span> </div>
                        </div>

                        <span class="col-lg-3" style="padding: 1px">Book Time</span>
                    <span id="jobBookTime" class="col-lg-9" style="padding: 1px">
                        <?php echo date('jS-M-y  H:i', $bookTime->sec);?>
                    </span>

                        <span class="col-lg-3" style="padding: 1px">Call Time</span>
                    <span id="jobCallTime" class="col-lg-9" style="padding: 1px">
                        <?php echo date('jS-M-y  H:i', $callTime->sec);?>
                    </span>

                        <span class="col-lg-3" style="padding: 1px">Dispatch</span>
                    <span id="jobDispatchB4" class="col-lg-9" style="padding: 1px">
                        <?= $dispatchB4;?> mins
                    </span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

            <div class="col-lg-6" style="padding: 1px">
    <div class="panel panel-default" xmlns="http://www.w3.org/1999/html">
        <div class="panel-heading" style="padding: 1px">
            <h5 class="panel-title">Customer Information</h5>
        </div>
        <div class="panel-body" >
            <?php foreach($customerProfile as $profile)?>

            <div class="col-md-12" style="padding: 1px; margin-top: 5px ">

                <div class="col-lg-3" style="padding: 1px">
                    <img style='float:left;width:134px;height:128px' src="<?= base_url() ?>assets/img/profile_pic.jpg" />

                </div>

                <div class="col-lg-9" style="padding: 1px">
                    <div class="col-lg-12">
                        <span class="col-lg-3">Name</span>
                    <span class="col-lg-9">
                        <?= $profile['title']?>
                        <?php if($profile['position'] !=  '-'){
                            echo '(' . $profile['position']. ')';
                        }?>
                        <?= $profile['name']?></span>
                    </div>

                    <div class="col-lg-12">
                        <span class="col-lg-3">Telephone 1</span>
                        <span class="col-lg-9"><?= $profile['tp']?></span>
                    </div>

                    <div class="col-lg-12">
                        <span class="col-lg-3">Telephone 2</span>
                        <span class="col-lg-9"><?= $profile['tp2']?></span>
                    </div>

                    <div class="col-lg-12">
                        <span class="col-lg-3">Remark[P]</span>
                        <span class="col-lg-9"><?= $profile['pRemark']?></span>
                    </div>

                    <div class="col-lg-12">
                        <span class="col-lg-3">Organization</span>
                        <span class="col-lg-9"><?= $profile['org']?></span>
                    </div>

                    <div class="col-lg-12">
                        <span class="col-lg-3">Profile</span>
                        <span class="col-lg-9"><?= $profile['profileType']?></span>
                    </div>

                    <div class="col-lg-12">
                        <span class="col-lg-3">Job Count</span>
                        <span class="col-lg-9"><?= $profile['tot_job']?></span>
                    </div>

                    <div class="col-lg-12">
                        <span class="col-lg-3">Cancel [T]</span>
                        <span class="col-lg-9"><?= $profile['tot_cancel']?></span>
                    </div>

                    <div class="col-lg-12">
                        <span class="col-lg-3">Cancel [D]</span>
                        <span class="col-lg-9"><?= $profile['dis_cancel']?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>

