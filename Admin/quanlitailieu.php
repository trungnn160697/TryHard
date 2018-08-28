<?php
  include '../haudeptrai.php';
  session_start();
  if (!currentUserIsAdmin()){
    header('Location: ../');
    exit(0);
  }
  
  $query = 'SELECT * FROM _user WHERE username = :user';
  $data = array(':user'=> $_SESSION['user']);
  $result = getSQLData($query, $data);
  $user = $result[0];
  
  $tin_nhan_chua_doc = getSQLData('SELECT count(id) count FROM message WHERE read = 0')[0]['count'];


    $docCountInOnePage = 6;
    $maxPageCountInOneSection = 3;

    if(isset($_GET['page'])){
      $page = intval($_GET['page']);
    }else{
      $page = 1;
    }
    if ($page == 0) {
      $page = 1;
    }
    $getDocCountQuery = "SELECT count(mstl) as count FROM tailieu WHERE upper(tentl) LIKE upper(:partname)";
    $data = array(':partname' => getSearchKey('%') . '%' );
    $docCountSet = getSQLData($getDocCountQuery, $data);
    $totalDocCount = intval($docCountSet[0]['count']);

    // Tính page đầu đầu của section chứa page hiện tại
    $firstPageOfSection = $page - (($page - 1) % $maxPageCountInOneSection);
    $pageCountOfSection = $maxPageCountInOneSection;

    while (($firstPageOfSection + $pageCountOfSection - 2) * $docCountInOnePage >= $totalDocCount)
      $pageCountOfSection--;
    $isLastSection = (($firstPageOfSection + $maxPageCountInOneSection -1) * $docCountInOnePage >= $totalDocCount);
    $sectionInfo = array( 'maxPageCountInOneSection' => $maxPageCountInOneSection,
                'firstPageOfSection' => $firstPageOfSection,
                'pageCountOfSection' => $pageCountOfSection,
                'isLastSection'    => $isLastSection);

    

    $query =  'SELECT mstl, tentl, tailieu.username, hoten, luottai, rate
          FROM tailieu, _user
          WHERE tailieu.username = _user.username AND upper(tentl) LIKE upper(:partname)
          LIMIT :limit_count OFFSET :off_set';
    $data1 = array(':partname' => getSearchKey('%').'%',
                  ':limit_count' => intval($docCountInOnePage),
                  ':off_set'  => ($page - 1) * $docCountInOnePage );
    $docsData = getSQLData($query, $data1);

    // $responseData = array(  'info'  => $sectionInfo,
    //             'data'  => $resultSet );
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Quản lí tài liệu</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Date Picker -->
    <link href="plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="quanlinguoidung.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
  </head>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="../" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <!-- <span class="logo-mini"><b>A</b>LT</span> -->
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>BYGTRYM</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <li class="dropdown messages-menu" style="display: none;">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-envelope-o"></i>
                  <span class="label label-success">4</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 4 messages</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li><!-- start message -->
                        <a href="#">
                          <div class="pull-left">
                            <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
                          </div>
                          <h4>
                            Support Team
                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li><!-- end message -->
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image" />
                          </div>
                          <h4>
                            AdminLTE Design Team
                            <small><i class="fa fa-clock-o"></i> 2 hours</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image" />
                          </div>
                          <h4>
                            Developers
                            <small><i class="fa fa-clock-o"></i> Today</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image" />
                          </div>
                          <h4>
                            Sales Department
                            <small><i class="fa fa-clock-o"></i> Yesterday</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image" />
                          </div>
                          <h4>
                            Reviewers
                            <small><i class="fa fa-clock-o"></i> 2 days</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="footer"><a href="#">See All Messages</a></li>
                </ul>
              </li>
              <!-- Notifications: style can be found in dropdown.less -->
              <li class="dropdown notifications-menu" style="display: none;">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning">10</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 10 notifications</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li>
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i> 5 new members joined today
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the page and may cause design problems
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-users text-red"></i> 5 new members joined
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-user text-red"></i> You changed your username
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="footer"><a href="#">View all</a></li>
                </ul>
              </li>
              <!-- Tasks: style can be found in dropdown.less -->
              <li class="dropdown tasks-menu">
               
                <ul class="dropdown-menu">
                  <li class="header">You have 9 tasks</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    
                  </li>
                  <li class="footer">
                    <a href="#">View all tasks</a>
                  </li>
                </ul>
              </li>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../avarta/<?php echo $user['image'];?>" class="user-image" alt="User Image" />
                  <span class="hidden-xs"><?php echo $user['hoten']?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <!-- <li class="user-header">
                    <img src="" class="img-circle" alt="User Image" />
                    <p>
                      Alexander Pierce - Web Developer
                      <small>Member since Nov. 2012</small>
                    </p>
                  </li> -->
                  <!-- Menu Body -->
                  <li class="user-body" style="display: none;">
                    <div class="col-xs-4 text-center">
                      <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Friends</a>
                    </div>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="../chitietnguoidung.html?username=<?php echo($user['username']);?>" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="../logout.php" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="../avarta/<?php echo $user['image'];?>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p><?php echo $user['hoten']?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search..." />
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="treeview">
              <a href="Admin.php">
                <i class="fa fa-table"></i> <span>Trang quản lý</span>
              </a>
            </li>
            <li class="treeview">
              <a href="quanlitailieu.php">
                <i class="fa fa-table"></i> <span>Quản lý tài liệu</span>
              </a>
            </li>
            <li class="treeview">
              <a href="quanlinguoidung.php">
                <i class="fa fa-table"></i> <span>Quản lý người dùng</span>
              </a>
            </li>
            <li class="treeview">
              <a href="quanlitinnhan.php">
                <i class="fa fa-table"></i> <span>Tin nhắn</span><span style="color: red;">
                  <?php if($tin_nhan_chua_doc !=0)echo" (" . $tin_nhan_chua_doc . ")"; ?>
                </span>
                <!-- <i class="fa fa-angle-left pull-right"></i> -->
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Quản lý
          </h1>
          <ol class="breadcrumb">
            <li><a href="../"><i class="fa fa-dashboard"></i>Trang chủ</a></li>
            <li class="active"><a href="Admin.php">Dashboard</a> > Quản lí tài liệu</li>
          </ol>
        </section>

        <!-- Main content -->
            <section class="col-lg-12 connectedSortable">
              <form action="#" method="get" accept-charset="utf-8">
                <div class="text-search-quanli">
                  
                    <div class="col-xs-10"><input type="text" name="q" id="input" class="form-control" placeholder="Search" ></div>
                    <div class="col-xs-2" style=""><button type="submit" class="btn button_text_search"><i class="fa fa-search" aria-hidden="true"></i></button></div>
                </div>
                <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Mã tài liệu</th>
                    <th>Tên tài liệu</th>
                    <th>Người đăng</th>
                    <th ><span style="margin-right: 5px">Lượt tải</span><!-- <a href=""><i class="fa fa-sort-desc" aria-hidden="true"></i></a><a href=""><i class="fa fa-sort-asc" aria-hidden="true"></i></a> --></th>
                    <th ><span style="margin-right: 5px">Rate</span><!-- <a href=""><i class="fa fa-sort-desc" aria-hidden="true"></i></a><a href=""><i class="fa fa-sort-asc" aria-hidden="true"></i></a> --></th>
                    <th>Xóa</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($docsData as $doc) {
                    # code...
                    echo '<tr>'.
                       '<td><a href="../chitiettailieu.html?id=' .$doc['mstl'] .'">' .$doc['mstl'] .'</a></td>'.
                       '<td><a href="../chitiettailieu.html?id=' .$doc['mstl'] .'">' .$doc['tentl'] .'</a></td>'.
                       '<td><a href="../chitietnguoidung.html?username=' .$doc['username'] .'">' .$doc['hoten'] .'</a></td>'.
                       '<td>' .$doc['luottai'] .'</td>'.
                       '<td>' .$doc['rate'] .'</td>'.
                       '<td><button type="button"  data-toggle="modal" data-target="#delModal" id="button_delete" data-tentl="' .
                       $doc['tentl'] .'" data-mstl="' .
                       $doc['mstl'] .'" ><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>'.
                     '</tr>';
                  }
                  //id="button_delete"
                  ?>
                </tbody>
              </table>
              <script type="text/javascript">
                $('button[data-target=#delModal]').click(function(arg) {
                 $('#doc-name').html($(this).attr('data-tentl'));
                 $('#real-delete').attr('data-value', $(this).attr('data-mstl'));
                })
              </script>
              <div style="text-align: center;">
                <ul class="pagination">
                   <?php

                  if($firstPageOfSection > $pageCountOfSection && $pageCountOfSection > 0)
                    echo '<li><a href="quanlitailieu.php?page=' . ($firstPageOfSection - $pageCountOfSection) . getSearchKey('&q='). '">&laquo;</a></li>';
                   for ($i= $firstPageOfSection; $i < $firstPageOfSection + $pageCountOfSection; $i++) { 
                    echo '<li ' . (($i == $page)?'class="active"':'') .'><a href="quanlitailieu.php?page=' . $i .getSearchKey('&q=').'">'. $i .'</a></li>';
                   }
                   if(!$isLastSection)
                    echo '<li><a href="quanlitailieu.php?page=' . ($firstPageOfSection + $pageCountOfSection) .getSearchKey('&q='). '">&raquo;</a></li>';
                  ?>
                </ul>
              </div>
              </form>
            </section><!-- right col -->
          </div><!-- /.row (main row) -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 20171
        </div>
        <strong>Copyright &copy; 20171 <a href="http://almsaeedstudio.com">bygtrym.ml</a>.</strong> Desginer NNT.
      </footer>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
          <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
          <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                    <p>Will be 23 on April 24th</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-user bg-yellow"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
                    <p>New phone +1(800)555-1234</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
                    <p>nora@example.com</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-file-code-o bg-green"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
                    <p>Execution time 5 seconds</p>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Custom Template Design
                    <span class="label label-danger pull-right">70%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Update Resume
                    <span class="label label-success pull-right">95%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Laravel Integration
                    <span class="label label-warning pull-right">50%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Back End Framework
                    <span class="label label-primary pull-right">68%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

          </div><!-- /.tab-pane -->
          <!-- Stats tab content -->
          <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
          <!-- Settings tab content -->
          <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
              <h3 class="control-sidebar-heading">General Settings</h3>
              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Report panel usage
                  <input type="checkbox" class="pull-right" checked />
                </label>
                <p>
                  Some information about this general settings option
                </p>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Allow mail redirect
                  <input type="checkbox" class="pull-right" checked />
                </label>
                <p>
                  Other sets of options are available
                </p>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Expose author name in posts
                  <input type="checkbox" class="pull-right" checked />
                </label>
                <p>
                  Allow the user to show his name in blog posts
                </p>
              </div><!-- /.form-group -->

              <h3 class="control-sidebar-heading">Chat Settings</h3>

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Show me as online
                  <input type="checkbox" class="pull-right" checked />
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Turn off notifications
                  <input type="checkbox" class="pull-right" />
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Delete chat history
                  <a href="javascript::;" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                </label>
              </div><!-- /.form-group -->
            </form>
          </div><!-- /.tab-pane -->
        </div>
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script type="text/javascript">
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="plugins/morris/morris.min.js" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- jQuery Knob Chart -->
    <script src="plugins/knob/jquery.knob.js" type="text/javascript"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js" type="text/javascript"></script>
    <script src="plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <!-- datepicker -->
    <script src="plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    <!-- Slimscroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard.js" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js" type="text/javascript"></script>
    <div id="delModal"  class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Xác nhận xóa</h4>
          </div>
          <div class="modal-body">
            <p>Bạn thực sự muốn xóa tài liệu <span id="doc-name"></span></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Thôi</button>
            <button type="button" id="real-delete" class="btn btn-primary" data-value="">Xóa</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script type="text/javascript">
      $('#real-delete').on('click', function(){
        $.ajax({url: '../delete.php?mstl='+$(this).attr('data-value'), success: function(result){
            if (result == '1') {
              //success
              location.reload();
            }else{
              //error
              console.log(result);
            }
        }});
      });
    </script>
  </body>
</html>
