<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Customer Information</h3>
    </div>
    <div class="panel-body" >
        <form  class="form-inline" role="form" >
            <select class="form-control" id="title">Select a Title
                <option selected value="-">Title</option>
                <option value="Ms">Ms</option>
                <option value="Miss">Miss</option>
                <option value="Mrs">Mrs</option>
                <option value="Mr">Mr</option>
                <option value="Rev">Rev</option>
                <option value="Doc">Doc</option>
            </select>

            <select id="position" class="form-control">
                <option selected value="-">Position</option>
                <option value="Dig">Dig</option>
                <option value="Mag">Mag</option>
                <option value="Col">Col</option>
            </select>

            <select id="profileType" class="form-control">
                <option selected value="Personal">Personal</option>
                <option value="Cooperate">Cooperate</option>
            </select>
        </form>

        <form role="form" id="newCustomer" class="customerForm">
            <div class="form-group">
                <label for="tp">Telephone Number</label>
                <input type="text" class="form-control" id="tp" placeholder="Telephone Number" value="<?= $tp?>">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" id="type1" > Land
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="tp2">Telephone Number 2</label>
                <input type="text" class="form-control" id="tp2" placeholder="Telephone Number" >
                <div class="checkbox">
                    <label>
                        <input  id="type2" type="checkbox"> Land
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="cusName">Customer Name</label>
                <input type="text" class="form-control" id="cusName" placeholder="Customer Name" >
            </div>
            <div class="form-group">
                <label for="pRemark">Permanent Remark</label>
                <input type="text" class="form-control" id="pRemark" placeholder="Permanent Remark" >
            </div>
            <div class="form-group">
                <label for="organization">Organization</label>
                <input type="text" class="form-control" id="organization" placeholder="Organization Name">
            </div>
            <input type="submit" class="btn btn-default" onclick="operations('createCusInfo');return false" onsubmit="operations('createCusInfo');return false" value="Submit" />

        </form>
    </div>
</div>

