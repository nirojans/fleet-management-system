<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Big Data Analysis</title>

    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url() ?>assets/img/favicon-76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url() ?>assets/img/favicon-120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url() ?>assets/img/favicon-152.png">

    <link rel="icon" sizes="196x196" href="<?= base_url() ?>assets/img/favicon-196.png">
    <link rel="icon" type="image/x-icon" href="<?= base_url() ?>assets/img/favicon.ico">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="<?= base_url() ?>assets/css/uikit/uikit.min.css"/>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/uikit/addons/uikit.addons.min.css"/>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery-ui.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery-ui.theme.min.css">

    <!-- C3 chart library styles-->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/d3/c3.css">

    <script src="<?= base_url() ?>assets/js/jquery-2.1.1.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery-ui.min.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>

    <!-- C3 charting library using D3 core -->
    <script src="<?= base_url() ?>assets/js/d3/d3.min.js"></script>
    <script src="<?= base_url() ?>assets/js/d3/c3.min.js"></script>

    <!-- UIkit libraries -->
    <script src="<?= base_url() ?>assets/js/uikit/uikit.min.js"></script>
    <script src="<?= base_url() ?>assets/js/uikit/addons/notify.min.js"></script>

    <script src="<?= base_url() ?>assets/js/application_options.js"></script>

</head>
<body>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Data Stats</h3>
    </div>
    <div class="panel-body">
        <table class="table">
            <tbody>
            <tr>
                <th scope="row">Collection Name</th>
                <td>
                    <?= $data_stats["ns"] ?>
                </td>
            </tr>

            <tr>
                <th scope="row">Data Count</th>
                <td>
                    <?= $data_stats["count"] ?>
                </td>
            </tr>
            <tr>
                <th scope="row">Size in bytes</th>
                <td>
                    <?= $data_stats["size"] ?>
                </td>
            </tr>
            <tr>
                <th scope="row">Storage size in bytes</th>
                <td>
                    <?= $data_stats["storageSize"] ?>
                </td>
            </tr>
            <tr>
                <th scope="row">Total index size</th>
                <td>
                    <?= $data_stats["totalIndexSize"] ?>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
