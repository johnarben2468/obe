<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>OBE - Online System for Higher Learning Institutions</title>

    <!-- Bootstrap Core CSS -->
	{{ HTML::style('../bower_components/bootstrap/dist/css/bootstrap.min.css') }}

    <!-- MetisMenu CSS -->
	{{ HTML::style('../bower_components/metisMenu/dist/metisMenu.min.css') }}

    <!-- Timeline CSS -->
	{{ HTML::style('../dist/css/timeline.css') }}

    <!-- Custom CSS -->
	{{ HTML::style('../dist/css/sb-admin-2.css') }}

    <!-- Morris Charts CSS -->
	{{ HTML::style('../bower_components/morrisjs/morris.css') }}

    <!-- Custom Fonts -->
	{{ HTML::style('../bower_components/font-awesome/css/font-awesome.min.css') }}

    <!-- DataTables CSS -->
    {{ HTML::style('../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}
    <!-- DataTables Responsive CSS -->
    {{ HTML::style('../bower_components/datatables-responsive/css/dataTables.responsive.css') }}
    
   
    {{ HTML::style('../chosen.css') }}

  <style type="text/css" media="all">
    /* fix rtl for demo */
    .chosen-rtl .chosen-drop { left: -9000px; }
  </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
		{{ HTML::script('https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js') }}
		{{ HTML::script('https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js') }}
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">OBE</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        @if(Auth::user()->user_type=="admin")
                        <li><a href="/admin/settings"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        @endif
                        <li class="divider"></li>
                        <li><a href="/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        
                        <li>
                            <a href="/"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        @if(Auth::user()->user_type=="admin")
                        <li>
                            <a href="/admin/departments"><i class="fa fa-table fa-fw"></i> Departments</a>
                        </li>
                        <li>
                            <a href="/admin/programs"><i class="fa fa-edit fa-fw"></i> Programs</a>
                        </li>
                        <li>
                            <a href="/admin/courses"><i class="fa fa-edit fa-fw"></i> Courses</a>
                        </li>
                        @endif
                    
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">@yield("header")</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
           
			@yield("content")
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
	{{ HTML::script('../bower_components/jquery/dist/jquery.min.js') }}


    <!-- Bootstrap Core JavaScript -->
	{{ HTML::script('../bower_components/bootstrap/dist/js/bootstrap.min.js') }}


    <!-- Metis Menu Plugin JavaScript -->
	{{ HTML::script('../bower_components/metisMenu/dist/metisMenu.min.js') }}


    <!-- Morris Charts JavaScript -->
	{{ HTML::script('../bower_components/raphael/raphael-min.js') }}
	{{ HTML::script('../bower_components/morrisjs/morris.min.js') }}
	{{ HTML::script('../js/morris-data.js') }}

    <!-- DataTables JavaScript -->
    {{ HTML::script('../bower_components/datatables/media/js/jquery.dataTables.min.js') }}
    {{ HTML::script('../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js') }}


  
    <!-- Custom Theme JavaScript -->
	{{ HTML::script('../dist/js/sb-admin-2.js') }}

    {{ HTML::script('../chosen.jquery.js') }}
    
    <script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
    </script>

    @yield('dialogs')

</body>

</html>
