function getCabsDefaultView(url, docs_per_page , page){

    var data = {};
    var baseUrl=url;
    /*  To get the cab navbar */
    url =baseUrl + "/cab_retriever/getCabNavBar";
    var navResult = cabAjaxPost(data,url);
    var navDiv = document.getElementById('navBarField');
    navDiv.innerHTML = navResult.view.cab_navbar_view;

    /*  To get the cab side panel */
    url =baseUrl + "/cab_retriever/getSidePanelView";
    var sidePanelResult = cabAjaxPost(data,url);
    var sidePanelDiv = document.getElementById('operation');
    sidePanelDiv.innerHTML = sidePanelResult.view.side_panel_view;

    /*  To get the full cabs view */
    getAllCabs(docs_per_page , page ,baseUrl)
}


function getNewCabView(url){

    var data = {};
    url =url + "/cab_retriever/getNewCabView";
    var result = cabAjaxPost(data,url);
    var div = document.getElementById('dataFiled');
    div.innerHTML = result.view.new_cab_view;

}

function createNewCab(url , docs_per_page , page){
    var model = document.getElementById("model").value;
    var color = document.getElementById("color").value;
    var plateNo = document.getElementById("plateNo").value;
    var vType = document.getElementById("vType").value;
    var info = document.getElementById("info").value;

    var status = validate(plateNo , model , vType , color , info);
    /* Returns the function if validation fails */
    if(status == false){return false;}
    /* */
    if(color == "")color = "null";
    if(info == "")color = "null";

    /* Create a JSON object from the form values */
    var cab = {'model' : model , 'color' : color , 'plateNo' : plateNo , 'vType' : vType ,'info' : info, userId : '-1' };

    var baseUrl = url;
    url =baseUrl + "/cab_retriever/createCab";
    cabAjaxPost(cab,url);
    getAllCabs(docs_per_page , page ,baseUrl);
}

/* Gets all available cabs and show in the 'dataFiled' div tag */
function getAllCabs(docs_per_page , page ,url){
    url =url + "/cab_retriever/getAllCabsView";
    var skip = docs_per_page * (page-1);
    var data = {"skip" : skip , "limit" : docs_per_page};
    var view = cabAjaxPost(data,url);
    var div = document.getElementById('dataFiled');
    div.innerHTML = "";
    div.innerHTML = view.view.table_content;

}

function getCabView(url){

    var cabId = document.getElementById("cabIdSearch").value;
    /* Create a JSON object from the form values */
    var cab = { 'cabId' : parseInt(cabId) };
    url =url + "/cab_retriever/getCabSearchView";
    var result = ajaxPost(cab,url);
    var div = document.getElementById('dataFiled');
    div.innerHTML = result.view.table_content;

}

function makeCabFormEditable(cabId , url){

    var data = {'cabId' : parseInt(cabId) };
    url =url + "/cab_retriever/getCabEditView";
    var result = ajaxPost(data,url);
    var div = document.getElementById('dataFiled');
    div.innerHTML = result.view.cab_edit_view;
}


function updateCab(url , docs_per_page , page ){

    var cabId = document.getElementById("cabId").value;
    var model = document.getElementById("model").value;
    var color = document.getElementById("color").value;
    var plateNo = document.getElementById("plateNo").value;
    var vType = document.getElementById("vType").value;
    var info = document.getElementById("info").value;

    var status = validate(plateNo , model , vType , color , info);
    /* Returns the function if validation fails */
    if(status == false){return false;}

    if(color == "")color = "null";
    if(info == "")color = "null";

    /* Create a JSON object from the form values */
    var cab = {'cabId': parseInt(cabId) , 'details' : {'model' : model , 'color' : color , 'plateNo' : plateNo , 'vType' : vType ,'info' : info }};
    var baseUrl = url;
    url =url + "/cab_retriever/updateCab";
    cabAjaxPost(cab,url);
    getAllCabs(docs_per_page , page ,baseUrl);
}

function deleteCab(cabId){
    // Confirm Msg Box
    var data = {'cabId' : parseInt(cabId) };
    var url = '<?php echo site_url("cab_retriever/deleteCab") ?>';
    var result = ajaxPost(data,url);
    var div = document.getElementById('dataFiled');
    div.innerHTML = "";

}

function cabAjaxPost(data,urlLoc)    {
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

