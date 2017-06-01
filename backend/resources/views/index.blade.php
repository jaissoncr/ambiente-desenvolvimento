<!doctype html>
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>MLTools</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic" rel="stylesheet" type="text/css">
        <!-- Needs images, font... therefore can not be part of main.css -->
        <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="vendor/weather-icons/css/weather-icons.min.css">
        <!-- end Needs images -->

            <link rel="stylesheet" href="styles/main.css">

    </head>
    <body data-ng-app="app"
          id="app"
          class="app"
          data-custom-page
          data-off-canvas-nav
          data-ng-controller="AppCtrl"
          data-ng-init="getAuthUser()"
          data-ng-class=" {'layout-boxed': admin.layout === 'boxed' } "
          >
        <!--[if lt IE 9]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <section data-ng-include=" 'views/header.html' " id="header" class="header-container" data-ng-class=" {'header-fixed': admin.fixedHeader} "></section>

        <div class="main-container">
            <aside data-ng-include=" 'views/sidebar.html' " id="nav-container" class="nav-container" data-ng-class=" {'nav-fixed': admin.fixedSidebar, 'nav-horizontal': admin.menu === 'horizontal', 'nav-vertical': admin.menu === 'vertical'}">
            </aside>

            <section data-ng-view id="content" class="content-container animate-fade-up"></section>
        </div>

        <!-- <script src="http://maps.google.com/maps/api/js?sensor=false"></script> -->
        <script src="scripts/vendor.js"></script>
        <script src="scripts/ui.js"></script>
        <script src="scripts/app.js"></script>
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-66923606-1', 'auto');
          ga('send', 'pageview');
        </script>
    </body>
</html>
