<head>
    <meta charset="utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

    <title>Dashboard - Analytics |
        Materio -
        Bootstrap 5 HTML + Laravel Admin Template</title>
    <meta name="description"
          content="Most Powerful &amp; Comprehensive Bootstrap 5 + Laravel HTML Admin Dashboard Template built for developers!"/>
    <meta name="keywords"
          content="dashboard, material, material design, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5">
    <!-- laravel CRUD token -->
    <meta name="csrf-token" content="AWM0dy6GxyF3Li6w5zpJLQzO3DeA2lhKfNmSxVzP">
    <!-- Canonical SEO -->
    <link rel="canonical" href="https://themeselection.com/item/materio-bootstrap-laravel-admin-template/">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon"
          href="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/img/favicon/favicon.ico"/>

    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;ampdisplay=swap"
          rel="stylesheet">

    <link rel="stylesheet"
          href="{{asset("demo/assets/vendor/fonts/materialdesigniconsc84d.css")}}?id=6dcb6840ed1b54e81c4279112d07827e"/>
    <link rel="stylesheet"
          href="{{asset("demo/assets/vendor/fonts/flag-icons80a8.css")}}?id=121bcc3078c6c2f608037fb9ca8bce8d"/>
    <link rel="stylesheet"
          href="{{asset("demo/assets/vendor/libs/node-waves/node-wavesd178.css")}}?id=aa72fb97dfa8e932ba88c8a3c04641bc"/>
    <!-- Core CSS -->
    <link rel="stylesheet"
          href="{{asset("demo/assets/vendor/css/rtl/cored2e5.css")}}?id=844d8848f059310b5530fe2f16a8521a"
          class="template-customizer-core-css"/>
    <link rel="stylesheet"
          href="{{asset("demo/assets/vendor/css/rtl/theme-default507d.css")}}?id=52fab3455fdcaff9f4acefe519ec216b"
          class="template-customizer-theme-css"/>
    <link rel="stylesheet" href="{{asset("demo/assets/css/demoe925.css")}}?id=e0dd12b480da2fee900cf30c26103f98"/>

    <link rel="stylesheet"
          href="{{asset("demo/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar02e6.css")}}?id=f83e2378d0545f439cbfea281f4852dd"/>
    <link rel="stylesheet"
          href="{{asset("demo/assets/vendor/libs/typeahead-js/typeahead2b79.css")}}?id=97b6e7a4d886c3d71a065c4b0d0d5f54"/>

    <!-- Vendor Styles -->
    <link rel="stylesheet" href="{{asset("demo/assets/vendor/libs/apex-charts/apex-charts.css")}}"/>

    <link rel="stylesheet"
          href="{{asset("demo/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar02e6.css")}}?id=f83e2378d0545f439cbfea281f4852dd"/>
    <link rel="stylesheet"
          href="{{asset("demo/assets/vendor/libs/typeahead-js/typeahead2b79.css")}}?id=97b6e7a4d886c3d71a065c4b0d0d5f54"/>

    <!-- Vendor Styles -->
    <link rel="stylesheet" href="{{asset("demo/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css")}}">
    <link rel="stylesheet"
          href="{{asset("demo/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css")}}">
    <link rel="stylesheet" href="{{asset("demo/assets/vendor/libs/flatpickr/flatpickr.css")}}"/>
    <link rel="stylesheet" href="{{asset('demo/assets/vendor/libs/toastr/toastr.css')}}" />
    <!-- Page Styles -->

    <!-- Include Scripts for customizer, helper, analytics, config -->
    <!-- $isFront is used to append the front layout scriptsIncludes only on the front layout otherwise the variable will be blank -->
    <!-- laravel style -->
    <script src="{{asset("demo/assets/vendor/js/helpers.js")}}"></script>
    <!-- beautify ignore:start -->
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{asset("demo/assets/vendor/js/template-customizer.js")}}"></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset("demo/assets/js/config.js")}}"></script>

    <script>
        window.templateCustomizer = new TemplateCustomizer({
            cssPath: '',
            themesPath: '',
            defaultStyle: "light",
            defaultShowDropdownOnHover: "true", // true/false (for horizontal layout only)
            displayCustomizer: "true",
            lang: 'en',
            pathResolver: function (path) {
                var resolvedPaths = {
                    // Core stylesheets
                    'core.css': '{{asset('demo/assets/vendor/css/rtl/core.css')}}',
                    'core-dark.css': '{{asset('demo/assets/vendor/css/rtl/core-dark.css')}}',

                    // Themes
                    'theme-default.css': 'https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/css/rtl/theme-default.css?id=52fab3455fdcaff9f4acefe519ec216b',
                    'theme-default-dark.css':
                        'https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/css/rtl/theme-default-dark.css?id=c8fd4937f51751cb21fc1b850985e28d',
                    'theme-bordered.css': 'https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/css/rtl/theme-bordered.css?id=2e360cd4013a77f41e5735180028af47',
                    'theme-bordered-dark.css':
                        'https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/css/rtl/theme-bordered-dark.css?id=0fd70b0f8c51077b53c94c534b6dea08',
                    'theme-semi-dark.css': 'https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/css/rtl/theme-semi-dark.css?id=7eb0cf231320db79df76c9cc343a9c64',
                    'theme-semi-dark-dark.css':
                        'https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/css/rtl/theme-semi-dark-dark.css?id=0d086bfea4ae48a5c1384981979967ac',
                }
                return resolvedPaths[path] || path;
            },
            'controls': ["rtl", "style", "headerType", "contentLayout", "layoutCollapsed", "layoutNavbarOptions", "themes"],
        });
    </script>
</head>
