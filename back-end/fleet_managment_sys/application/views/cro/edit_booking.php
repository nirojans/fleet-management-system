<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">New Order</h3>
    </div>
    <div class="panel-body" >
        <form id="editBookingForm">
            <div class="col-lg-5">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Location Details</h3>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label">Number</label>
                            <input class="form-control" type="text" value="<?= $address['no']?>"  id="no"      name="no"      placeholder="Number" >
                        </div>
                        <div class="form-group">
                            <label>Road</label>
                            <input type="text" class="form-control" value="<?= $address['road']?>" id="road"     name="road"     placeholder="Road" >
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control" value="<?= $address['city']?>" id="city"     name="city"     placeholder="City">
                        </div>
                        <div class="form-group">
                            <label>Town</label>
                            <input type="text" class="form-control" value="<?= $address['town']?>" id="town"     name="town"     placeholder="Town">
                        </div>
                        <div class="form-group">
                            <label>Land Mark</label>
                            <input type="text" class="form-control" value="<?= $address['landmark']?>" id="landMark" name="landMark" placeholder="Land Mark">
                        </div>
                    </div>

                </div>

                <div class="panel panel-success" style="margin-top:2%">
                    <div class="panel-heading">
                        <h3 class="panel-title">Other Dispatch Details</h3>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label>Remark</label>
                            <input type="text" class="form-control" value="<?= $remark?>" id="remark"       name="remark"    placeholder="Remark">
                        </div>
                        <div class="form-group">
                            <label>Dispatch Before<small style="font-weight: lighter"> [In Minutes]</small></label>
                            <input type="text" class="form-control" id="dispatchB4"   name="dispatchBefore"   value="<?= $dispatchB4;?>" placeholder="Dispatch Before">
                        </div>

                        <div class="form-group">
                            <label for="callUpPrice" style="font-weight: bold"> Call Up Given
                            </label>
                            <input type="text" class="form-control" id="callUpPrice" value="<?= $callUpPrice?>" name="callUpPrice" placeholder="Call Up Price" >
                        </div>

                        <div class="form-group">
                            <label for="destination" style="font-weight: bold"> Destination
                            </label>
                            <input type="text" class="form-control" id="destination" value="<?= $destination?>" name="destination" placeholder="Given Destination" >
                        </div>

                        <div class="form-group">
                            <label for="pagingBoard" style="font-weight: bold"> Paging Board
                            </label>
                            <input type="text" class="form-control " id="pagingBoard" value="<?= $pagingBoard?>" name="pagingBoard" placeholder="Paging Board Name" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5" style="border-left: 2px solid #eee" >
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Booking Details</h3>
                    </div>

                    <div class="panel-body">

                        <div class="form-group">
                            <label class="control-label" style="font-weight:bold">Vehicle Type</label></br>
                            <div class="btn-group">
                                <button type="button" id="carRadio"  data-set="vehicle" value="car" class="btn btn-default customRadio" >Car</button>
                                <button type="button" id="vanRadio"  data-set="vehicle" value="van" class="btn btn-default customRadio" >Van</button>
                                <button type="button" id="nanoRadio"   data-set="vehicle" value="nano" class="btn btn-default customRadio" >Nano</button>
                            </div>
                            <input style="display: none" class="customRadio" name="vehicleType" id="vehicleType">

                        </div>

                        <div class="form-group">
                            <label class="control-label" style="font-weight:bold">Payment Type</label></br>
                            <div class="btn-group">
                                <button id="payTypeCash" type="button" data-set="payment" value="cash" class="btn btn-default customRadio" >Cash</button>
                                <button id="payTypeCredit" type="button" data-set="payment" value="credit" class="btn btn-default customRadio" >Credit Card</button>
                            </div>
                            <input style="display: none" class="customRadio" name="paymentType" id="paymentType">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Booking Time</label>
                            <div id="form_time" class="input-group date" data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">
                                <input id="bTime" name="bTime" class="form-control" name= size="16" type="text" value="<?php echo date('H:i', $bookTime->sec);?>" readonly="readonly">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-time" onclick="showCalender()"></span></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Booking Date</label>
                            <div id="form_date" class="input-group date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                <input id="bDate" name="bDate" class="form-control" size="16" type="text" value="<?php echo date('Y-m-d ', $bookTime->sec);?>" readonly="readonly">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" onclick="showCalender()"></span></span>
                            </div>
                        </div>

                        <div class="form-group">
                                <label style="font-weight: bold">Air Port Package</label>
                                <select id="airportPackage" onchange="fillAirportPackageinBookings()" class="form-inline checkBoxElementAppearing" >
                                    <option value="-">NOT SELECTED</option>
                                    <?php foreach($airportPackages['data'] as $package):?>
                                        <option value="<?= $package['packageId']?>"
                                            <?php if(isset($packageId) && ($package['packageId'] == $packageId))echo "selected";?>>
                                            <?= $package['packageName']?>
                                        </option>
                                    <?php endforeach;?>
                                </select>

                                <select id="airportPackageType" onchange="selectAirportPackageandAddRemark()" class="form-inline checkBoxElementAppearing" >
                                    <option value="-">NOT SELECTED</option>
                                    <?php foreach($airportPackages['data'] as $package):?>
                                        <?php if(isset($packageId) && ($package['packageId'] == $packageId)):?>
                                            <option value="drop" <?php if($packageType == 'drop') echo "selected"?>> Drop (<?= $package['dropFee']?>)</option>
                                            <option value="bothWay" <?php if($packageType == 'bothWay') echo "selected"?>> Both Way (<?= $package['bothwayFee']?>)</option>
                                            <option value="guestCarrier" <?php if($packageType == 'guestCarrier') echo "selected"?>> Guest Carrier (<?= $package['guestCarrierFee']?>)</option>
                                            <option value="outSide" <?php if($packageType == 'outSide') echo "selected"?>> Out Side (<?= $package['outsideFee']?>)</option>
                                        <?php endif;?>
                                        <?= $package['packageName']?>
                                    <?php endforeach;?>
                                    <?php if($packageType == 'drop' || $packageType == 'bothWay' || $packageType == 'guestCarrier' || $packageType == 'outSide'):?>

                                    <?php endif?>
                                </select>
                        </div>


                        <div class="form-group">
                            <label style="font-weight: bold">Day Packages</label>

                            <select id="dayPackage" onchange="selectDayPackageandAddRemark()" class="form-inline checkBoxElementAppearing">
                                <option value="-">NOT SELECTED</option>
                                <?php foreach($dayPackages['data'] as $package):?>
                                    <option value="<?= $package['packageId']?>"
                                        <?php if(isset($packageId) && ($package['packageId'] == $packageId))echo "selected";?>>
                                        <?= $package['km'];?> ,
                                        <?= $package['hours'];?> (<?= $package['fee'];?>)
                                    </option>
                                <?php endforeach;?>

                            </select>
                        </div>
                    </div>
                </div>

                <div class="panel panel-success" style="margin-top:2%">
                    <div class="panel-heading">
                        <h3 class="panel-title">Booking Requirements</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" id="unmarked" <?php if($isUnmarked === true)echo 'checked';?> >Unmarked</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" id="tinted"   <?php if($isTinted === true)echo 'checked';?>    >Tinted</label>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" id="vip"  <?php if($isVip === true)echo 'checked';?>         >VIP</label>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" id="vih"  <?php if($isVih === true)echo 'checked';?>    >Very Important Hire<small style="font-weight: lighter"> [Court Case/Interview/Appointment]</small></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" id="cusNumberNotSent" <?php if($isCusNumberNotSent === true)echo 'checked';?>>Don't Send Customer Number</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group" style="text-align: center">
                    <button type="button" style="width:100%" class="btn btn-success" onclick="operations('updateBooking','<?= $_id?>');return false">Update Booking</button>
                </div>
            </div>
        </form>

    </div>
</div>






