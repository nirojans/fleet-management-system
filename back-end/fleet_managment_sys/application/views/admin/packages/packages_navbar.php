<nav class="navbar navbar-default" role="navigation" style="margin-bottom: 0px">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <a class="navbar-brand" href="#">Hao Cabs Admin Panel</a>
    </div>

    <ul class="nav navbar-nav">
        <li><a href="#" onclick="getCabsDefaultView( '<?php echo site_url();?>', docs_per_page , page)">Cabs</a></li>
        <li><a href="#" id="driver" onclick="getCROsView(this.id)">Drivers</a></li>
        <li><a href="#" id="dispatcher" onclick="getCROsView(this.id)">Dispatcher</a></li>
        <li><a href="#" id="cro" onclick="getCROsView(this.id)">CRO</a></li>
        <li><a href="#" id="reports" onclick="getReportsView(this.id)">Reports</a></li>
        <li  class="active"><a href="#" id="packages" onclick="getPackagesView(this.id)">Packages</a></li>
    </ul>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <form class="navbar-form navbar-left" role="search" id="getAccount">
            <div class="form-group">
                <input class="form-control" placeholder="Package ID" type="text" id="packageIdSearch">
            </div>
            <button type="submit" class="btn btn-default" onclick="getPackagesViewByPackageId();return false;"
                    onsubmit="getPackagesViewByPackageId();return false;">Submit</button>
        </form>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="<?= site_url('login/logout')?>">Logout</a></li>
        </ul>
    </div><!-- /.navbar-collapse -->
</nav>