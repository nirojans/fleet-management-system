/**
 * Created by dehan on 11/1/14.
 */
//Models

var LocationBoard = {};
LocationBoard.zones = [];
LocationBoard.other = [];

LocationBoard.pending = [];
LocationBoard.pob = [];


function Zone(id, name) {
    this.id = id;
    this.name = name;
    this.idle = {};
    this.idle.cabId = ko.observable();
    this.idle.cabs = ko.observableArray([]);


    this.pob = {};
    this.pob.cabId = ko.observable();
    this.pob.cabEta = ko.observable();
    this.pob.cabs = ko.observableArray([]);
}

function Other(id, name) {
    this.id = id;
    this.name = name;

    this.cabId = ko.observable();
    this.cabEta = ko.observable();
    this.cabs = ko.observableArray([]);
}

function Cab(data) {
    this.id = data.cabId;
    this.attributes = {};
    this.userId = data.userId;
    this.model = data.model;
    this.vehicleColor = data.color;
    this.vehicleType = data.vType;
    this.info = data.info;
    this.zone = data.zone;
    this.state = ko.observable(data.state);
    this.eta = data.eta;
    this.callingNumber = data.callingNumber;
    this.logSheetNumber = data.logSheetNumber;
}



var zone1 = new Zone(1, "Fort");
var zone2 = new Zone(2, "Nawaloka");
var zone3 = new Zone(3, "Colombo 03");
var zone4 = new Zone(4, "Marinedrive 03");
var zone5 = new Zone(5, "Colombo 04");
var zone6 = new Zone(6, "Marinedrive 04");
var zone7 = new Zone(7, "T'Mulla/Thimbiri");
var zone8 = new Zone(8, "Vilasitha(Kirulapona)");
var zone9 = new Zone(9, "Colombo 06");
var zone10 = new Zone(10, "Marinedrive 06");

var zone11 = new Zone(11, "Alex");
var zone12 = new Zone(12, "Rupavahing");
var zone13 = new Zone(13, "Borella");
var zone14 = new Zone(14, "Narahenpita");
var zone15 = new Zone(15, "Nawala");
var zone16 = new Zone(16, "Rajagiriya");
var zone17 = new Zone(17, "Kotte");
var zone18 = new Zone(18, "Battaramulla");
var zone19 = new Zone(19, "Malabe");
var zone20 = new Zone(20, "Kottawa");
var zone21 = new Zone(21, "Maharagama");
var zone22 = new Zone(22, "Nugegoda");
var zone23 = new Zone(23, "Piliyandala");
var zone24 = new Zone(24, "Boralesgamuwa");
var zone25 = new Zone(25, "Kohuvala");
var zone26 = new Zone(26, "Kalubovila");
var zone27 = new Zone(27, "Dehivala");
var zone28 = new Zone(28, "Mount Lavinia");

var zone29 = new Zone(29, "Rathmalana");
var zone30 = new Zone(30, "Moratuwa");
var zone31 = new Zone(31, "Panadura");
var zone32 = new Zone(32, "Dematagoda");
var zone33 = new Zone(33, "paliyagoda");
var zone34 = new Zone(34, "Wattala");
var zone35 = new Zone(35, "Kiribathgoda");
var zone36 = new Zone(36, "Ja-Ela");
var zone37 = new Zone(37, "Kadawatha");
var zone38 = new Zone(38, "Seeduwa");
var zone39 = new Zone(39, "KIA");
var zone40 = new Zone(40, "Negombo");


var other1 = new Other(41, "Outstation");
var other2 = new Other(42, "Writing Hire");
var other3 = new Other(43, "Package");
var other4 = new Other(44, "Corporate");
var other5 = new Other(45, "Lunch and Tea");
var other6 = new Other(46, "Break Down");
var other7 = new Other(47, "Not Reported");
var other8 = new Other(48, "Leave");
var other9 = new Other(48, "None");
//zone1.idle.cabs.push(cb1)
//zone1.idle.cabs.push(cab4);
//zone1.idle.cabs.push(cab5);
//zone1.idle.cabs.push(cab6);
//zone1.idle.cabs.push(cab7);
//zone2.idle.cabs.push(cab2);
//zone3.idle.cabs.push(cab3);
//zone4.idle.cabs.push(cab4);

LocationBoard.zones.push(zone1);
LocationBoard.zones.push(zone2);
LocationBoard.zones.push(zone3);
LocationBoard.zones.push(zone4);
LocationBoard.zones.push(zone5);
LocationBoard.zones.push(zone6);
LocationBoard.zones.push(zone7);
LocationBoard.zones.push(zone8);
LocationBoard.zones.push(zone9);
LocationBoard.zones.push(zone10);

LocationBoard.zones.push(zone11);
LocationBoard.zones.push(zone12);
LocationBoard.zones.push(zone13);
LocationBoard.zones.push(zone14);
LocationBoard.zones.push(zone15);
LocationBoard.zones.push(zone16);
LocationBoard.zones.push(zone17);
LocationBoard.zones.push(zone18);
LocationBoard.zones.push(zone19);
LocationBoard.zones.push(zone20);

LocationBoard.zones.push(zone21);
LocationBoard.zones.push(zone22);
LocationBoard.zones.push(zone23);
LocationBoard.zones.push(zone24);
LocationBoard.zones.push(zone25);
LocationBoard.zones.push(zone26);
LocationBoard.zones.push(zone27);
LocationBoard.zones.push(zone28);
LocationBoard.zones.push(zone29);
LocationBoard.zones.push(zone30);

LocationBoard.zones.push(zone31);
LocationBoard.zones.push(zone32);


//====================================//

LocationBoard.zones.push(zone33);
LocationBoard.zones.push(zone34);
LocationBoard.zones.push(zone35);
LocationBoard.zones.push(zone36);
LocationBoard.zones.push(zone37);
LocationBoard.zones.push(zone38);
LocationBoard.zones.push(zone39);
LocationBoard.zones.push(zone40);


//Other Zones

LocationBoard.other.push(other1);
LocationBoard.other.push(other2);
LocationBoard.other.push(other3);
LocationBoard.other.push(other4);
LocationBoard.other.push(other5);
LocationBoard.other.push(other6);
LocationBoard.other.push(other7);
LocationBoard.other.push(other8);
LocationBoard.other.push(other9);

//=================End Of Models======================//

//Global Variables
var currentActiveOrder = 12345678;

//==============ViewModel============================//

var baseUrl = ApplicationOptions.constance.BASE_URL;

var serviceUrl = baseUrl;
function LocationBoardViewModel() {
    var self = this;

    var zonesLength = LocationBoard.zones.length;
    var otherLength = LocationBoard.other.length;


    self.zones = ko.observableArray(LocationBoard.zones);

    self.other = ko.observableArray(LocationBoard.other);

    self.pendingCabs = ko.observableArray([]);

    self.otherCabs = ko.observableArray([]);

    self.cabList = {};

    self.initializeLocationBoard = function () {
        self.responseCabs;
        $.ajax({
            url: serviceUrl + "dispatcher/cabsInZones",
            type: "GET",
            dataType: "json"
        }).done(function (response) {

            self.cabListBuffer = $.map(response, function (item) {
                return new Cab(item);
            });

            self.cabList = ko.observableArray(self.cabListBuffer);

            //Push Cabs to 4 seperate collections....
            // zone.pob...
            // zone.idle...
            // pendingCabs...
            // other....
            for (var key in self.cabList()) {
                var currentCab = self.cabList()[key];
                var currentCabState = ko.utils.unwrapObservable(currentCab.state);

                /*if (currentCabState === "IDLE" && currentCab.zone === "None") {
                 var otherObject = ko.utils.arrayFirst(LocationBoard.other, function(item) {
                 return item.name === "Unknown"
                 });
                 var index = ko.utils.arrayIndexOf(LocationBoard.other,otherObject);
                 if(index != -1){
                 self.other()[index].cabs.push(currentCab);

                 }
                 }
                 else */

                if (currentCab.userId === -1 || currentCab.callingNumber === -1) {//If user or calling number not assigned put into not reported
                    var otherObject = ko.utils.arrayFirst(LocationBoard.other, function (item) {
                        return item.name === "Not Reported"
                    });
                    var index = ko.utils.arrayIndexOf(LocationBoard.other, otherObject);
                    if (index != -1) {
                        self.other()[index].cabs.push(currentCab);
                    }
                }
                //OTHER State and Idle|None Combinations belong to the OTHER Panel
                else if (currentCabState === "OTHER" || currentCab.zone === "None") {
                    var otherObject = ko.utils.arrayFirst(LocationBoard.other, function (item) {
                        return item.name === currentCab.zone
                    });
                    var index = ko.utils.arrayIndexOf(LocationBoard.other, otherObject);
                    if (index != -1) {
                        self.other()[index].cabs.push(currentCab);

                    }
                }
                else if (currentCabState === "MSG_NOT_COPIED" || currentCabState === "MSG_COPIED" || currentCabState === "AT_THE_PLACE") {
                    self.pendingCabs.push(currentCab);

                }
                else {
                    var zoneObject = ko.utils.arrayFirst(LocationBoard.zones, function (item) {
                        return item.name === currentCab.zone
                    });
                    var index = ko.utils.arrayIndexOf(LocationBoard.zones, zoneObject);
                    if (index != -1) {
                        if (currentCabState == "IDLE") {
                            self.zones()[index]["idle"].cabs.push(currentCab);
                        }
                        else if (currentCabState == "POB") {
                            self.zones()[index]["pob"].cabs.push(currentCab);
                        }
                    }

                }

            }

            //Sort ETA cabs by time
            for (key in self.zones()) {
                self.zones()[key].pob.cabs.sort(function (cab1, cab2) {
                    cab1eta = parseInt(cab1.eta);
                    cab2eta = parseInt(cab2.eta);
                    if (cab1eta > cab2eta) {
                        return 1;
                    }
                    if (cab1eta < cab2eta) {
                        return -1;
                    }
                    return 0;
                });
            }


        }).fail(function (jqXHR, textStatus) {
            console.log("Location Board Init failed: " + textStatus);
        });
    };


    //Devided view of columns
    var zonesRange1 = self.zones.slice(0, Math.round(zonesLength / 2));
    var zonesRange2 = self.zones.slice(Math.round(zonesLength / 2), zonesLength);


    self.ZonesColumn1 = ko.computed(function () {
        var zoneList = LocationBoard.zones.slice(0, Math.round(zonesLength / 2));
        return zoneList;
    });

    self.ZonesColumn2 = ko.computed(function () {
        var zoneList = LocationBoard.zones.slice(Math.round(zonesLength / 2), zonesLength);
        return zoneList;
    });


    self.PobZonesColumn1 = ko.computed(function () {
        var zoneList = LocationBoard.zones.slice(0, Math.round(zonesLength / 2));
        return zoneList;
    });

    self.PobZonesColumn2 = ko.computed(function () {
        var zoneList = LocationBoard.zones.slice(Math.round(zonesLength / 2), zonesLength);
        return zoneList;
    });


    self.OtherColumn1 = ko.computed(function () {
        var zoneList = LocationBoard.other.slice(0, Math.round(otherLength / 2));
        return zoneList;
    });

    self.OtherColumn2 = ko.computed(function () {
        var zoneList = LocationBoard.other.slice(Math.round(otherLength / 2), otherLength);
        return zoneList;
    });
    //end of divided view of colombo


    //Total view of columns
    self.Zones = ko.computed(function () {
        var zoneList = LocationBoard.zones;
        return zoneList;
    });
    self.PobZones = ko.computed(function () {
        var zoneList = LocationBoard.zones;
        return zoneList;
    });
    self.Others = ko.computed(function () {
        var zoneList = LocationBoard.other;
        return zoneList;
    });
    //end of divided view of colombo


    self.addIdleCab = function (zone, event) {

        cabId = parseInt(zone.idle.cabId());
        zone.idle.cabId('');


        sendingData = {};
        sendingData.cabId = cabId;
        sendingData.zone = zone.name;

        var gotResponse = null;
        $.ajax({
            url: serviceUrl + "cab_retriever/getCab",
            data: sendingData,
            async:false,
            dataType:"json"
        }).done(function(validationResponse) {
            if (validationResponse.data.cabId !== undefined ) {
                var callingNumber = validationResponse.data.callingNumber;
                if (callingNumber !== -1) {
                    $.post(serviceUrl + "dispatcher/setIdleZone", sendingData, function (response) {
                        gotResponse = response;
                        gotResponse.state = "IDLE";
                        var currentCab = new Cab(gotResponse);

                        var lastZone = response.lastZone;

                        //Remove from last zone and all other places
                        var zoneObjectToRemove = ko.utils.arrayFirst(LocationBoard.zones, function (item) {
                            return item.name === lastZone
                        });
                        var indexToRemove = ko.utils.arrayIndexOf(LocationBoard.zones, zoneObjectToRemove);
                        //If cab was not other [when other, state = IDLE, zone = null]
                        if (indexToRemove != -1) {
                            self.zones()[indexToRemove].idle.cabs.remove(function (item) {
                                return item.id === currentCab.id
                            });
                            self.zones()[indexToRemove].pob.cabs.remove(function (item) {
                                return item.id === currentCab.id
                            });
                        }
                        self.pendingCabs.remove(function (item) {
                            return item.id === currentCab.id
                        });
                        //Remove from other
                        var otherObject = ko.utils.arrayFirst(LocationBoard.other, function (item) {
                            return item.name === lastZone
                        });
                        var otherIndexToRemove = ko.utils.arrayIndexOf(LocationBoard.other, otherObject);
                        if (otherIndexToRemove != -1) {
                            self.other()[otherIndexToRemove].cabs.remove(function (item) {
                                return item.id === currentCab.id
                            });
                        }


                        //Add to new zone
                        var zoneObjectToAdd = ko.utils.arrayFirst(LocationBoard.zones, function (item) {
                            return item.name === currentCab.zone
                        });
                        var indexToAdd = ko.utils.arrayIndexOf(LocationBoard.zones, zoneObjectToAdd);
                        if (indexToAdd !== -1) {
                            self.zones()[indexToAdd].idle.cabs.push(currentCab);
                        }
                        else {
                            alert("Unknown Error, Zone is undefined");
                        }


                    });
                }
                else {
                    alert("Calling Number is not assigned");
                }
            }
            else{
                alert("Cab does not exist");
            }

        });


    };

    self.addPobCab = function (zone, event) {

        if (zone.pob.cabId() === undefined) {
            alert("Enter a Cab Id");
            return;

        }
        sendingData = {};
        sendingData.cabId = parseInt(zone.pob.cabId());
        sendingData.cabEta = zone.pob.cabEta();
        sendingData.zone = zone.name;

        zone.pob.cabEta('');
        zone.pob.cabId('');

        $.ajax({
            url: serviceUrl + "cab_retriever/getCab",
            data: sendingData,
            async:false,
            dataType:"json"
        }).done(function(validationResponse) {
            if (validationResponse.data.cabId !== undefined ) {
                var callingNumber = validationResponse.data.callingNumber;
                if (callingNumber !== -1) {
                    $.post('dispatcher/setPobDestinationZoneTime', sendingData, function (response) {
                        gotResponse = response;
                        gotResponse.state = "POB";
                        var lastZone = response.lastZone;
                        var currentCab = new Cab(gotResponse);

                        self.removeCabFromAllBoards(lastZone, currentCab.id);


                        //Add to new zone
                        var zoneObjectToAdd = ko.utils.arrayFirst(LocationBoard.zones, function (item) {
                            return item.name === currentCab.zone
                        });
                        var indexToAdd = ko.utils.arrayIndexOf(LocationBoard.zones, zoneObjectToAdd);
                        if (indexToAdd !== -1) {
                            self.zones()[indexToAdd].pob.cabs.push(currentCab);
                        }

                        //Sort ETA cabs by time
                        self.zones()[indexToAdd].pob.cabs.sort(function (cab1, cab2) {
                            if (cab1.eta > cab2.eta) {
                                return 1;
                            }
                            if (cab1.eta < cab2.eta) {
                                return -1;
                            }
                            return 0;
                        });


                    });
                }
                else {
                    alert("Calling Number is not assigned");
                }
            }
            else{
                alert("Cab does not exist");
            }

        });

    };

    self.addOtherCab = function (other, event) {

        sendingData = {};
        sendingData.cabId = parseInt(other.cabId());
        sendingData.zone = other.name;

        other.cabId('');
        $.post('dispatcher/setOtherState', sendingData, function (response) {
            gotResponse = response;
            gotResponse.state = "OTHER";
            var lastZone = response.lastZone;
            var currentCab = new Cab(gotResponse);

            self.removeCabFromAllBoards(lastZone, currentCab.id);

            //Remove from other
            var otherObject = ko.utils.arrayFirst(LocationBoard.other, function (item) {
                return item.name === lastZone
            });
            var otherIndexToRemove = ko.utils.arrayIndexOf(LocationBoard.other, otherObject);
            if (otherIndexToRemove != -1) {
                self.other()[otherIndexToRemove].cabs.remove(function (item) {
                    return item.id === currentCab.id
                });
            }


            //Add to new inactive zone
            var otherObjectToAdd = ko.utils.arrayFirst(LocationBoard.other, function (item) {
                return item.name === currentCab.zone
            });
            var indexToAdd = ko.utils.arrayIndexOf(LocationBoard.other, otherObjectToAdd);
            if (indexToAdd !== -1) {
                self.other()[indexToAdd].cabs.push(currentCab);
            }


        });

    };

    self.dispatchCab = function (zone, cab) {
        $("#assignedCab").load('dispatcher/cabDetails/' + cab.id);
        dispatchDetails['zone'] = zone;
        dispatchDetails['cab'] = cab;

    };

/*

    self.removeCabFromPending = function (vm, cab) {
        sendingData = {};
        sendingData.cabId = cab.id;
        $.post(serviceUrl + "dispatcher/setInactive", sendingData, function (response) {
            self.pendingCabs.remove(cab);
            gotResponse = response;
            gotResponse.state = "OTHER";
            var lastZone = response.lastZone;
            var currentCab = new Cab(gotResponse);

            var otherObject = ko.utils.arrayFirst(LocationBoard.other, function (item) {
                return item.name === currentCab.zone
            });

            var otherIndexToAdd = ko.utils.arrayIndexOf(LocationBoard.other, otherObject);
            if (otherIndexToAdd != -1) {
                self.other()[otherIndexToAdd].cabs.push(currentCab);
            }

        });


    };
*/


    //Removes cab from given place and persists it to the none zone in the inactive board
    self.removeCabAndSetToNone = function (zone, cab) {
        sendingData = {};
        sendingData.cabId = cab.id;
        $.post(serviceUrl + "dispatcher/setInactive", sendingData, function (response) {
            self.removeCabFromAllBoards(zone.name, cab.id);
            gotResponse = response;
            gotResponse.state = "OTHER";

            var currentCab = new Cab(gotResponse);
            //ADD TO OTHER
            var otherObject = ko.utils.arrayFirst(LocationBoard.other, function (item) {
                return item.name === currentCab.zone
            });

            var otherIndexToAdd = ko.utils.arrayIndexOf(LocationBoard.other, otherObject);
            if (otherIndexToAdd != -1) {
                self.other()[otherIndexToAdd].cabs.push(currentCab);
            }


        });


    };

    //A function that just removes the ui cab object from the location board ui
    self.removeCabFromAllBoards = function (lastZone, cabId) {

        self.pendingCabs.remove(function (item) {
            return item.id === cabId
        });

        for (var key in LocationBoard.zones) {
            self.zones()[key].idle.cabs.remove(function (item) {
                return item.id === cabId
            });
            self.zones()[key].pob.cabs.remove(function (item) {
                return item.id === cabId
            });
        }
        for (var key in LocationBoard.other) {
            self.other()[key].cabs.remove(function (item) {
                return item.id === cabId
            });
        }

    };



    // To set from pob to live automatically
    self.setToIdleFromPob = function (zone, cab) {

        sendingData = {};
        sendingData.cabId = cab.cabId;
        sendingData.zone = zone.name;
        $.post(serviceUrl + "dispatcher/setIdleZone", sendingData, function (response) {
            zone.pob.cabs.remove(cab);
            gotResponse = response;

            var currentCab = new Cab(gotResponse);

            var lastZone = response.lastZone;

            if (gotResponse !== null || gotResponse.driver !== null) {


                self.removeCabFromAllBoards(lastZone, currentCab.id);

                //Add to new Idle zone
                var zoneObjectToAdd = ko.utils.arrayFirst(LocationBoard.zones, function (item) {
                    return item.name === currentCab.zone
                });
                var indexToAdd = ko.utils.arrayIndexOf(LocationBoard.zones, zoneObjectToAdd);
                if (indexToAdd !== -1) {
                    self.zones()[indexToAdd].idle.cabs.push(currentCab);
                }
                else {
                    alert("Unknown Error, Zone is undefined");
                }

            }
            else {
                alert('Cab Id does not exist');
            }

        });


    };


    //To set to idle manually
    self.setToIdleFromStringParams = function (zoneName, cabId) {

        sendingData = {};
        sendingData.cabId = cabId;
        sendingData.zone = zoneName;
        $.post(serviceUrl + "dispatcher/setIdleZone", sendingData, function (response) {

            gotResponse = response;

            var currentCab = new Cab(gotResponse);
            //zone.pob.cabs.remove(currentCab);

            var lastZone = response.lastZone;

            if (gotResponse !== null || gotResponse.driver !== null) {


                self.removeCabFromAllBoards(lastZone, currentCab.id);

                //Add to new Idle zone
                var zoneObjectToAdd = ko.utils.arrayFirst(LocationBoard.zones, function (item) {
                    return item.name === currentCab.zone
                });
                var indexToAdd = ko.utils.arrayIndexOf(LocationBoard.zones, zoneObjectToAdd);
                if (indexToAdd !== -1) {
                    self.zones()[indexToAdd].idle.cabs.push(currentCab);
                }
                else {
                    alert("Unknown Error, Zone is undefined");
                }

            }
            else {
                alert('Cab Id does not exist');
            }

        });


    };



    self.updateStatus = function (cab) {
        var sendingData = {};
        sendingData.cabId = cab.id;

        $.get(serviceUrl + "cab_retriever/getCab", sendingData, function (response) {
            cab.state(JSON.parse(response).data.state);
            console.log(JSON.parse(response).data.state);
        });
    };
    self.disableInputs = function () {
        $('button.cabAdd').css('display', 'none');
        $('button.cabManipulate').css('display', 'none');

        $('span.add-on').css('display', 'none');
        $('input').css('display', 'none')
    }


}

var locVM = new LocationBoardViewModel();
locVM.initializeLocationBoard();
ko.applyBindings(locVM);


//UI Plugins
$(document).ready(function () {
    $('.RowToClick').click(function () {
        $(this).nextAll('tr').each(function () {
            if ($(this).is('.RowToClick')) {
                return false;
            }
            $(this).toggle(350);
        });
    });
});

$("input.cabId").keyup(function (event) {
    if (event.keyCode == 13) {
        $(this).siblings("button").click();
    }
});