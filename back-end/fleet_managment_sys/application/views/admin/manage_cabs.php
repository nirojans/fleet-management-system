<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-------------------------------- CSS Files------------------------------------>
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/bootstrap.css">
    <!-------------------------------- JS Files------------------------------------>
    <script type="text/javascript" src="<?= base_url();?>assets/js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/admin_panel/admin_cab_operations.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/admin_panel/admin_driver_operations.js"></script>

    <script>

        var docs_per_page= 100;
        var page = 1;
        var obj = null;        
        var url = '<?php echo site_url(); ?>';

    </script>
</head>
<body>

<div id="navBarField">
    <nav class="navbar navbar-default" role="navigation" style="margin-bottom: 0px">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Hao Cabs Admin Panel</a>
        </div>

        <ul class="nav navbar-nav">
            <li class="active"><a href="#" onclick="getAllCabs(docs_per_page , page ,  '<?php echo site_url();?>')">Cabs</a></li>
<!--            <li><a href="#" id="driver" onclick="getDriversView(this.id)">Drivers</a></li>-->
            <li><a href="#" id="driver" onclick="getCROsView(this.id)">Drivers</a></li>
<!--            <li><a href="#" id="dispatcher" onclick="getDispatchersView(this.id)">Dispatcher</a></li>-->
            <li><a href="#" id="dispatcher" onclick="getCROsView(this.id)">Dispatcher</a></li>
            <li><a href="#" id="cro" onclick="getCROsView(this.id)">CRO</a></li>
            <li><a href="#" id="reports" onclick="getReportsView(this.id)">Reports</a></li>
            <li><a href="#" id="packages" onclick="getPackagesView(this.id)">Packages</a></li>
        </ul>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <form class="navbar-form navbar-left" role="search" id="getCab">
                <div class="form-group">
                    <input class="form-control" placeholder="Cab ID" type="text" id="cabIdSearch">
                </div>
                <button type="submit" class="btn btn-default" onclick="getCabView(url);return false;">Submit</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?= site_url('login/logout')?>">Log Out</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</div>

<div class="container-fluid">
    <div class="row">


        <div class="col-lg-12" style="margin-top: 10px">
            <div class="panel panel-default">
                    <div class="panel-heading" style="margin-top: 10px; border-left: 1px solid #a6a6a6" >
                        <h3 class="panel-title" id="panel_title">Info</h3>
                    </div>
                    <div class="panel-body" id="information">

                    <div class="col-lg-2" id="operation" style="margin-top: 10px">
                        <h5><a href="#" onclick="getNewCabView(url)">New Cab</a></h5></br>
                        <h5><a href="#" onclick="getAllCabs(docs_per_page , page, url)">View All Cabs</a></h5>
                    </div>

                    <div class="col-lg-10" id="dataFiled" style="margin-top: 10px; border-left: 1px solid #a6a6a6;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Driver javascript-->
<script>

</script>

<!-- Dispatcher javascript-->
<script>
    
</script>

<!-- User javascript-->
<script>
    function getCROsView(id){
        var data = {'user_type': id};//alert(id);
        /* Get the nav bar for cro management view */
        var url = '<?php echo site_url("user_controller/getUserNavBarView") ?>';
        var result = ajaxPost(data,url);
        /* Append the values for the div tag field */
        var div = document.getElementById('navBarField');//alert("CRO NavBar ok");
        div.innerHTML = result.view.table_content;

        url = '<?php echo site_url("user_controller/getSidePanelView") ?>';
        result = ajaxPost(data,url);//alert("CRO SideBar ok");

        div = document.getElementById('operation');
        div.innerHTML =  result.view.table_content;

        getAllCROsView(id);
    }

    function getCRO(){//alert("in getCRO");

        var userId = document.getElementById("userIdSearch").value;
        /* Create a JSON object from the form values */
        var user = { 'userId' : parseInt(userId) };
        var url = '<?php echo site_url("user_controller/getUser") ?>';
        var result = ajaxPost(user,url);

    }

    function deleteCRO(userId,userType){
        // Confirm Msg Box
        var user = { 'userId' : parseInt(userId) , 'user_type' : userType};
        var url = '<?php echo site_url("user_controller/deleteUser") ?>';
        var result = ajaxPost(user,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = "";

    }

    function getCROView(id){//alert("in getCROView");

        var userId = document.getElementById("userIdSearch").value;
        /* Create a JSON object from the form values */
        var user = { 'userId' : parseInt(userId), 'user_type': id };
        var url = '<?php echo site_url("user_controller/getUserSearchView") ?>';
        var result = ajaxPost(user,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.table_content;

    }

    function makeCROFormEditable(userId , url, user_type){//alert("in makeCROFormEditable "+user_type);

        var data = {'userId' : parseInt(userId), 'user_type' : user_type };
        url =url + "/user_controller/getUserEditView";
        var result = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = eval("result.view."+user_type+"_edit_view");//result.view.type_edit_view;
    }

    function updateCRO(id){//alert("in updateCRO");

        var userId = document.getElementById("userId").value;
        var name = document.getElementById("name").value;
        var uName = document.getElementById("uName").value;
        var pass = document.getElementById("pass").value;
        var nic = document.getElementById("nic").value;
        var tp = document.getElementById("tp").value;
        var blocked = document.getElementById("blocked").value;
        var cabId = "";
        var logout = false;
        var callingNumber = "-1";
        var logSheetNumber = "-1";
        var startLocation = "";
        if(id.toString() === "driver" )
        {
            cabId = document.getElementById("cabId").value;
            logout = document.getElementById("logout").value;
            if(logout == "true"){
                logout = true;
            }else{
                logout= false;
            }
            callingNumber = document.getElementById("callingNumber").value;
            logSheetNumber = document.getElementById("logSheetNumber").value;
            startLocation = document.getElementById("startLocation").value;
            //json object for 'user_type' 'driver'....when driver edited, 'logout' alwys set to false
            var user =  {'userId': parseInt(userId) , 'details' : {'name' : name , 'uName' : uName , 'pass' : pass , 'nic' : nic ,'tp' : tp, 'cabId' : cabId, 'logout': logout , 'blocked':blocked , 'callingNumber':callingNumber , 'logSheetNumber':logSheetNumber, 'startLocation':startLocation }};
        }
        //jason object when for 'user_type's 'cro', and 'dispatcher'
        else{var user =  {'userId': parseInt(userId) , 'details' : {'name' : name , 'uName' : uName , 'pass' : pass , 'nic' : nic ,'tp' : tp , 'blocked':blocked}};}
        //else{var user =  {'userId': parseInt(userId) , 'details' : {'name' : name , 'uName' : uName , 'pass' : pass , 'nic' : nic ,'tp' : tp, 'cabId' : cabId}};}

        var url = '<?php echo site_url("user_controller/updateUser") ?>';
        ajaxPost(user,url);
        getAllCROsView(id);
    }

    function getNewCROView(id){//alert("in getNewCROView");

        var data = {'user_type' : id};
        var url = '<?php echo site_url("user_controller/getNewFormUserView") ?>';
        var result = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.table_content;
    }

    function createNewCRO(id){//alert("in createNewCRO");
        var name = document.getElementById("name").value;
        var uName = document.getElementById("uName").value;
        var pass = document.getElementById("pass").value;
        var nic = document.getElementById("nic").value;
        var tp = document.getElementById("tp").value;
        var user_type = id;
        var cabId = "";

        if(name == "" ){return false;}
        if(uName == "" ){return false;}
        if(pass == "" ){return false;}
        if(nic == "" ){return false;}
        if(tp == "" ){return false;}

        if(id.toString() === "driver" )
        {
            cabId = document.getElementById("cabId").value;
            //json object for 'user_type' 'driver'
            var user = {'name' : name , 'uName' : uName , 'pass' : pass , 'nic' : nic ,'tp' : tp, 'user_type' : user_type, 'cabId' : cabId, 'logout':false , 'blocked':'false' ,'lastLogout': '0' , 'callingNumber':'-1' , 'logSheetNumber':'-1', 'startLocation':'', 'isLogout':true};
        }
        //jason object when for 'user_type's 'cro', and 'dispatcher'
        else{var user = {'name' : name , 'uName' : uName , 'pass' : pass , 'nic' : nic ,'tp' : tp, 'user_type' : user_type  , 'blocked':'false' };}
        //else{var user = {'name' : name , 'uName' : uName , 'pass' : pass , 'nic' : nic ,'tp' : tp, 'user_type' : user_type, 'cabId' : cabId };}
        var url = '<?php echo site_url("user_controller/createUser") ?>';
       //alert(JSON.stringify(user));
        ajaxPost(user,url);
        getAllCROsView(id);
    }

    /* Gets all available cabs and show in the 'dataFiled' div tag */
    function getAllCROsView(id){//alert("in getAllCROsView");
        var skip = docs_per_page * (page-1);//alert("the id val in getALLCROView is : "+id);
        var data = {"skip" : skip , "limit" : docs_per_page, "user_type" : id};
        var url = '<?php echo site_url("user_controller/getAllUsersView") ?>';
        var view = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = "";
        div.innerHTML = view.view.table_content;

    }
</script>

<!-- Reports javascript-->
<script>
    
    function getReportViewFromSearchId(){
        
        var search_Id = document.getElementById("search_select").value;
        var search;
        
        if(search_Id === "driverId")
        {
            url ='<?php echo site_url("/complaint_controller/get_all_complaints_by_driver") ?>';
            var driverId = document.getElementById("idForSearch").value;//alert(driverId);
            /* Create a JSON object from the form values */
            search = { 'userId_driver' : driverId };
            //set_place_holder("Driver ID");
            //place_holder_of_report_navBar = "Driver ID";
        }
        else if(search_Id === "refId")
        {
            url ='<?php echo site_url("/complaint_controller/get_complaint_by_refId") ?>';
            var refId = document.getElementById("idForSearch").value;//alert(driverId);
            /* Create a JSON object from the form values */
            search = { 'refId' : refId };
            //set_place_holder("Booking Ref ID");
            //place_holder_of_report_navBar = "Booking Ref ID";
        }
        
        else if(search_Id === "complaintId")
        {
            url ='<?php echo site_url("/complaint_controller/get_complaint_by_complaintId") ?>';
            var complaintId = document.getElementById("idForSearch").value;
            /* Create a JSON object from the form values */
            search = { 'complaintId' : complaintId };
            //set_place_holder("Complaint Ref ID");
            //place_holder_of_report_navBar = "Complaint Ref ID";            
        }
        
        else
        {
            alert("Error in Selection!");
        }

        
        var result = ajaxPost(search,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = "";
        div.innerHTML = result.view.table_content;

    }
    
    function set_place_holder(value)
    {
        alert("hello");place_holder = "Enter ID";
        var place_holder = document.getElementById("search_box_for_reports");
        place_holder.innerrHTML = "<input class=\"form-control\" placeholder=\""+ place_holder +"\" type=\"text\" id=\"idForSearch\">";
    }
    
    function get_complaint_report_view_from_refId(){

        url ='<?php echo site_url("/accounts_controller/getAccountsViewByDriverId") ?>';
        var driverId = document.getElementById("driverIdSearch").value;
        /* Create a JSON object from the form values */
        var driver = { 'driverId' : driverId };
        var result = ajaxPost(driver,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.table_content;

    }

    function getPackagesViewByPackageId(){

        url ='<?php echo site_url("packages_controller/getPackagesViewByPackageId") ?>';
        var packageId = document.getElementById("packageIdSearch").value;
        var packaged = { 'packageId' : packageId  };
        var result = ajaxPost(packaged,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.table_content;

    }

    function makePackagesFormEditable(packageId ){//alert("in makeCROFormEditable "+user_type);

        var data = {'packageId' : packageId };
        var url = '<?php echo site_url("packages_controller/getPackageEditView") ?>';
        var result = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.packages_edit_view;//result.view.type_edit_view;
    }

    function deletePackage(packageId){
        // Confirm Msg Box
        var data = {'packageId' : packageId };
        var url = '<?php echo site_url("packages_controller/deletePackage") ?>';
        var result = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = "";

    }    
    
    function getReportsView(){
            var url = '<?php echo site_url("complaint_controller/getReportsNavBarView") ?>';            
            var result = ajaxPost(null,url);//alert("before call");
            /* Append the values for the div tag field */
            var div = document.getElementById('navBarField');//alert("CRO NavBar ok");
            div.innerHTML = "";
            div.innerHTML = result.view.table_content;//alert("ok");

            
            url = '<?php echo site_url("complaint_controller/getSidePanelView") ?>';
            result = ajaxPost(null,url);//alert("CRO SideBar ok");
            div = document.getElementById('operation');
            div.innerHTML =  result.view.table_content;
            
            //can use the line commented below to change the panel heading, but will have to use this in all views
            //document.getElementById('panel_title').innerHTML = "Complaint Reports"
            
            
            url ='<?php echo site_url("complaint_controller/get_all_complaints") ?>'//url + "/accounts_controller/getAllAccountsView";
            var skip = docs_per_page * (page-1);
            var data = {"skip" : skip , "limit" : docs_per_page};
            
            var view = ajaxPost(null,url);
            var div = document.getElementById('dataFiled');
            div.innerHTML = "";
            div.innerHTML = view.view.table_content;//alert("ok2");


    }

    function getNewPackageView(url){

        var data = {};
        url ='<?php echo site_url("/packages_controller/getNewPackageView"); ?>';
        var result = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.new_package_view;

    }

    function createNewPackage(){
        var packageName = document.getElementById("packageName").value;
        //alert("aawa");
        if (document.getElementById('airport').checked) {
            var feeType = 'airport';

        }else if(document.getElementById('day').checked){
            var feeType = 'day';
        }
        var info = document.getElementById("info").value;
        if(feeType == 'airport'){
            var dropFee = document.getElementById("dropFee").value;
            var bothwayFee = document.getElementById("bothwayFee").value;
            var guestCarrierFee = document.getElementById("guestCarrierFee").value;
            var outsideFee = document.getElementById("outsideFee").value;
            var packaged = {'packageId':'','packageName' : packageName , 'feeType' : feeType ,'dropFee' :dropFee , 'bothwayFee' : bothwayFee , 'guestCarrierFee' : guestCarrierFee , 'outsideFee' :outsideFee , 'info' : info };
        }else{
            var km = document.getElementById("km").value;
            var hours = document.getElementById("hours").value;
            var fee = document.getElementById("fee").value;
            //alert(feeType);
            var packaged = {'packageId':'','packageName' : packageName , 'feeType' : feeType , 'km' :km , 'hours' : hours , 'fee' :fee , 'info' : info };
        }
        var url =  '<?php echo site_url("packages_controller/createPackage"); ?>';
        //alert(JSON.stringify(packaged));
        ajaxPost(packaged,url);
        getPackagesView();
    }

    function getPackagesView(){

        var url = '<?php echo site_url("packages_controller/getPackagesNavBarView") ?>';
        var result = ajaxPost(null,url);//alert("before call");
        /* Append the values for the div tag field */
        var div = document.getElementById('navBarField');//alert("CRO NavBar ok");
        div.innerHTML = "";
        div.innerHTML = result.view.table_content;//alert("ok");

        url = '<?php echo site_url("packages_controller/getSidePanelView") ?>';
        result = ajaxPost(null,url);//alert("CRO SideBar ok");
        div = document.getElementById('operation');
        div.innerHTML =  result.view.table_content;
        url ='<?php echo site_url("packages_controller/getAllPackagesView") ?>'//url + "/accounts_controller/getAllAccountsView";
        var skip = docs_per_page * (page-1);
        var data = {"skip" : skip , "limit" : docs_per_page};
        var view = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = "";
        div.innerHTML = view.view.table_content;
    }


    
    function updateReports(id,bookingChargeId){

        var bookingCharge = document.getElementById(bookingChargeId).value;//console.log(bookingCharge);
        var refId = document.getElementById(id).innerHTML;
        var account = {'refId': refId , 'bookingCharge' : bookingCharge};
        //var url = '<?php //echo site_url("accounts_controller/updateFee") ?>';
        //ajaxPost(account,url);
        document.getElementById("amount_percentage_of_"+id).innerHTML = Math.floor(((bookingCharge/100)*17));//parseInt(bookingCharge)
        //console.log(Math.floor(((bookingCharge/17)*100)));
        //getAccountsView();
    }

    function updatePackage(packageId) {
        var packageId = document.getElementById("packageId").value;
        var packageName = document.getElementById("packageName").value;
        var feeType = document.getElementById("feeType").value;
        var info = document.getElementById("info").value;
        if(feeType === 'airport'){

            var dropFee = document.getElementById("dropFee").value;
            var bothwayFee = document.getElementById("bothwayFee").value;
            var guestCarrierFee = document.getElementById("guestCarrierFee").value;
            var outsideFee = document.getElementById("outsideFee").value;
            var packaged = {'packageId':packageId,'packageName' : packageName , 'feeType' : feeType ,'name':name , 'dropFee' :dropFee , 'bothwayFee' : bothwayFee , 'guestCarrierFee' : guestCarrierFee , 'outsideFee' :outsideFee , 'info' : info };

        }else{
            var km = document.getElementById("km").value;
            var hours = document.getElementById("hours").value;
            var fee = document.getElementById("fee").value;
            var packaged = {'packageId':packageId,'packageName' : packageName , 'feeType' : feeType , 'km' :km , 'hours' : hours , 'fee' :fee , 'info' : info };
        }
        var url = '<?php echo site_url("packages_controller/updatePackage") ?>';
        ajaxPost(packaged, url);
        getPackagesView();
    }

    function getBookingsByDateRange(id){
        var startDate = document.getElementById("startDate").value;
        var endDate = document.getElementById("endDate").value;
        var userId = document.getElementById("driverId").value;
        var cabId = document.getElementById("cabId").value;

        var dates = {'startDate':startDate,'endDate': endDate,'userId':userId,'cabId':cabId};
        var url = '<?php echo site_url("accounts_controller/getBookingsByDateRange") ?>';

        var result = ajaxPost(dates,url);
        var div = document.getElementById('tableDiv');
        div.innerHTML = result.view.table_content;
    }

    function getHireSummaryByDate(id){
        var date = document.getElementById("date").value;
        var dates = {'date':date};
        var url = '<?php echo site_url("accounts_controller/getCallingNumberSummaryView") ?>';
        var result = ajaxPost(dates,url);
        var div = document.getElementById('tableDiv');
        div.innerHTML = result.view.table_content;
    }

    function getWorkingHoursByDate(id){
        var startDate = document.getElementById("startDate").value;
        var endDate = document.getElementById("endDate").value;
        var userId = document.getElementById("driverId").value;

        var dates = {'startDate':startDate,'endDate': endDate};
        var url = '<?php echo site_url("accounts_controller/getWorkingHoursByDate") ?>';

        var result = ajaxPost(dates,url);
        var div = document.getElementById('tableDiv');
        div.innerHTML = result.view.table_content;
    }

    function getWorkingHoursByDate(id){
        var startDate = document.getElementById("startDate").value;
        var endDate = document.getElementById("endDate").value;

        var dates = {'startDate':startDate,'endDate': endDate};
        var url = '<?php echo site_url("accounts_controller/getWorkingHoursByDate") ?>';

        var result = ajaxPost(dates,url);
        var div = document.getElementById('tableDiv');
        div.innerHTML = result.view.table_content;
    }

    function getDetailedWorkingHoursByDate(id){
        var startDate = document.getElementById("startDate").value;
        var endDate = document.getElementById("endDate").value;
        var userId = id;

        var dates = {'startDate':startDate,'endDate': endDate,'userId': userId};
        var url = '<?php echo site_url("accounts_controller/getDetailedWorkingHoursByDate") ?>';

        var result = ajaxPost(dates,url);
        var div = document.getElementById('tableDiv');
        div.innerHTML = result.view.table_content;
    }

    function getSummaryView(){
        var url = '<?php echo site_url("accounts_controller/getSummaryView") ?>';
        var result = ajaxPost(null,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.table_content;

    }

    function getHireSummaryView(){
        var url = '<?php echo site_url("accounts_controller/getHireSummaryView") ?>';
        var result = ajaxPost(null,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.table_content;

    }

    function getWorkingHoursView(){
        var url = '<?php echo site_url("accounts_controller/getWorkingHoursView") ?>';
        var result = ajaxPost(null,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.table_content;

    }
    
    //Functions for Cancel Reports
    function getCancelReportsView(type)
    {
        type = typeof type !== 'undefined' ? type : "ALL";//alert(type);
        var date_needed_cr = 'today';
        if(document.contains(document.getElementById('date_needed_cr'))){date_needed_cr = document.getElementById('date_needed_cr').value;}        
        input_data = {'type' : type, 'date_needed' : date_needed_cr};
        //create jason object with 'type' and 'date'. get date as an input
        var url ='<?php echo site_url("complaint_controller/get_all_cancel_reports") ?>';//url + "/accounts_controller/getAllAccountsView";
        var view = ajaxPost(input_data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = "";
        div.innerHTML = view.view.table_content;//alert("ok2");
    }
    
    //Funcions for Missed call report
    
    function getMissedCallReportView()
    {
        var url = '<?php echo site_url("complaint_controller/get_missed_calls_today")?>';
        var view = ajaxPost(null,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = "";
        div.innerHTML = view.view.table_content;        
    }
    function getAllMissedCallReportView()
    {
        var url = '<?php echo site_url("complaint_controller/get_all_missed_calls")?>';
        var view = ajaxPost(null,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = "";
        div.innerHTML = view.view.table_content;        
    }
    function getMissedCallReportViewByDate()
    {
        var date = document.getElementById("date_needed").value;//alert("vv"+date+"nnn");
        var date_needed_mc = {'date': date};
        var url = '<?php echo site_url("complaint_controller/get_all_missed_calls_by_date")?>';
        var view = ajaxPost(date_needed_mc,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = "";
        div.innerHTML = view.view.table_content;        
    }
    
</script>

<script>
    function createNewAddress(){
        var addressName =document.getElementById('addressName').value;
        var addressTown =document.getElementById('town').value;
        var addressCity =document.getElementById('city').value;
        var addressRoad =document.getElementById('road').value;
        var address = {'addressId':'','addressName' : addressName , 'city' : addressCity ,'town' :addressTown , 'road' : addressRoad };
        var url =  '<?php echo site_url("packages_controller/createAddress"); ?>';
        ajaxPost(address,url);
        getAddressView();

    }

    function makeAddressFormEditable(addressId ){//alert("in makeCROFormEditable "+user_type);

        var data = {'addressId' : addressId };
        var url = '<?php echo site_url("packages_controller/getAddressEditView") ?>';
        var result = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.address_edit_view;//result.view.type_edit_view;
    }

    function getAddressView(){
        url ='<?php echo site_url("packages_controller/getAllAddressView") ?>'//url + "/accounts_controller/getAllAccountsView";
        var skip = docs_per_page * (page-1);
        var data = {"skip" : skip , "limit" : docs_per_page};
        var view = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = "";
        div.innerHTML = view.view.table_content;
    }

    function getNewAddressView(url){

        var data = {};
        url ='<?php echo site_url("/packages_controller/getNewAddressView"); ?>';
        var result = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.new_address_view;

    }

    function updateAddress(addressId) {
        var addressId = document.getElementById("addressId").value;
        var addressName = document.getElementById("addressName").value;
        var addressTown =document.getElementById('town').value;
        var addressCity =document.getElementById('city').value;
        var addressRoad =document.getElementById('road').value;
        var address = {'addressId':addressId,'addressName' : addressName , 'city' : addressCity ,'town' :addressTown , 'road' : addressRoad };
        var url =  '<?php echo site_url("packages_controller/updateAddress"); ?>';
        ajaxPost(address,url);
        getAddressView();
    }

    function deleteAddress(addressId){
        // Confirm Msg Box
        var data = {'addressId' : addressId };
        var url = '<?php echo site_url("packages_controller/deleteAddress") ?>';
        var result = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = "";
        getAddressView();
    }

</script>

<script>
    function validate(plateNo , model , vType , color , info ){
        var status = false;
        if(model == ""){
            alert("model filed is required");
            return status;
        }
        if(plateNo == ""){
            alert("plate number is required");
            return status;
        }
        if(vType == ""){
            alert("Vehicle type is required");
            return status;
        }
        return true;
    }
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