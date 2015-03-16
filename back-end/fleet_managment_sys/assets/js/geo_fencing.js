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

var drawControl;
function openWithinTools() {
    closeAll();
    $.UIkit.notify({
        message: "Please draw the required area on the map",
        status: 'success',
        timeout: ApplicationOptions.constance.NOTIFY_SUCCESS_TIMEOUT,
        pos: 'top-center'
    });

    L.Control.RemoveAll = L.Control.extend(
        {
            options: {
                position: 'topleft'
            },
            onAdd: function (map) {
                var controlDiv = L.DomUtil.create('div', 'leaflet-draw-toolbar leaflet-bar');
                L.DomEvent
                    .addListener(controlDiv, 'click', L.DomEvent.stopPropagation)
                    .addListener(controlDiv, 'click', L.DomEvent.preventDefault)
                    .addListener(controlDiv, 'click', function () {
                        controlDiv.remove();
                        drawControl.removeFrom(map);
                        drawnItems.clearLayers();
                    });

                var controlUI = L.DomUtil.create('a', 'fa fa-times fa-lg drawControlCloseButton', controlDiv);
                $(controlUI).css("background-image", "none"); // Remove default control icon
                // TODO: bad usage of .hover() use CSS instead
                $(controlUI).mouseenter(function () {
                    $(this).css("color", "red");
                }).mouseleave(function () {
                    $(this).css("color", "black")
                });

                controlUI.title = 'Close drawer tools';
                controlUI.href = '#';
                return controlDiv;
            }
        });
    var removeAllControl = new L.Control.RemoveAll();
    map.addControl(removeAllControl);


    // Initialise the FeatureGroup to store editable layers
    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    // Initialise the draw control and pass it the FeatureGroup of editable layers
    drawControl = new L.Control.Draw({
        draw: {
            polygon: {
                allowIntersection: false, // Restricts shapes to simple polygons
                drawError: {
                    color: '#e1e100', // Color the shape will turn when intersects
                    message: '<strong>Oh snap!<strong> you can\'t draw that!' // Message that will show when intersect
                },
                shapeOptions: {
                    color: '#ff0043'
                }
            },
            rectangle: {
                shapeOptions: {
                    color: '#002bff'
                }
            },
            polyline: false,
            circle: false, // Turns off this drawing tool
            marker: false // Markers are not applicable for within geo fencing
        },
        edit: {
            featureGroup: drawnItems
        }
    });
    map.addControl(drawControl);

    map.on('draw:created', function (e) {
        var type = e.layerType,
            layer = e.layer;

/*        if (type === 'marker') {
            // Do marker specific actions
        }*/

        drawnItems.addLayer(layer);
        createPopup(layer);

    });

}

function createPopup(layer) {
    var popupTemplate = $('#setWithinAlert');
    popupTemplate.find('#exportGeoJson').attr('leaflet_id', layer._leaflet_id);
    popupTemplate.find('#editGeoJson').attr('leaflet_id', layer._leaflet_id);
    popupTemplate.find('#addWithinAlert').attr('leaflet_id', layer._leaflet_id);
    layer.bindPopup(popupTemplate.html(), {closeOnClick: false, closeButton: false}).openPopup();
    // transparent the layer .leaflet-popup-content-wrapper
    $(layer._popup._container.childNodes[0]).css("background", "rgba(255,255,255,0.8)");
}

function closeWithinTools(leafletId) {
    map.removeLayer(map._layers[leafletId]);
    map.removeControl(drawControl);
    console.log("DEBUG: closeWithinTools(leafletId) = "+leafletId);
}

/* Export selected area on the map as a json encoded geoJson standard file, no back-end calls simple HTML5 trick ;) */
function exportToGeoJSON(link, content) {
    // HTML5 features has been used here
    var geoJsonData = 'data:application/json;charset=utf-8,' + encodeURIComponent(content);
    // TODO: replace closest()  by using persistence id for templates, template id prefixed by unique id(i.e leaflet_id)
    var fileName = $(link).closest('form').find('#areaName').val() || 'geoJson';
    $(link).attr({
        'href': geoJsonData,
        'target': '_blank',
        'download': fileName + '.json' // Use the fence name given by the user as the file name of the JSON file
    });
}

$(function () {
    $("#importGeoJsonFile").change(function () {
        var importedFile = this.files[0];
        var reader = new FileReader();
        reader.readAsText(importedFile);
        reader.onload = function (e) {
            $("#enterGeoJson").text(e.target.result.toString());
        };
    });
});
function importGeoJson() {
//    inputFile = $('#importGeoJsonFile')[0].files[0];
    var updatedGeoJson;
//    // If the user has upload a file using the file browser this condition become true
//    if(inputFile){
//        // create HTML5 reader
//        fileName = inputFile.name.split('.json')[0];// TODO: put this file name (after removing the extension .json) in to the fence name #areaName input
//        var reader = new FileReader();
//        reader.readAsText(inputFile);
//        reader.onload = function(e) {
//            // browser completed reading file - display it
//            // Wait until the state become ready(complete the file read)
//            while(e.target.readyState != FileReader.DONE);
//            // Take the content of the file
//            // TODO: do validation, check wheather a valid JSON || GeoJSON file if not $.notify the user
//            updatedGeoJson = e.target.result.toString();
//            // TODO: check the uploded GeoJSON file for the type (circle, polygon , line, etc ) and update only if the drawn element is match with the uploaded geoJSON else $.notify the user
//            updateDrawing(updatedGeoJson);
//        };
//    }
//    // else use the edited text on the textarea
//    else{
    updatedGeoJson = $('#enterGeoJson').val();
    updateDrawing(updatedGeoJson);
//    }
}

function updateDrawing(updatedGeoJson) {
    updatedGeoJson = JSON.parse(updatedGeoJson);
    // Pop the last LatLng pair because according to the geoJSON standard it use complete round LatLng set to store polygon coordinates
    updatedGeoJson.geometry.coordinates[0].pop();
    var leafletLatLngs = [];
    $.each(updatedGeoJson.geometry.coordinates[0], function (idx, pItem) {
        leafletLatLngs.push({lat: pItem[1], lng: pItem[0]});
    });

    var polygon = new L.Polygon(leafletLatLngs);
    polygon.editing.enable();
    map.addLayer(polygon);
    createPopup(polygon);

    /*
     // For reffrence TODO: remove if not use
     currentDrawingLayer.setLatLngs(leafletLatLngs);
     layerId = $(button).attr('leaflet_id');
     console.log(layerId);
     currentDrawingLayer = map._layers[layerId];

     // At least a line or polygon must have 2 points so try the following with '0', '1',not more that that could give unexpected errors
     currentDrawingLayer._popup.setLatLng(leafletLatLngs[1]);
     // TODO: Use rails a-like id generating method to identify each copy of the the templates uniquely i.e marker_popup_{leaflet_layer_id}
     //$(button).closest('form').find('#areaName').val(fileName);
     */
    closeAll();

}

function viewFence(geoFenceElement) {
    var geoJson = JSON.parse($(geoFenceElement).attr('data-geoJson'));
    var queryName = $(geoFenceElement).attr('data-queryName');
    var areaName = $(geoFenceElement).attr('data-areaName');

    geoJson.coordinates[0].pop(); // popout the last coordinate set(lat,lng pair) due to circular chain
    var leafletLatLngs = [];
    $.each(geoJson.coordinates[0], function (idx, pItem) {
        leafletLatLngs.push({lat: pItem[1], lng: pItem[0]});
    });

    var polygon = new L.Polygon(leafletLatLngs);
    map.addLayer(polygon);

    $('#templateLoader').load("assets/html_templates/view_fence_popup.html #viewWithinAlert", function () {
        var popupTemplate = $('#templateLoader').find('#viewWithinAlert');
        popupTemplate.find('#exportGeoJson').attr('leaflet_id', polygon._leaflet_id);
        popupTemplate.find('#hideViewFence').attr('leaflet_id', polygon._leaflet_id);
        popupTemplate.find('#viewAreaName').html(areaName);
        popupTemplate.find('#viewQueryName').html(queryName);

        polygon.bindPopup(popupTemplate.html(), {closeButton: false}).openPopup();
        // transparent the layer .leaflet-popup-content-wrapper
        $(polygon._popup._container.childNodes[0]).css("background", "rgba(255,255,255,0.8)");
        closeAll();
    });
}