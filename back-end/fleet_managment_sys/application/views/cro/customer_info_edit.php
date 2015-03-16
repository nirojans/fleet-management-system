<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Customer Information</h3>
    </div>
    <div class="panel-body" >
        <form  class="form-inline" role="form" >
            <select class="form-control" id="title">Select a Title
                <option value="-"    <?php if($title == '-')echo 'selected';?> >Title</option>
                <option value="Ms"   <?php if($title == 'Ms')echo 'selected';?>>Ms</option>
                <option value="Miss" <?php if($title == 'Miss')echo 'selected';?>>Miss</option>
                <option value="Mrs"  <?php if($title == 'Mrs')echo 'selected';?>>Mrs</option>
                <option value="Mr"   <?php if($title == 'Mr')echo 'selected';?>>Mr</option>
                <option value="Rev"  <?php if($title == 'Rev')echo 'selected';?>>Rev</option>
                <option value="Doc"  <?php if($title == 'Doc')echo 'selected';?>>Doc</option>
            </select>

            <select id="position" class="form-control">
                <option value="-"   <?php if($title == '-')echo 'selected';?>>Position</option>
                <option value="Dig" <?php if($title == 'Dig')echo 'selected';?>>Dig</option>
                <option value="Mag" <?php if($title == 'Mag')echo 'selected';?>>Mag</option>
                <option value="Col" <?php if($title == 'Col')echo 'selected';?>>Col</option>
            </select>

            <select id="profileType" class="form-control">
                <option value="Personal"   <?php if($profileType == 'Personal')echo 'selected';?>>Personal</option>
                <option value="Cooperate" <?php if($profileType == 'Cooperate')echo 'selected';?>>Cooperate</option>
            </select>
        </form>

        <form role="form" id="editCustomer" class="customerForm">
            <div class="form-group">
                <label for="tp">Telephone Number</label>
                <input type="text" class="form-control" id="tp" placeholder="Telephone Number" value="<?= $tp?>">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" id="type1" <?php if($type1 == 'land')echo 'checked';?>> Land
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="tp2">Telephone Number 2</label>
                <input type="text" class="form-control" id="tp2" placeholder="Telephone Number" value="<?= $tp2?>">
                <div class="checkbox">
                    <label>
                        <input  id="type2" type="checkbox" <?php if($type2 == 'land')echo 'checked';?>> Land
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="cusName">Customer Name</label>
                <input type="text" class="form-control" id="cusName" placeholder="Customer Name" value="<?= $name?>">
            </div>
            <div class="form-group">
                <label for="pRemark">Permanent Remark</label>
                <input type="text" class="form-control" id="pRemark" placeholder="Permanent Remark" value="<?= $pRemark?>">
            </div>
            <div class="form-group">
                <label for="organization">Organization</label>
                <input type="text" class="form-control" id="organization" placeholder="Organization Name" value="<?= $org?>">
            </div>
            <button type="submit" class="btn btn-default" onclick="operations('updateCusInfo');return false;" onsubmit="operations('updateCusInfo');return false;">Save</button>
        </form>

    </div>
</div>
