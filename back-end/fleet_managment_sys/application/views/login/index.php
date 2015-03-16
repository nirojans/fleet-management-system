<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>H&aacute;o City Cabs System</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author"
          content="H&aacute;o City Cabs System"/>
    <meta name="description"
          content="Geo-Dashboard"/>
    <meta charset="UTF-8"/>
    <meta name="keywords"
          content="H&aacute;o City Cabs System,vehicle tracking system"/>

    <link rel="icon" type="image/x-icon" href="<?= base_url() ?>assets/img/favicon.ico">
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/login.css" rel="stylesheet" type="text/css"/>

    <script src="<?= base_url() ?>assets/js/jquery-2.1.1.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/login.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>

    <script>
        $(function(){
//            $('#commonModal').modal('toggle').find('.modal-content').load('<?//= site_url('notice/service_down')?>//');
        });
    </script>
    <!-- Moment libraries -->
    <script src="<?= base_url() ?>assets/js/moment/moment.js"></script>

</head>
<body id="body_first">
<div class="row fixer">
    <div class="col-md-6 col-md-offset-3 text-center">
        <h3> <i>H&aacute;o</i> City Cabs System </h3>
    </div>
    <div class="row fixer">
        <div class="col-md-8 col-md-offset-2 effect8" style="background-color: #F5EFD8;">
            <!-- TODO: Implement jagger equelent -->
            <?php if (!is_user_logged_in()) { ?>
                <div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                        &times;
                    </button>
                    <?=
                    print($this->session->userdata('error'));
                    ?>
                </div>
            <?php } ?>
            <br/>

            <div class="row fixer">
                <div class="col-md-10">
                    <?php
                    $attributes = array('class' => "form-horizontal", 'name' => "login", 'id' => "login_form");
                    echo form_open('login/authenticate', $attributes);
                    ?>
                    <div class="form-group">
                    <label for="login" class="col-sm-2 control-label">Username</label>

                    <div class="col-sm-10">
                        <input class="form-control" onkeyup="check_computer_number(this)" type="text" id="login"
                               name="username" required="required" placeholder="Username" autofocus/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">Password</label>

                    <div class="col-sm-10">
                        <input class="form-control" type="password" name="password" id="password"
                               required="required" placeholder="Password"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">
                            <i class="icon-user icon-white"></i> Sign in
                        </button>
                    </div>

                </div>
                </form>
                <!-- <img style="display: none" id="loading_image" src="<?= base_url() ?>assets/images/images/logins/login_loading.gif" /> -->
            </div>

            <div class="col-md-2" style="padding: 0px;">
                <img style="width: 100%" src="<?= base_url() ?>assets/img/hao-logo.png" id="Hao"/>
            </div>

        </div>

    </div>

</div>

</div>
<div class="modal" id="commonModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- This content is load by $.ajax call , pages are located at '/controllers/modals/' -->
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--commonModalLarger-->

<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
    <div class="container">
        <a class="navbar-brand" href="#">V 1.0.0</a>
    </div>
</nav>

</body>

</html>
