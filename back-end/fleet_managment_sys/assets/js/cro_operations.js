$(document).ready(function(){
    uiInit();
});

function addInquireCall(url , objId){

    var data = {'objId' : objId};
    url = url +"/customer_retriever/addInquireCall";
    var view = ajaxPost(data,url);

}


var initAdminAuthenticateModalUi = function() {
    $("input#pwd").keyup(function (event) {
        if (event.keyCode == 13) {
            autherizeAdmin();
            return false;

            //$(this).siblings("button").click();
        }
    });
};

function autherizeAdmin(){
    $('#modalPass').modal('hide');
    var relevantData =$('#modalPass').children("span#metaRelevantData").text();
    var finalOperation = $('#modalPass').children("span#metaFinalOperation").text();
    var pass = $('input#pwd').val();
    $('input#pwd').val('');
    var siteUrl = url;
    var data={'pass' : pass};
    if ( pass != undefined) {
        var authnticateUrl = siteUrl + "/login/isAdmin";
        var result = ajaxPost(data, authnticateUrl, false);
        if (result.statusMsg == 'true') {
            operations(finalOperation,relevantData);
        }
        else{
            alert('Admin Password Entered is Invalid. Please contact DevTeam');
        }
    }else{
        alert('Password Not entered!!!');
    }


}

function getEditBookingView(url , bookingObjId){

    var siteUrl = url;
    var data = {'objId' : bookingObjId};
    url = siteUrl +"/cro_controller/getEditBookingView";
    var view = ajaxPost(data,url);
    /*  Populate the New Booking field with the editing form */
    $('#newBooking').html(view.view.edit_booking_view);
    uiInit();
    /* The ui bug with only can select the vehicle type */
    var index = -1;
    for(var i=0 ; i < bookingObj.length ; i++){
        index++;
        if( bookingObj[i]['_id']['$id'] === bookingObjId){
            break;
        }
    }

    var payType = bookingObj[index]['payType'];
    var vType = bookingObj[index]['vType'];

    if(vType == 'car'){
        $('#carRadio').addClass(' active');
        $('#vehicleType').val('car');
    }
    if(vType == 'van'){
        $('#vanRadio').addClass(' active');
        $('#vehicleType').val('van');
    }
    if(vType == 'nano'){
        $('#nanoRadio').addClass(' active');
        $('#vehicleType').val('nano');
    }

    if(payType == 'cash') {
        $('#payTypeCash').addClass(' active');
        $('#paymentType').val('cash');
    }

    if(payType == 'credit'){
        $('#payTypeCredit').addClass(' active');
        $('#paymentType').val('credit');
    }

    var packageType = bookingObj[index]['packageType'];



    if(packageType  == "day"){

    }
}

function getCancelConfirmationView( url ,  bookingObjId ){

    var siteUrl = url;
    var data = {'_id' : bookingObjId };
    url = siteUrl + "/cro_controller/getCancelConfirmationView";
    var view = ajaxPost(data,url);
    /*  Populate the job information view with cancel confirmation view*/
    $('#bookingStatus').html(view.view.cancel_confirmation_view);

}

function confirmCancel(url , tp , bookingObjId ){
    var siteUrl = url;
    url = siteUrl +"/customer_retriever/canceled";

    var sendSms = "true";
    if(document.getElementById('sendSms').checked) {
        sendSms='false';
    }

    var cancelReason =$('input[name=cancelReason]:checked').val();
    var data = {
        '_id' : bookingObjId ,
        'cancelReason' : cancelReason,
        'tp' : tp ,
        'sendSms' : sendSms
    };
    ajaxPost(data,url);
    getCustomerInfoView(siteUrl , tp);
}

function validateBooking(url , tp){
    var no          = $('#no').val();
    var road        = $('#road').val();
    var city        = $('#city').val();
    var town        = $('#town').val();
    var landMark    = $('#landMark').val();
    var remark      = $('#remark').val();
    var callUpPrice = $('#callUpPrice').val();
    var dispatchB4  = $('#dispatchB4').val();
    var destination = $('#destination').val();
    var pagingBoard = $('#pagingBoard').val();
    var bDate      = $('#bDate').val();
    var bTime      = $('#bTime').val();
    var vType               = $('#vehicleType').val();
    var payType             = $('#paymentType').val();
    var isUnmarked          = $('#unmarked')[0].checked;
    var isTinted            = $('#tinted')[0].checked;
    var isVip               = $('#vip')[0].checked;
    var isVih               = $('#vih')[0].checked;
    var isCusNumberNotSent  = $('#cusNumberNotSent')[0].checked;
    var bookingCharge = '-';
    var bookingType = customerObj.profileType;
    var personalProfileTp = '-';
    var cancelReason = '-';
    var airportPackageId = $('#airportPackage').val();
    var airportPackageType = $('#airportPackageType').val();
    var dayPackageId = $('#dayPackage').val();
    var packageId = '-';
    var packageType = '-';

    if($('#personalProfileTp').length != 0){
        bookingType = 'Cooperate';
        personalProfileTp = $('#personalProfileTp').val();
    }

    if (no == ''){no = '-'}
    if (landMark== ''){landMark= '-'}
    if (remark== ''){remark= '-'}
    if (callUpPrice== ''){callUpPrice= 0}
    if (dispatchB4== ''){dispatchB4= 30}
    if (destination== ''){destination= '-'}
    if (pagingBoard== ''){pagingBoard= '-'}

    /* Form Validations */
    if(road == ''){
        alert('Road number is compulsory');
        return false;
    }
    if( town == ''){
        alert('Town is compulsory');
        return false;
    }
    if(city == ''){
        alert('City is compulsory');
        return false;
    }
    if(vType == ''){
        alert('Vehicle Type is Compulsory');
        return false;
    }
    if(bTime == '' || bDate ==  ''){
        alert('Booking Date and Time are Compulsory');
        return false;
    }
    if(payType ==  ''){
        alert('Payment method is Compulsory');
        return false;
    }
    if(airportPackageId != '-'){
        if( airportPackageType != '-'){
            packageId = airportPackageId;
            packageType = airportPackageType;
        }else{
            alert('Select a Airport Package Type');
        }
    }
    if(dayPackageId != '-'){
        packageId = dayPackageId;
        packageType = 'day';
    }

    if(airportPackageId != '-' && dayPackageId != '-' ){
        alert("Select only one package Type [Airport / Day package]");
        return;
    }
    //TODO : Call to load dispatcher modal conformation
    //$("#orderBuilder").load('dispatcher/newOrder/' + orderId);



    var specifications = "";
    if(isVip)
        specifications =specifications + ' VIP |';
    if(isVih)
        specifications =specifications + ' VIH |';
    if(isUnmarked)
        specifications =specifications + ' UNMARK |';
    if(isTinted)
        specifications =specifications + ' TINTED |';
    if(specifications !== "")
        specifications ='| ' + specifications;


    $('span#no.modalConfirm').text(no);
    $('span#road.modalConfirm').text(road);
    $('span#city.modalConfirm').text(city);
    $('span#town.modalConfirm').text(town);
    $('span#landMark.modalConfirm').text(landMark);
    $('span#remark.modalConfirm').text(remark);
    $('span#callUpPrice.modalConfirm').text(callUpPrice);
    $('span#dispatchB4.modalConfirm').text(dispatchB4);
    $('span#destination.modalConfirm').text(destination);
    $('span#pagingBoard.modalConfirm').text(pagingBoard);
    $('span#bDate.modalConfirm').text(bDate);
    $('span#bTime.modalConfirm').text(bTime);
    $('span#vehicleType.modalConfirm').text(vType);
    $('span#vehicleType.paymentType').text(payType);
    $('span#requirements.modalConfirm').text(specifications);

    return true;

}

function createBooking(url , tp){
    var siteUrl = url;
    url = siteUrl + "/customer_retriever/addBooking";

    var no          = $('#no').val();
    var road        = $('#road').val();
    var city        = $('#city').val();
    var town        = $('#town').val();
    var landMark    = $('#landMark').val();
    var remark      = $('#remark').val();
    var callUpPrice = $('#callUpPrice').val();
    var dispatchB4  = $('#dispatchB4').val();
    var destination = $('#destination').val();
    var pagingBoard = $('#pagingBoard').val();
    var bDate       = $('#bDate').val();
    var bTime       = $('#bTime').val();
    var vType               = $('#vehicleType').val();
    var payType             = $('#paymentType').val();
    var isUnmarked          = $('#unmarked')[0].checked;
    var isTinted            = $('#tinted')[0].checked;
    var isVip               = $('#vip')[0].checked;
    var isVih               = $('#vih')[0].checked;
    var isCusNumberNotSent  = $('#cusNumberNotSent')[0].checked;
    var bookingCharge = '-';
    var bookingType = customerObj.profileType;
    var personalProfileTp = '-';
    var cancelReason = '-';
    var airportPackageId = $('#airportPackage').val();
    var airportPackageType = $('#airportPackageType').val();
    var dayPackageId = $('#dayPackage').val();
    var packageId = '-';
    var packageType = '-';

    if($('#personalProfileTp').length != 0){
        bookingType = 'Cooperate';
        personalProfileTp = $('#personalProfileTp').val();
    }

    if (no == ''){no = '-'}
    if (road == ''){road= '-'}
    if (city== ''){city= '-'}
    if (town== ''){town= '-'}
    if (landMark== ''){landMark= '-'}
    if (remark== ''){remark= '-'}
    if (callUpPrice== ''){callUpPrice= 0}
    if (dispatchB4== ''){dispatchB4= 30}
    if (destination== ''){destination= '-'}
    if (pagingBoard== ''){pagingBoard= '-'}

    if(airportPackageId != '-'){
        if( airportPackageType != '-'){
            packageId = airportPackageId;
            packageType = airportPackageType;
        }else{
            alert('Select a Airport Package Type');
        }
    }
    if(dayPackageId != '-'){
        packageId = dayPackageId;
        packageType = 'day';
    }

    //TODO : Call to load dispatcher modal conformation
    //$("#orderBuilder").load('dispatcher/newOrder/' + orderId);

    var address = {
        'no':no ,
        'road' : road ,
        'city' : city ,
        'town' : town ,
        'landmark' : landMark
    };
    var data = {
        'tp' : tp ,
        'data' : {
            'address' : address ,
            'vType' : vType ,
            'payType' : payType ,
            'bDate' : bDate,
            'bTime' : bTime ,

            'isUnmarked':isUnmarked,
            'isTinted':isTinted,
            'isVip':isVip,
            'isVih':isVih,
            'isCusNumberNotSent':isCusNumberNotSent,

            'status' : 'START' ,
            'cabId' : '-',
            'driverId' : '-',
            'remark' : remark ,
            'inqCall'      : 0,
            'callUpPrice' : callUpPrice,
            'dispatchB4' : dispatchB4,
            'pagingBoard' : pagingBoard,
            'destination' : destination,
            'bookingCharge' : bookingCharge,
            'bookingType' : bookingType,
            'personalProfileTp' : personalProfileTp,
            'cancelReason' :cancelReason,
            'packageId' : packageId,
            'packageType' : packageType,
            'sessionFirstBooking' : sessionFirstBooking
        }
    };
    var result = ajaxPost(data,url,false);
    sessionFirstBooking = false;
    url = siteUrl + '/customer_retriever/sendBookingDetails';
    var bookingConfirmationData = {
        'tp' : tp,
        'refId' : result.refId,
        'isSendWebSocket' : 'true'
        };
    ajaxPost(bookingConfirmationData,url,true);
}

function sendBookingConfirmationDetails(siteUrl, refId){
    var controllerUrl = siteUrl + '/customer_retriever/sendBookingDetails';
    var bookingConfirmationData = {
        'tp' : tp,
        'refId' : refId,
        'isSendWebSocket' : 'false'
    };
    ajaxPost(bookingConfirmationData,controllerUrl,true);
    alert('Confirmation SMS has been sent');
}

function updateBooking(url , objId){

    var baseUrl = url;
    url = baseUrl + "/customer_retriever/updateBooking";

    var no          = $('#no').val();
    var road        = $('#road').val();
    var city        = $('#city').val();
    var town        = $('#town').val();
    var landMark    = $('#landMark').val();
    var remark      = $('#remark').val();
    var callUpPrice = $('#callUpPrice').val();
    var destination = $('#destination').val();
    var dispatchB4  = $('#dispatchB4').val();
    var pagingBoard = $('#pagingBoard').val();
    var bDate      = $('#bDate').val();
    var bTime      = $('#bTime').val();
    var vType               = $('#vehicleType').val();
    var payType             = $('#paymentType').val();
    var isUnmarked          = $('#unmarked')[0].checked;
    var isTinted            = $('#tinted')[0].checked;
    var isVip               = $('#vip')[0].checked;
    var isVih               = $('#vih')[0].checked;
    var isCusNumberNotSent  = $('#cusNumberNotSent')[0].checked;
    var airportPackageId = $('#airportPackage').val();
    var airportPackageType = $('#airportPackageType').val();
    var dayPackageId = $('#dayPackage').val();
    var packageId = '-';
    var packageType = '-';

    if(airportPackageId != '-'){
        if( airportPackageType != '-'){
            packageId = airportPackageId;
            packageType = airportPackageType;
        }else{
            alert('Select a Airport Package Type');
        }
    }
    if(dayPackageId != '-'){
        packageId = dayPackageId;
        packageType = 'day';
    }

    var address = {
        'no':no ,
        'road' : road ,
        'city' : city ,
        'town' : town ,
        'landmark' : landMark
    };
    var data = {
        '_id' : objId,
        'data' : {
            'address' : address ,
            'vType' : vType ,
            'payType' : payType ,
            'bDate' : bDate,
            'bTime' : bTime ,

            'isUnmarked':isUnmarked,
            'isTinted':isTinted,
            'isVip':isVip,
            'isVih':isVih,
            'isCusNumberNotSent':isCusNumberNotSent,

            'remark' : remark ,
            'callUpPrice' : callUpPrice,
            'dispatchB4' : dispatchB4,
            'pagingBoard' : pagingBoard,
            'packageId' : packageId,
            'packageType' : packageType
        }
    };
    ajaxPost(data,url);
}

function editCustomerInfoEditView( url , tp ){
    url = url + "/cro_controller/getCustomerInfoEditView";
    var data = {'tp' : tp};
    var view = ajaxPost(data,url);
    $('#customerInformation').html(view.view.customer_info_edit_view);
}

function createCusInfo(url){
    var siteUrl = url;
    url = siteUrl + "/customer_retriever/createCustomer";
    var tp      = $('#tp').val();
    var tp2     = $('#tp2').val();
    var cusName = $('#cusName').val();
    var pRemark = $('#pRemark').val();
    var org     = $('#organization').val();
    var title = $('#title').val();
    var position = $('#position').val();
    var profileType = $('#profileType').val();

    var type1 = 'mobile';
    var type2 = 'mobile';

    if(document.getElementById('type1').checked) {
        type1='land'
    }
    if(document.getElementById('type2').checked) {
        type2='land'
    }

    if(tp == ''){
        alert('Telephone Number is Important');
        return false;
    };
    if(tp2 == ''){ tp2 = '-' };

    /* Added extra info to the customer object of total job and job cancellations */
    var data = {
        'profileType' : profileType ,
        'tp' : tp ,
        'type1' : type1 ,
        'tp2' : tp2 ,
        'type2' : type2 ,
        'name' : cusName ,
        'pRemark' : pRemark ,

        'org' : org ,
        'title' : title ,
        'position' : position,
        'dis_cancel' : 0 ,
        'tot_cancel' : 0,
        'tot_job' : 0
    };

    ajaxPost(data,url);

}

function updateCustomerInfo(url){

    var siteUrl = url;
    url = siteUrl + "/customer_retriever/updateCustomer";
    var editedTp      = $('#tp').val();
    var editedTp2     = $('#tp2').val();
    var cusName = $('#cusName').val();
    var pRemark = $('#pRemark').val();
    var org     = $('#organization').val();
    var title = $('#title').val();
    var position = $('#position').val();
    var profileType = $('#profileType').val();

    var type1 = 'mobile';
    var type2 = 'mobile';

    if(document.getElementById('type1').checked) {
        type1='land'
    }
    if(document.getElementById('type2').checked) {
        type2='land'
    }

    var data = {
        'profileType' : profileType,
        'tp' : tp ,
        'data' :
            {   'tp' : editedTp ,
                'type1' : type1 ,
                'tp2' : editedTp2 ,
                'type2' : type2 ,
                'name' : cusName ,
                'pRemark' : pRemark ,
                'org' : org ,
                'title' : title ,
                'position' : position
            }
    };
    ajaxPost(data,url);
    tp = editedTp;
}

function getCustomerInfoView( url , tp , isFromPABX ){

    url = url + "/cro_controller/getCustomerInfoView";
    isFromPABX = isFromPABX ? true : false ;
    var data = {"tp" : tp , 'isFromPABX' : isFromPABX };
    var view = ajaxPost(data,url);
    if(view.hasOwnProperty('important')){
        bookingObj=view.important.live_booking;
        historyBookingObj=view.important.history_booking;
        airportPackagesObj=view.important.airport_packages;
        dayPackagesObj=view.important.day_packages;
    }

    if(view.hasOwnProperty('important'))
    customerObj=view.important.customerInfo;

    /*  Populate the call center information view */
    $('#callCenterInfo').html(view.view.call_center_info_view);

    /*  Populate the customer information view */
    $('#customerInformation').html(view.view.customer_info_view);

    /*  Populate the job information view */
    $('#jobInfo').html(view.view.job_info_view);

    /*  Populate the job information view */
    $('#newBooking').html(view.view.new_booking_view);

    /*  Populate the job information view */
    $('#bookingHistory').html(view.view.booking_history_view);

    /*  Populate the job information view */
    $('#callHistory').html(view.view.call_history_view);
}

function addComplaint(url,refId){
    var complaint = prompt("Please enter your complaint", "");
    if (complaint != "") {
        url = url + "/complaint_controller/record_complaint";
        var data={
            'refId' : refId,
            'complaint' : complaint
        };
        ajaxPost(data,url,false);
    }
}

function getSimilarTpNumbers(url , tp){
    url = url + "/customer_retriever/getSimilarTpNumbers";
    var data = {"tp" : tp};
    var result = ajaxPost(data,url);
    return result['data'];
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

function ajaxPostCro(data,urlLoc)    {//alert("inside ajaxPostCro");
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

function changeJobInfoViewByRefId(bookingObjId){
    var index = -1;
    for(var i=0 ; i < bookingObj.length ; i++){
        index++;
        if( bookingObj[i]['_id']['$id'] === bookingObjId){
            break;
        }
    }

    var driverId = bookingObj[index]['driverId'];
    var cabId   = bookingObj[index]['cabId'];

    if(driverId == '-')  driverId = 'NOT_ASSIGNED';
    if(cabId == '-')  cabId = 'NOT_ASSIGNED';

    $('#jobRefId').html(bookingObj[index]['refId']);
    $('#jobStatus').html(bookingObj[index]['status']);
    $('#jobVehicleType').html(bookingObj[index]['vType']);
    $('#jobDriverId').html(driverId);
    $('#jobCabId').html(cabId);

    $('#jobAddress').attr("onclick", "operations('fillAddressToBooking',"+bookingObj[index]['_id']['$id']+")");
    $('#jobAddress').html(bookingObj[index]['address']['no'] + ' , ' + bookingObj[index]['address']['road'] + ' , ' +
                        bookingObj[index]['address']['city'] + ' , ' + bookingObj[index]['address']['town'] + ' ,'  +
                        bookingObj[index]['address']['landmark']);
    $('#jobDestination').html(bookingObj[index]['destination']);
    $('#jobCallUpPrice').html(bookingObj[index]['callUpPrice'] + ' /=');
    $('#jobRemark').html(bookingObj[index]['remark']);

    var specifications = "";
    if(bookingObj[index]['isVip'])
        specifications =specifications + ' VIP |';
    if(bookingObj[index]['isVih'])
        specifications =specifications + ' VIH |';
    if(bookingObj[index]['isUnmarked'])
        specifications =specifications + ' UNMARK |';
    if(bookingObj[index]['isTinted'])
        specifications =specifications + ' TINTED |';

    if(specifications == '')
        specifications = '-';

    $('#jobSpecifications').html(specifications);

    var bookDate=new Date(bookingObj[index]['bookTime']['sec'] * 1000);
    var callDate=new Date(bookingObj[index]['callTime']['sec'] * 1000);

    $('#jobBookTime').html(bookDate.toDateString()+'</br>'+bookDate.toTimeString());
    $('#jobCallTime').html(callDate.toDateString()+'</br>'+callDate.toTimeString());
    $('#jobDispatchB4').html(bookingObj[index]['dispatchB4']);
    $('#jobPayType').html(bookingObj[index]['payType']);

    $('#jobDriverTp').html(bookingObj[index]['driverTp']);
    $('#jobCabColor').html(bookingObj[index]['cabColor']);
    $('#jobCabPlateNo').html(bookingObj[index]['cabPlateNo']);
    $('#jobPagingBoard').html(bookingObj[index]['pagingBoard']);


    $('#jobEditButton').attr("onclick", "operations('authenticateUser',"+"'"+bookingObj[index]['_id']['$id']+"'"+",'editBooking')");
    $('#jobInquireButton').attr("onclick", "operations('addInquireCall',"+bookingObj[index]['_id']['$id']+")");
    $('#jobInquireButtonCount').html(bookingObj[index]['inqCall']);
    $('#jobComplaintButton').attr("onclick", "operations('addComplaint',"+bookingObj[index]['refId']+")");
    $('#jobCancelButton').attr("onclick", "operations('cancel',"+bookingObj[index]['_id']['$id']+")");
    $('#jobConfirmSmsResendButton').attr("onclick", "operations('resendConfirmationSms',"+bookingObj[index]['refId']+")");

}

function addUserToCooperateProfile(url,tp){

    var siteUrl = url;
    url = url + "/customer_retriever/addCustomerToCooperateProfile";
    var userTp = $('#cooperateUserTp').val();
    var data = {"tp" : tp , "userTp" : userTp};
    var result = ajaxPost(data,url);
    if( result.status == false ){
        alert(result.message);
        return false;
    }
    getCustomerInfoView(siteUrl , tp);
}

function fillAddressToBooking(bookingObjId){
    var index = -1;
    for(var i=0 ; i < bookingObj.length ; i++){
        index++;
        if( bookingObj[i]['_id']['$id'] === bookingObjId){
            break;
        }
    }

    $('#no').val(bookingObj[index]['address']['no']);
    $('#road').val(bookingObj[index]['address']['road']);
    $('#city').val(bookingObj[index]['address']['city']);
    $('#town').val(bookingObj[index]['address']['town']);
    $('#landMark').val(bookingObj[index]['address']['landmark']);

}

function fillAddressToBookingFromHistory(bookingObjId){
    var index = -1;
    for(var i=0 ; i < historyBookingObj.length ; i++){
        index++;
        if( historyBookingObj[i]['_id']['$id'] === bookingObjId){
            break;
        }
    }

    $('#no').val(historyBookingObj[index]['address']['no']);
    $('#road').val(historyBookingObj[index]['address']['road']);
    $('#city').val(historyBookingObj[index]['address']['city']);
    $('#town').val(historyBookingObj[index]['address']['town']);
    $('#landMark').val(historyBookingObj[index]['address']['landmark']);
}

function getCabHeaderView(){
    var url = '<?php echo site_url("cro_controller/getCabHeaderView") ?>';
    var result = ajaxPost(null,url);
    var div = document.getElementById('dataFiled');
    div.innerHTML = result.view.table_content;

}

function fillAirportPackageinBookings(){
    var airportPackage = $('#airportPackage').val();

    if(airportPackage == '-'){
        $('#airportPackageType').empty().append('<option selected value="-"> Select Package</option>');
    }

    var index = -1;
    for(var i=0 ; i < airportPackagesObj['data'].length ; i++){
        index++;
        if( airportPackagesObj['data'][i]['packageId'] == airportPackage ){
            break;
        }
    }

    $('#airportPackageType').empty().append('<option selected value="-"> Select Package</option>');
    $('#airportPackageType').append('<option value="drop">'+ 'Drop ('+airportPackagesObj['data'][index]['dropFee']+ ')'+'</option>');
    $('#airportPackageType').append('<option value="bothWay">'+ 'Both Way ('+airportPackagesObj['data'][index]['bothwayFee']+ ')'+'</option>');
    $('#airportPackageType').append('<option value="guestCarrier">'+ 'Guest Carrier ('+airportPackagesObj['data'][index]['guestCarrierFee']+ ')'+'</option>');
    $('#airportPackageType').append('<option value="outSide">'+ 'Out Side ('+airportPackagesObj['data'][index]['outsideFee']+ ')'+'</option>');

}

function selectAirportPackageandAddRemark(){
    var airportPackageType = $('#airportPackageType').val();

    if(airportPackageType == '-'){
        return;
    }else{
        var airportPackage = $('#airportPackage').val();
        var index = -1;
        for(var i=0 ; i < airportPackagesObj['data'].length ; i++){
            index++;
            if( airportPackagesObj['data'][i]['packageId'] == airportPackage ){
                break;
            }
        }

        var remarkAppended = airportPackagesObj['data'][index]['packageName'];

        if(airportPackageType == "drop" ){
            remarkAppended = remarkAppended + "Airport Drop(" + airportPackagesObj['data'][index]['dropFee'] +" /=)";
        }

        if(airportPackageType == "bothWay" ){
            remarkAppended = remarkAppended + "Airport Bothway(" + airportPackagesObj['data'][index]['bothwayFee'] +" /=)";
        }


        if(airportPackageType == "guestCarrier" ){
            remarkAppended = remarkAppended + "Airport Guest Carrier(" + airportPackagesObj['data'][index]['guestCarrierFee'] +" /=)";
        }

        if(airportPackageType == "outSide" ){
            remarkAppended = remarkAppended + "Airport Outside(" + airportPackagesObj['data'][index]['outsideFee'] +" /=)";
        }

        $('#remark').val($('#remark').val() + remarkAppended);

    }
}


function selectDayPackageandAddRemark(){
    var dayPackage = $('#dayPackage').val();
    if(dayPackage == '-'){
        return;
    }else{
        var index = -1;
        for(var i=0 ; i < dayPackagesObj['data'].length ; i++){
            index++;
            if( dayPackagesObj['data'][i]['packageId'] == dayPackage ){
                break;
            }
        }
        var remarkAppended = dayPackagesObj['data'][index]['packageName'] +
                              ' , ' + dayPackagesObj['data'][index]['km'] + '(km) ,' +
                            dayPackagesObj['data'][index]['hours'] + '(hrs) ,' +
                            dayPackagesObj['data'][index]['fee'] + '(/=) ,';

        $('#remark').val($('#remark').val() + remarkAppended);
    }
}

function showCalender(){
    $('#form_datetime').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });

    $('#form_date').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('#form_time').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 1,
        minView: 0,
        maxView: 1,
        forceParse: 0
    });
}

function uiInit(){

    $(".checkBoxMakeAppear").click(function(){
        $(this).parent().siblings('.checkBoxElementAppearing').toggle()
    });

    $(".btn-group > .btn").click(function(){
        $(this).addClass("active").siblings().removeClass("active");
        $(this).parent().siblings("input.customRadio").val($(this).val());
    });

    $("button.customRadio").click(function(){
        $(this).parent().siblings("input.customRadio").val($(this).val());
        $(this).parent().siblings("input.customRadio").text($(this).text())
    });
}

