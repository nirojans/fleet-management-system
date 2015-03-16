<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <!-------------------------------- JS Files------------------------------------>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.10.2.js');?>"></script>
</head>
<body>

<button onclick="createCustomer()">create customer</button></br>
<button onclick="getSimilar()">like Number</button></br>
<button onclick="getCustomer()">Get Customer</button></br>
<button onclick="addBooking()">addBooking</button></br>
<button onclick="canceled()">cancel booking</button></br>
<button onclick="updateBooking()">update booking</button></br>
<button onclick="addInquireCall()">add inquire call</button></br>

<script>

    function addInquireCall(){

        var data = {'tp' : '0779823445' , 'refId' : 2 };
        var url = '<?php echo site_url("customer_retriever/addInquireCall") ?>';
        var result=ajaxPost(data,url);
        alert(JSON.stringify(result));

    }

    function updateBooking(){

        var data = {'tp' : '0779823445' , 'refId' : 2 , 'data' : {"cabId" : "changed"}};
        var url = '<?php echo site_url("customer_retriever/updateBooking") ?>';
        var result=ajaxPost(data,url);
        alert(JSON.stringify(result));

    }

    function canceled(){

        var data = {'tp' : '0779823445' , 'refId' : 2};
        var url = '<?php echo site_url("customer_retriever/canceled") ?>';
        var result=ajaxPost(data,url);
        alert(JSON.stringify(result));

    }

    function addBooking(){

        var address={'number' : '8/2', 'road' : 'vihara road', 'city' : 'Mount', 'town' : 'Colombo', "landmark" : "near Cargills"}
        var booking={'status' : 'start', 'address' : address, "cabId" : null,
            "driverId" : null, "bDate" : "2010-01-15", "bTime" : "00:00:00" ,"payType" : "cash | credit", "vType" : "nano",
            "remark" : "tinted window", "call_up" : "true | false" , 'inqCall' : 0 , "fee" : 1550 };
        var data = {'tp' : '0779823445', 'data' : booking};
        var url = '<?php echo site_url("customer_retriever/addBooking") ?>';
        var result=ajaxPost(data,url);
        alert(JSON.stringify(result));

    }

    function getSimilar(){

        var data = {'tp' : '077982'};
        var url = '<?php echo site_url("customer_retriever/getSimilar") ?>';
        var result=ajaxPost(data,url);
        alert(JSON.stringify(result));

    }

    function createCustomer(){

        var customer = {'tp' : '0779823445', 'type' : 'mobile', 'Name' : 'niro', 'title' : 'Mr', "designation" : "null", "permanent_remark" : "some remark",
                        'tot_cancel' : 0 , dis_cancel : 0 };
        var url = '<?php echo site_url("customer_retriever/createCustomer") ?>';
        var result=ajaxPost(customer,url);
        alert(JSON.stringify(result));

    }

    function getCustomer(){

        var customer = {'tp' : '0779823445'};
        var url = '<?php echo site_url("customer_retriever/getCustomer") ?>';
        var result = ajaxPost(customer,url);
        alert(JSON.stringify(result));

    }

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
                alert(result.statusMsg);
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