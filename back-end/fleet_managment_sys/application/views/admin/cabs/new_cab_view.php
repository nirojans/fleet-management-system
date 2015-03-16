<form role="form" id="createCab">
    <div class="form-group">
        <label for="plateNo">Plate Number</label>
        <input type="text" class="form-control" id="plateNo" placeholder="Enter Number">
    </div>
    <div class="form-group">
        <label for="model">Model</label>
        <input type="text" class="form-control" id="model" placeholder="Enter Model">
    </div>
    <div class="form-group">
        <label for="vType">Vehicle Type</label>
        <select class="form-control" id="vType">
            <option value="">*Please Select a Vahicle Type from the List</option>
            <option value="car">Car</option>
            <option value="van">Van</option>
            <option value="nano">Buddy</option>
        </select>
    </div>
    <div class="form-group">
        <label for="color">Color</label>
        <input type="text" class="form-control" id="color" placeholder="Enter Color">
    </div>
    <div class="form-group">
        <label for="info">Information</label>
        <input type="text" class="form-control" id="info" placeholder="Enter Info">
    </div>
    <button type="submit" class="btn btn-default" onclick="createNewCab(url, docs_per_page , page)">Save</button>
</form>



