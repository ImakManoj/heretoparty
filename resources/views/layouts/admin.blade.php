<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('public/img/admin/apple-icon.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('public/img/admin/favicon.png') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Meditation') }}</title>
    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <!-- Bootstrap core CSS     -->
    <link href="{{ asset('public/css/admin/bootstrap.min.css') }}" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.css" /> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" />
     <!--  Paper Dashboard core CSS    -->
    <link href="{{ asset('public/css/admin/paper-dashboard.css') }}" rel="stylesheet">
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="{{ asset('public/css/admin/demo.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <!--  Fonts and icons     -->
    <link href="{{ asset('public/css/admin/themify-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fonts/admin/themify.woff') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <!-- For Sidebar -->
        @include('common.sidebar')
        <div class="main-panel">
            <!-- For Nav/Header -->
            @include('common.header')
            <!-- Render all page -->
            @yield('content')
            <!-- For Footer -->
            @include('common.footer')
        </div>
    </div>
</body>
<!-- Scripts -->
<!-- <script src="{{ asset('js/admin/jquery-3.1.1.min.js') }}" defer></script> -->
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="{{ asset('public/js/admin/jquery-ui.min.js') }}" defer></script>
<script src="{{ asset('public/js/admin/perfect-scrollbar.min.js') }}" defer></script>
<script src="{{ asset('public/js/admin/bootstrap.min.js') }}" defer></script>

<!--  Forms Validations Plugin -->
<script src="{{ asset('public/js/admin/es6-promise-auto.min.js') }}" defer></script>
<script src="{{ asset('public/js/admin/moment.min.js') }}" defer></script>
<script src="{{ asset('public/js/admin/bootstrap-datetimepicker.js') }}" defer></script>
<script src="{{ asset('public/js/admin/bootstrap-selectpicker.js') }}" defer></script>
<script src="{{ asset('public/js/admin/bootstrap-switch-tags.js') }}" defer></script>
<script src="{{ asset('public/js/admin/jquery.easypiechart.min.js') }}" defer></script>
<script src="{{ asset('public/js/admin/chartist.min.js') }}" defer></script>
<script src="{{ asset('public/js/admin/bootstrap-notify.js') }}" defer></script>
<script src="{{ asset('public/js/admin/sweetalert2.js') }}" defer></script>
<script src="{{ asset('public/js/admin/jquery-jvectormap.js') }}" defer></script>

<!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> -->
<script src="{{ asset('public/js/admin/jquery.bootstrap.wizard.min.js') }}" defer></script>
<script src="{{ asset('public/js/admin/bootstrap-table.js') }}" defer></script>
<script src="{{ asset('public/js/admin/jquery.datatables.js') }}" defer></script>
<script src="{{ asset('public/js/admin/fullcalendar.min.js') }}" defer></script>
<script src="{{ asset('public/js/admin/paper-dashboard.js') }}" defer></script>
<script src="{{ asset('public/js/admin/demo.js') }}" defer></script>

<script type="text/javascript">
    // $(document).ready(function(){
    //     demo.checkFullPageBackgroundImage();

    //     setTimeout(function(){
    //         // after 1000 ms we add the class animated to the login/register card
    //         $('.card').removeClass('card-hidden');
    //     }, 700)
    // });
</script>

<script type="text/javascript">
    $(document).ready(function() {

        $('.table').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            responsive: true,
            language: {
            search: "_INPUT_",
                searchPlaceholder: "Search records",
            }
        });


        var table = $('.table').DataTable();
         // Edit record
         table.on( 'click', '.edit', function () {
            $tr = $(this).closest('tr');

            var data = table.row($tr).data();
            alert( 'You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.' );
         } );

         // Delete a record
         table.on( 'click', '.remove', function (e) {
            $tr = $(this).closest('tr');
            table.row($tr).remove().draw();
            e.preventDefault();
         } );

        //Like record
        table.on( 'click', '.like', function () {
            alert('You clicked on Like button');
         });

    });
</script>


    <!-- include summernote css/js-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>    
 

<script>
    //js for jquery validation
    $(document).ready(function () {

        $('#add_form').validate({ // initialize the plugin
            rules: {
                name: {
                    required: true,
                    normalizer: function (value) {
                        //Trim the value of element for whitespaces
                        return $.trim(value);
                    }
                },
                subtitle: {
                    required: true,
                    normalizer: function (value) {
                        //Trim the value of element for whitespaces
                        return $.trim(value);
                    }
                },
                description: {
                    required: true,
                    normalizer: function (value) {
                        //Trim the value of element for whitespaces
                        return $.trim(value);
                    }
                }
            },
            message: {
                name:{
                    required: true,
                },
            }
        });

    });

    //js for summernote
    $(document).ready(function() {
        $('.summernote').summernote();
    });

     $(document).ready(function() {
        //initialize summernote
        $('.summernote').summernote();

        //assign the variable passed from controller to a JavaScript variable.
        var content = '<?php echo isset($data->description) ? json_encode(@$data->description) : '' ?>';

        //set the content to summernote using `code` attribute.
        $('.summernote').summernote('code', content);
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script> -->
<script type="text/javascript">
$('.ui.dropdown').dropdown();
    
</script>

</html>
