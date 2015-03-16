/*
 *  Copyright (c) 2005-2010, WSO2 Inc. (http://www.wso2.org) All Rights Reserved.
 *
 *  WSO2 Inc. licenses this file to you under the Apache License,
 *  Version 2.0 (the "License"); you may not use this file except
 *  in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */


$(".modal").draggable({
    handle: ".modal-header"
});

//Clear modal content for reuse the wrapper by other functions
$('body').on('hidden.bs.modal', '.modal', function () {
    $(this).removeData('bs.modal');
});

function success(position) {
    var browserLatitude = position.coords.latitude;
    var browserLongitude = position.coords.longitude;
    map.setView([browserLatitude, browserLongitude]);
    map.setZoom(13);


    $.UIkit.notify({
        message: "Map view set to browser's location",
        status: 'info',
        timeout: ApplicationOptions.constance.NOTIFY_INFO_TIMEOUT,
        pos: 'top-center'
    });
};

function error() {
    $.UIkit.notify({
        message: "Unable to find browser location!",
        status: 'warning',
        timeout: ApplicationOptions.constance.NOTIFY_WARNING_TIMEOUT,
        pos: 'top-center'
    });
};

/* Attribution control */
function updateAttribution(e) {
    $.each(map._layers, function (index, layer) {
        if (layer.getAttribution) {
            $("#attribution").html((layer.getAttribution()));
        }
    });
}


/* Highlight search box text on click */
$("#searchbox").click(function () {
    $(this).select();
});

/* TypeAhead search functionality */
function getSearchKey(order,q){
    var queryIsNAN = isNaN(q);
    //console.log(queryIsNAN);
    //console.log(q);

    var searchKey;
    var leftSidePane = $("#leftSidePane");
    if(leftSidePane.find('#searchByRefId').hasClass('active') && !queryIsNAN){
        searchKey = order.refId;
        //console.log("Search by refId");
    }
    else if(leftSidePane.find('#searchByTown').hasClass('active') || queryIsNAN){
        searchKey = order.address.town;
        //console.log("Search by townnnn");
    }

    //console.log(searchKey);
    return searchKey;
}

var substringMatcher = function () {
    return function findMatches(q, cb) {
        //console.log("q = "+q+" cb = "+cb);

        var matches, substrRegex;
        matches = [];
        substrRegex = new RegExp(q, 'i');
        $('#liveOrdersList .mCSB_container').empty();
        $.each(unDispatchedOrders, function (i, order) {
            //console.log("i = "+i+" order = "+order);
            var searchKey = getSearchKey(order,q);
            //console.log("searchKey = "+searchKey);

            if (substrRegex.test(searchKey)) {
                addNewOrder(order);
                matches.push({ value: searchKey , order: order});
            }
        });
        cb(matches);
    };
};

$('#orderSearch').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    },
    {
        name: 'speed',
        displayKey: 'value',
        source: substringMatcher()
    }).on('typeahead:selected', function ($e, datum) {
        objectId = datum['value'];
        dispatchOrder(datum.order.refId);
    });

var locations = new Bloodhound({
    datumTokenizer : function(d) {
        return Bloodhound.tokenizers.whitespace(d.value);
    },
    queryTokenizer : Bloodhound.tokenizers.whitespace,
    remote : {
        url : 'testing/geo_names?location=%QUERY',
        filter : function(locations) {
            return ($.map(locations, function(location) {
                return {
                    value : location.name,
                    location: location.location
                };
            }));

        }
    }
});

init_typeahead();

function init_typeahead() {
    locations.initialize();
    $('#locationSearchbox').typeahead({
        hint : true,
        highlight : true,
        minLength : 1
    }, {
        name : 'name',
        displayKey : 'value',
        source : locations.ttAdapter()
    }).on('typeahead:selected', function($e, datum) {
        var coordinates = datum.location.coordinates;
        map.setView([coordinates[1],coordinates[0]],15);
    }).on('typeahead:selected', function($e, datum) {
        var coordinates = datum.location.coordinates;
        map.setView([coordinates[1],coordinates[0]],15);
    });
}



// TODO: when click on a notification alert ? "Uncaught ReferenceError: KM is not defined "
var toggled = false;
function focusOnSpatialObject(objectId) {
    var spatialObject = currentOrdersList[objectId];// (local)
    if (!spatialObject) {
        $.UIkit.notify({
            message: "Spatial Object <span style='color:red'>" + objectId + "</span> not in the Map!!",
            status: 'warning',
            timeout: ApplicationOptions.constance.NOTIFY_WARNING_TIMEOUT,
            pos: 'top-center'
        });
        return false;
    }
    clearFocus(); // Clear current focus if any
    selectedSpatialObject = objectId; // (global) Why not use 'var' other than implicit declaration http://stackoverflow.com/questions/1470488/what-is-the-function-of-the-var-keyword-and-when-to-use-it-or-omit-it#answer-1471738

    map.setView(spatialObject.marker.getLatLng(), 17, {animate: true}); // TODO: check the map._layersMaxZoom and set the zoom level accordingly

    $('#objectInfo').find('#objectInfoId').html(selectedSpatialObject);
    spatialObject.marker.openPopup();
    if (!toggled) {
        $('#objectInfo').animate({width: 'toggle'}, 100);
        toggled = true;
    }
    getAlertsHistory(objectId);
    spatialObject.drawPath();
    setTimeout(function () {
        createChart();
        chart.load({columns: [spatialObject.speedHistory.getArray()]});
    }, 100);
}

// Unfocused on current searched spatial object
function clearFocus() {
    if (selectedSpatialObject) {
        spatialObject = currentOrdersList[selectedSpatialObject];
        spatialObject.removePath();
        spatialObject.marker.closePopup();
        selectedSpatialObject = null;
    }
}

// TODO:this is not a remote call , move this to application.js
function closeAll() {
    $('.modal').modal('hide');
    setTimeout(function () {
        $.UIkit.offcanvas.hide()
    }, 100);
}


