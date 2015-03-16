<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">New Order</h3>
    </div>
    <div class="panel-body" >
        <form id="newBookingForm" >
            <div class="col-lg-5">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Location Details</h3>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label">Number</label>
                            <input class="form-control" type="text"  id="no"      name="no"      placeholder="Number" >
                        </div>
                        <div class="form-group">
                            <label>Road</label>
                            <input type="text" class="form-control" id="road"     name="road"     placeholder="Road" >
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control" id="city"     name="city"     placeholder="City">
                        </div>
                        <div class="form-group">
                            <label>Town</label>
                            <input type="text" class="form-control" id="town"     name="town"     placeholder="Town">
                        </div>
                        <div class="form-group">
                            <label>Land Mark</label>
                            <input type="text" class="form-control" id="landMark" name="landMark" placeholder="Land Mark">
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
                            <input type="text" class="form-control" id="remark"       name="remark"    placeholder="Remark">
                        </div>
                        <div class="form-group">
                            <label>Dispatch Before<small style="font-weight: lighter"> [In Minutes]</small></label>
                            <input type="text" class="form-control" id="dispatchB4"   name="dispatchBefore"   value="30" placeholder="Dispatch Before">
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label style="font-weight: bold">
                                    <input type="checkbox" name="callUp"  id="callUp" class="checkBoxMakeAppear"> Call Up Given
                                </label>
                                <input type="text" class="form-control checkBoxElementAppearing" id="callUpPrice" name="callUpPrice" placeholder="Call Up Price" style="display:none">
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label style="font-weight: bold"><input type="checkbox" name="destinationGiven"  id="destinationGiven" class="checkBoxMakeAppear"> Destination
                                </label>
                                <input type="text" class="form-control checkBoxElementAppearing" id="destination" name="destination" placeholder="Given Destination" style="display:none">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label style="font-weight: bold"><input type="checkbox" name="pagingBoardName"  id="pagingBoardName" class="checkBoxMakeAppear"> Paging Board
                                </label>
                                <input type="text" class="form-control checkBoxElementAppearing" id="pagingBoard" name="pagingBoard" placeholder="Paging Board Name" style="display:none">
                            </div>
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
                        <?php if(isset($userInfo) && sizeof($userInfo) !=0 ):?>
                        <div class="form-group">
                            <select class="form-control" id="personalProfileTp">
                                <option value="-">Select a Personal Profile</option>
                                <?php foreach($userInfo as $item):?>
                                    <?php if($item['tp'] != '-') echo "<option value='". $item['tp'] ."'>". $item['tp'] . "</option>";
                                        elseif($item['tp2'] != '-')echo "<option value='". $item['tp2'] ."'>". $item['tp2'] . "</option>";?>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <?php endif;?>

                        <div class="form-group">
                            <label class="control-label" style="font-weight:bold">Vehicle Type</label></br>
                            <div class="btn-group">
                                <button type="button" id="carRadio"  data-set="vehicle" value="car" class="btn btn-default customRadio">Car</button>
                                <button type="button" id="vanRadio"  data-set="vehicle" value="van" class="btn btn-default customRadio">Van</button>
                                <button type="button" id="nanoRadio"   data-set="vehicle" value="nano" class="btn btn-default customRadio">Nano</button>
                            </div>
                            <input style="display: none" class="customRadio" name="vehicleType" id="vehicleType">

                        </div>

                        <div class="form-group">
                            <label class="control-label" style="font-weight:bold">Payment Type</label></br>
                            <div class="btn-group">
                                <button type="button" data-set="payment" value="cash" class="btn btn-default customRadio">Cash</button>
                                <button type="button" data-set="payment" value="credit" class="btn btn-default customRadio">Credit Card</button>
                            </div>
                            <input style="display: none" class="customRadio" name="paymentType" id="paymentType">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Booking Time</label>
                            <div id="form_time" class="input-group date" data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">
                                <input id="bTime" name="bTime" class="form-control" name= size="16" type="text" value="" readonly="readonly">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-time" onclick="showCalender()"></span></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Booking Date</label>
                            <div id="form_date" class="input-group date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                <input id="bDate" name="bDate" class="form-control" size="16" type="text" value="" readonly="readonly">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" onclick="showCalender()"></span></span>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="checkbox">
                                <label style="font-weight: bold">
                                    <input type="checkbox" name="airportTick"  id="airportTick" class="checkBoxMakeAppear"> Air Port Package
                                </label>

                                <select id="airportPackage" onchange="fillAirportPackageinBookings()" class="form-inline checkBoxElementAppearing" style="display:none">
                                    <option value="-" selected>Package Name</option>
                                    <?php foreach($airportPackages['data'] as $package):?>
                                        <option value="<?= $package['packageId']?>" ><?= $package['packageName']?></option>
                                    <?php endforeach;?>
                                </select>

                                <select id="airportPackageType" onchange="selectAirportPackageandAddRemark()" class="form-inline checkBoxElementAppearing" style="display:none">
                                    <option value="-" disabled selected>Package Type</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label style="font-weight: bold">
                                    <input type="checkbox" name="dayPackageTick"  id="dayPackageTick" class="checkBoxMakeAppear"> Day Packages
                                </label>

                                <select id="dayPackage" onchange="selectDayPackageandAddRemark()" class="form-inline checkBoxElementAppearing" style="display:none">
                                    <option value="-" selected>Select Day Package</option>
                                    <?php foreach($dayPackages['data'] as $package):?>
                                        <option value="<?= $package['packageId']?>" >
                                            <?= $package['km'];?> ,
                                            <?= $package['hours'];?> (<?= $package['fee'];?>)
                                        </option>
                                    <?php endforeach;?>
                                </select>

                            </div>
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
                                <label><input type="checkbox" id="unmarked" >Unmarked</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" id="tinted"       >Tinted</label>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" id="vip"          >VIP</label>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" id="vih">Very Important Hire<small style="font-weight: lighter"> [Court Case/Interview/Appointment]</small></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" id="cusNumberNotSent">Don't Send Customer Number</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group" style="text-align: center">
                    <button type="button" style="width:100%" class="btn btn-success" onclick="operations('validateBooking');return false;">Save Booking</button>
                </div>
            </div>
        </form>
    </div>
</div>







