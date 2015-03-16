
var Numbers =[];

var baseUrl = ApplicationOptions.constance.BASE_URL;

var serviceUrl = baseUrl;


function TelNumber(data){
    this.timeStamp = data.time;
    this.number = data.number;
    this.state = data.state;
    var time = new Date(this.timeStamp*1000);
    this.readableTimeStamp = time.getHours()+" : "+time.getMinutes()+" : "+time.getSeconds();


}
data1 = {};
data1.timeStamp = 1416478557;
data1.number = 94312233926;
data1.state = "LIVE";


var Number1 = new TelNumber(data1);

data2 = {};
data2.timeStamp = 23432432432;
data2.number = 213214324234;
data2.state = "LIVE";
var Number2 = new TelNumber(data1);

data3 = {};
data3.timeStamp = 2343232423;
data3.number = 23432432423;
data3.state = "LIVE";
var Number3 = new TelNumber(data3);

Numbers.push(Number1);
Numbers.push(Number2);
Numbers.push(Number3);



var ViewModelCro = function(){
    var self = this;
    self.currentNumbers = ko.observableArray([]);


    self.updateNumbers = function () {

        var buffer = self.currentNumbers();
        self.currentNumbers.removeAll();
        //http://localhost/fleet/back-end/fleet_managment_sys/index.php/call/getLiveCalls
        ///Insert Logic to get data from DB



        $.ajax({
            url: serviceUrl + "call/getCallsInLastSeconds",
            type: "GET",
            dataType: "json"
        }).done(function( response ) {
            for(var callKey in response){
                var call = response[callKey];
                var number = new TelNumber(call);
                self.currentNumbers.push(number);
            }

        }).fail(function( jqXHR, textStatus ) {
            console.log( "Data transfer failed: " + textStatus );
        });


    };

    self.assignNumber = function (data) {
        //self.currentNumbers.remove(data);
        $('input#tpSearch').val(data.number);
        operations("getCustomerFromPABX", data.number);

    }

};
var croVM = new ViewModelCro();
ko.applyBindings(croVM);