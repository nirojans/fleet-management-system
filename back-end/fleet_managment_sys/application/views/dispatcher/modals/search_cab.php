<script>

    $(
        function () {

            function getCabSearchKey() {
                return $('#cabSearchKey').find("label.active input").val();
            }

            var cabs_search = new Bloodhound({
                datumTokenizer: function (d) {
                    return Bloodhound.tokenizers.whitespace(d.value);
                },
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: 'dispatcher/search_cabs/', //%QUERY/',
                    filter: function (results_cabs) {
                        results_cabs = JSON.parse(results_cabs);
                        $('#searchCabsContainer').empty();

                        return ($.map(results_cabs, function (result) {
                            createCabDom(result);
                            return {
                                value: result[searchAttribute],
                                cab: result
                            };
                        }));

                    },
                    replace: function (url, query) {
                        searchAttribute = getCabSearchKey();
                        url += encodeURIComponent(query);
                        url += '/';
                        url += encodeURIComponent(searchAttribute);
                        return url;
                    }

                }
            });


            cabs_search.initialize();
            $('#cabSearch').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, {
                name: 'name',
                displayKey: 'value',
                source: cabs_search.ttAdapter()
            }).on('typeahead:selected', function ($e, datum) {
                console.log(datum);
                $('#searchCabsContainer').empty();
                createCabDom(datum.cab);
            }).on('typeahead:change', function ($e, datum) {
                console.log($e);
                $('#searchCabsContainer').empty();
                createCabDom(datum.cab);
            });

            function createCabDom(cabJson) {

                var searchCabsContainer = $('#searchCabsContainer');

                var $tr = $('<tr>');
                var $tdCabId = $('<td>');
                $tdCabId.html(cabJson.cabId);
                $tr.append($tdCabId);

                var $tdPlateNo = $('<td>');
                $tdPlateNo.html(cabJson.plateNo);
                $tr.append($tdPlateNo);

                var $tdModel = $('<td>');
                $tdModel.html(cabJson.model);
                $tr.append($tdModel);

                var $tdColor = $('<td>');
                $tdColor.html(cabJson.color);
                $tr.append($tdColor);

                var $tdUserId = $('<td>');
                $tdUserId.html(cabJson.userId);
                $tr.append($tdUserId);

                var $tdZone = $('<td>');
                $tdZone.html(cabJson.zone);
                $tr.append($tdZone);

                var $tdInfo = $('<td>');
                $tdInfo.html(cabJson.info);
                $tr.append($tdInfo);

                searchCabsContainer.append($tr);
            }

        }
    );


</script>
<div class="modal-header"
     style="cursor: move;background: #f9f9f9;-webkit-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);-moz-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);">
    <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title text-center">
        <!-- TODO: Trigger bootstrap tooltip $('#aboutTileUrl').tooltip(); to enable tooltip -->
        Search Cab
    </h4>
</div>
<div class="modal-body">

    <div class="row">
        <div class="input-group input-group col-md-5 col-md-offset-4">
                <span class="input-group-addon" style="padding: 0px;margin: 0px;width: 180px;">
                <div id="cabSearchKey" data-toggle="buttons" class="btn-group btn-group-xs" role="group"
                     aria-label="Cab search">
                    <label class="btn btn-primary active">
                        <input type="radio" name="searchByCabId" value="cabId" autocomplete="off">ID
                    </label>
                    <label class="btn btn-primary">
                        <input type="radio" name="searchByCabModel" value="model" autocomplete="off">Model
                    </label>
                    <label class="btn btn-primary">
                        <input type="radio" name="searchByCabPlateNo" value="plateNo" autocomplete="off">Plate
                    </label>
                    <label class="btn btn-primary">
                        <input type="radio" name="searchByZone" value="zone" autocomplete="off">Zone
                    </label>

                    <!--                    <button id="searchByCabId" type="button" class="btn btn-default">ID</button>-->
                    <!--                    <button id="searchByCabModel" type="button" class="btn btn-default">Model</button>-->
                    <!--                    <button id="searchByCabPlateNo" type="button" class="btn btn-default">Driver</button>-->
                    <!--                    <button id="searchByZone" type="button" class="btn btn-default">zone</button>-->
                </div>
                </span>
            <input autofocus="true" id="cabSearch" type="text" class="form-control" placeholder="Search cabs"/>
                <span class="input-group-addon">
                <i id="resetSearch"
                   onclick="$('#searchCabsContainer').empty();/*$.each(unDispatchedOrders, function (i, order) {addNewOrder(order);});*/$('#cabSearch').val('');"
                   style="cursor: pointer;" class="fa fa-repeat"></i>
                </span>
        </div>
    </div>
    <div class="row" style="min-height: 100px">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Cab ID</th>
                <th>Plate No</th>
                <th>Model</th>
                <th>Color</th>
                <th>UserId</th>
                <th>Zone</th>
                <th>Info</th>
            </tr>
            </thead>
            <tbody id="searchCabsContainer">
            <?php foreach ($cabs as $cab): ?>
                <tr>
                    <td>
                        <?= $cab['cabId'] ?>
                    </td>
                    <td>
                        <?= $cab['plateNo'] ?>
                    </td>
                    <td>
                        <?= $cab['model'] ?>
                    </td>
                    <td>
                        <?= $cab['color'] ?>
                    </td>
                    <td>
                        <?php if(!isset($cab['userId']) || $cab['userId'] == -1){echo "Not Assigned";}else{echo $cab['userId']; }  ?>
                    </td>
                    <td>
                        <?php if(!isset($cab['zone'])){echo "Not Available";} else{echo $cab['zone'];} ?>
                    </td>
                    <td>
                        <?= $cab['info'] ?>
                    </td>
                </tr>
            <?php endforeach ?>


            </tbody>
        </table>
    </div>
    <div class="row">
        <div style="margin-bottom: -15px" class="btn-group btn-group-justified">
            <div class="btn-group">
                <button style="background-color: #f0ad4e;" type="button" class="btn btn-default" onclick="closeAll()">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>