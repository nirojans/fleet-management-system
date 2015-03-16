<form role="form" id="createDriver">
    <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" class="form-control" id="name" placeholder="Enter Full Name">
    </div>
    <div class="form-group">
        <label for="uName">User Name</label>
        <input type="text" class="form-control" id="uName" placeholder="Enter User Name">
    </div>
    <div class="form-group">
        <label for="pass">PassWord</label>
        <input type="text" class="form-control" id="pass" placeholder="Enter PassWord">
    </div>
    <div class="form-group">
        <label for="nic">NIC Number</label>
        <input type="text" class="form-control" id="nic" placeholder="Enter NIC Number">
    </div>
    <div class="form-group">
        <label for="tp">Telephone Number</label>
        <input type="text" class="form-control" id="tp" placeholder="Enter Telephone Number">
    </div>
    <div class="form-group">
        <label for="cabIdAssigned">Cab ID</label>
        <select class="form-control" id="cabId" >
            <option value="-1" selected="">Assign Later</option>
            <?php            
            foreach($cab_ids as $cabId){echo '<option value="'.$cabId['cabId'].'">'.$cabId['cabId'].'</option>';$i++;}
            ?>
            
        </select>
    </div>
    <button type="submit" id="driver" class="btn btn-default" onclick="createNewCRO(this.id);return false;"
            onsubmit="createNewCRO(this.id);return false;">Save</button>
</form>