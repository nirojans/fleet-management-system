<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-------------------------------- CSS Files------------------------------------>
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/simple-sidebar.css">
    <!-------------------------------- JS Files------------------------------------>
    <script type="text/javascript" src="<?= base_url();?>assets/js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap.js"></script>

    <script>

        var docs_per_page= 100 ;
        var page = 1 ;

    </script>
</head>
<body>
<nav class="navbar navbar-default" role="navigation" style="margin-bottom: 0px">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <a class="navbar-brand" href="#">Cao Cabs Admin Panel</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
            <li><a href="#" onclick="getAllCabs()">Manage Cabs</a></li>
            <li  class="active" ><a href="<?php echo site_url("test") ?>" >Manage Drivers</a></li>
        </ul>
        <form class="navbar-form navbar-left" role="search" id="getCab">
            <div class="form-group">
                <input class="form-control" placeholder="Driver ID" type="text" id="driverId">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        </form>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Link</a></li>
        </ul>
    </div><!-- /.navbar-collapse -->
</nav>

<div id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="#" onclick="getAllCabs()">View All Cabs </a>
            </li>
            <li><a href="#" id="newCab">New Cab</a></li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12" id="dataFiled">

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    /* Function to get a specific cab from the navbar search */
    $("#getCab").submit(function(event) {
        /* stop form from submitting normally */
        event.preventDefault();
        var cabId = document.getElementById("cabId").value;
        /* Create a JSON object from the form values */
        var cab = { 'cabId' : parseInt(cabId) };
        var url = '<?php echo site_url("cab_retriever/getCab") ?>';
        var result = ajaxPost(cab,url);

        var element="";
        var obj = result.data;
        element = element+'cab ID : '+obj.cabId+'</br>'+
        'Plate Number : '+obj.plateNo+'</br>';
        if(obj.model != null){
            element = element +'Model : '+obj.model+'</br>';
        }else{
            element = element +'Model : empty'+'</br>';
        }
        if(obj.info == null){
            element = element +'Info : '+obj.info+'</br>';
        }else{
            element = element +'Info : empty'+'</br>';
        }

        element = element + '<button onclick="getAllCabs()" value="Edit"> Edit </button>';
        var div = document.getElementById('dataFiled');
        div.innerHTML = element;
    });
</script>

<script>
    /* Function to get the input form from controller to add a new Cab */
    $('#newCab').click(function () {
        var data = {};
        var url = '<?php echo site_url("cab_retriever/getCabView") ?>';
        var result = ajaxPost(data,url);
        var div = document.getElementById('dataFiled');
        div.innerHTML = result.view.table_content;

    });
</script>


<script>
    /* Gets all available cabs and show in the 'dataFiled' div tag */
    function getAllCabs(){
        var skip = docs_per_page * (page-1);
        var data = {"skip" : skip , "limit" : docs_per_page};
        var url = '<?php echo site_url("cab_retriever/getCabsByPage") ?>';
        var result = ajaxPost(data,url);
        var element="";
        for(var i = 0; i < result.data.length; i++) {
            var obj = result.data[i];
            element = element+'cab ID : '+obj.cabId+'</br>'+
            'Plate Number : '+obj.plateNo+'</br>';
            if(obj.model != null){
                element = element +'Model : '+obj.model+'</br>';
            }else{
                element = element +'Model : empty'+'</br>';
            }
            if(obj.info == null){
                element = element +'Info : '+obj.info+'</br>';
            }else{
                element = element +'Info : empty'+'</br>';
            }

        }
        element = element + '<button onclick="getAllCabs()" value="1">1</button>';
        var div = document.getElementById('dataFiled');
        div.innerHTML = element;

    }
</script>

<script>
    /* Gets all available cabs and show in the 'dataFiled' div tag */
    function changeView(){
        var data = {};
        var url = '<?php echo site_url("test") ?>';
        var result = ajaxPost(data,url);
    }
</script>


<script>

    $("#createCab").submit(function(event) {
        /* stop form from submitting normally */
        event.preventDefault();
        alert('ajax post');
        var model = document.getElementById("model").value;
        var color = document.getElementById("color").value;
        var plateNo = document.getElementById("plateNo").value;
        var vType = document.getElementById("vType").value;
        var info = document.getElementById("info").value;
        /* Create a JSON object from the form values */
        var cab = {'model' : model , 'color' : color , 'plateNo' : plateNo , 'info' : info };

        var url = '<?php echo site_url("cab_retriever/createCab") ?>';
        var result = ajaxPost(cab,url);
        alert(JSON.stringify(result));



    });
</script>

<script>
    /* Loads all the cab details after the page loads */
    window.onload = getAllCabs;
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
