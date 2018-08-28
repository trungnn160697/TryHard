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

    $messageCountInOnePage = 3;
    $maxPageCountInOneSection = 3;

    if(isset($_GET['page'])){
      $page = intval($_GET['page']);
    }else{
      $page = 1;
    }
    if ($page == 0) {
      $page = 1;
    }
    $getMessageCountQuery = "SELECT count(id) as count FROM message WHERE upper(mss) LIKE upper(:partname) OR upper(email) LIKE upper(:partname)";
    $data = array(':partname' => getSearchKey('%') . '%' );
    $messageCountSet = getSQLData($getMessageCountQuery, $data);
    $totalMessageCount = intval($messageCountSet[0]['count']);

    // Tính page đầu đầu của section chứa page hiện tại
    $firstPageOfSection = $page - (($page - 1) % $maxPageCountInOneSection);
    $pageCountOfSection = $maxPageCountInOneSection;

    while (($firstPageOfSection + $pageCountOfSection - 2) * $messageCountInOnePage >= $totalMessageCount)
      $pageCountOfSection--;
    $isLastSection = (($firstPageOfSection + $maxPageCountInOneSection -1) * $messageCountInOnePage >= $totalMessageCount);
    $sectionInfo = array( 'maxPageCountInOneSection' => $maxPageCountInOneSection,
                'firstPageOfSection' => $firstPageOfSection,
                'pageCountOfSection' => $pageCountOfSection,
                'isLastSection'    => $isLastSection);

    

    $query =  'SELECT *
              FROM message
              WHERE upper(mss) LIKE upper(:partname) OR upper(email) LIKE upper(:partname)
              ORDER BY senttime DESC
              LIMIT :limit_count OFFSET :off_set';
    $data1 = array(':partname' => getSearchKey('%').'%',
                  ':limit_count' => intval($messageCountInOnePage),
                  ':off_set'  => ($page - 1) * $messageCountInOnePage );
    $messagesData = getSQLData($query, $data1);

    getSQLData('UPDATE message SET read = 1');
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Quản lí tin nhắn</title>
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
                    <img src="../images/anh1.jpg" class="img-circle" alt="User Image" />
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
                <i class="fa fa-table"></i> <span>Tin nhắn</span>
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
            <li class="active"><a href="Admin.php">Dashboard</a> > Quản lí tin nhắn</li>
          </ol>
        </section>

        <!-- Main content -->
            <section class="col-lg-12 connectedSortable">
                <div class="main-quanli" style="width: 100%">
                    <div class="text-search-quanli">
                      <form action="" method="get" accept-charset="utf-8">
                        <div class="col-xs-10" style=""><input type="text" name="q" id="input" class="form-control"  title="" placeholder="Search" >
                        </div>
                        <div class="col-xs-2" style=""><button type="submit" class="btn button_text_search"><i class="fa fa-search" aria-hidden="true"></i></button></div>
                      </form>
                    </div>
                    <table class="table table-striped" style="width: 100%;">
                        <thead>
                          <tr>
                            <th style="width: 20%">Email</th>
                            <th style="width: 50%">Tin nhắn</th>
                            <th><span>Thời gian</span></th>
                            <th>Xóa</th>
                            <th>Reply</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          foreach ($messagesData as $mss) {
                            
                          echo '<tr>'.
                            '<td><a href="">' . $mss['email'] . '<br><small>(' . $mss['fullname']  .')</small></a></td>'.
                            '<td><a href="">' . $mss['mss'].'</a></td>'.
                            '<td><a href="">' . reformatDate($mss['sentdate']) .'</a></td>'.
                            '<td><button type="button" id="button_delete" data-toggle="modal" data-target="#delModal"  data-email="' .
                               $mss['email'] .'" data-id="' .
                               $mss['id'] .'"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>'.
                            '<td><button type="button" id="button_reply"  data-email="' .
                               $mss['email'] .'" data-fullname="' .
                               $mss['fullname'] .'" data-toggle="modal" href="#modal-id"><i class="fa fa-reply" aria-hidden="true"></i></button></td>'.
                          '</tr>';
                          }
                          ?>
                        </tbody>
                      </table>
                      <script type="text/javascript">
                        $('button[data-target=#delModal]').click(function(arg) {
                         $('#user-email').html($(this).attr('data-email'));
                         $('#real-delete').attr('data-value', $(this).attr('data-id'));
                        });
                        $('button[href=#modal-id]').click(function(){
                          $('#emailto').val($(this).attr('data-email'));
                          $('#mailsubject').val('Trả lời góp ý');
                          $('#mailarea').val('Xin chào ' + $(this).attr('data-fullname'));
                        });
                      </script>
                      <div style="text-align: center;">
                        <ul class="pagination">
                        <?php
                         if($firstPageOfSection > $pageCountOfSection && $pageCountOfSection > 0)
                            echo '<li><a href="quanlitinnhan.php?page=' . ($firstPageOfSection - $pageCountOfSection) . getSearchKey('&q='). '">&laquo;</a></li>';
                           for ($i= $firstPageOfSection; $i < $firstPageOfSection + $pageCountOfSection; $i++) { 
                            echo '<li ' . (($i == $page)?'class="active"':'') .'><a href="quanlitinnhan.php?page=' . $i .getSearchKey('&q=').'">'. $i .'</a></li>';
                           }
                           if(!$isLastSection)
                            echo '<li><a href="quanlitinnhan.php?page=' . ($firstPageOfSection + $pageCountOfSection) .getSearchKey('&q='). '">&raquo;</a></li>';
                        ?>
                      </ul>
                      </div>
                  </div>
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
      <div class="modal fade" id="modal-id">
        <div class="box box-info" style="width: 50%;margin:50px auto;">
                <div class="box-header">
                  <i class="fa fa-envelope"></i>
                  <h3 class="box-title">Send Email</h3>
                  <!-- tools box -->
                  
                </div>
                <div class="box-body">
                  <form action="#" method="post">
                    <div class="form-group">
                      <input type="email" class="form-control" id="emailto" name="emailto" placeholder="Email to:" />
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" id="mailsubject" name="subject" placeholder="Subject" />
                    </div>
                    <div>
                      <textarea  id="mailarea" class="textarea" placeholder="Message" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                    </div>
                  </form>
                </div>
                <div class="box-footer clearfix">
                  <button class="pull-right btn btn-default" id="sendEmail">Send <i class="fa fa-arrow-circle-right"></i></button>
                </div>
              </div>
      </div>
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

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
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
            <p>Bạn thực sự muốn xóa góp ý của <span id="user-email"></span></p>
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
        $.ajax({url: '../delete.php?id='+$(this).attr('data-value'), success: function(result){
            if (result == '1') {
              //success
              location.reload();
            }else{
              //error
              alert('Không thể xóa tin nhắn này!');
              console.log(result);
            }
        }});
      });
    </script>
    <script type="text/javascript">
      $('#sendEmail').click(function(argument) {
        var mailData = {'emailto':$('#emailto').val(), 'mailsubject':$('#mailsubject').val(), 'mailbody':$('#mailarea').val()};
        $.ajax({type: "POST", url: '../sendmail.php', data: mailData, success: function(result) {
          if (result == '1') {
            alert('Gửi mail thành công!');
            $('#emailto').val('');
          }else if(result == '-1'){
            alert('Có lỗi xảy ra, mail chưa được gửi!');
          }else if(result == '0'){
            alert('Thiếu thông tin, Kiểm tra phần nhập!');
          }else{
            alert('Bạn không có quyền gửi mail!');
          }
        }});
      })
    </script>
  </body>
</html>
