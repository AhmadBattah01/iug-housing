<?php
    session_start();
    include('../includes/dbconn.php');
    include('../includes/check-login.php');
    check_login();
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<!-- By CodeAstro - codeastro.com -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>تفاصيل الغرفة</title>
    <!-- Custom CSS -->
    <link href="../assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="../assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../dist/css/style.min.css" rel="stylesheet">
    
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin6">
             <?php include '../includes/student-navigation.php'?>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <?php include '../includes/student-sidebar.php'?>
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                
                <div class="col-7 align-self-center">
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">تفاصيل حول غرفتك المحجوزة</h4>
                </div>



                <!--Table Column -->
                
                 <div class="card">
                 
                   <div class="card-body">
                   
                      <div class="row">
                      
                      <div class="table-responsive">
                                    <table id="zctb" class="table table-striped table-bordered no-wrap">

                                        <tbody>

                                        <?php	
                                        $aid=$_SESSION['login'];
                                        $ret="SELECT * from registration where emailid=?";
                                        $stmt= $mysqli->prepare($ret) ;
                                        $stmt->bind_param('s',$aid);
                                        $stmt->execute() ;
                                        $res=$stmt->get_result();
                                        $cnt=1;
                                        while($row=$res->fetch_object())
                                            {
                                                ?>

                                            <tr>
                                                <td colspan="6"><b><h4>تاريخ ووقت التسجيل</h4> <?php echo $row->postingDate;?></b></td>
                                                
                                            </tr>

                                            <tr>

                                            <td><b>رقم الغرفة :</b></td>
                                            <td><?php echo $row->roomno;?></td>

                                            <td><b>تاريخ الحجز :</b></td>
                                            <td><?php echo $row->stayfrom;?></td>

                                            <td><b>عدد الاشخاص في الغرفة :</b></td>
                                            <td><?php echo $row->seater;?></td>
                                            <!-- By CodeAstro - codeastro.com -->

                                            </tr>

                                            <tr>

                                            <td><b>مدة: السكن:</b></td>
                                            <td><?php echo $dr=$row->duration;?> اشهر</td>

                                            

                                            <td ><b>الرسوم في الشهر: :</b></td>
                                            <td colspan="3">$<?php echo $fpm=$row->feespm;?></td>

                                            

                                            </tr>

                                            <tr>
                                            <td colspan="6"><b>اجمالي الرسوم التي سوف يدفعها :(<?php echo ($dr*$fpm).'$'?>)  </b>
                                               
                                            </td>
                                            </tr>


                                            <tr>
                                            <td><b>رقم الغرفة :</b></td>
                                            <td><?php echo $row->roomno;?></td>
                                             <td><b>البريد الالكتروني:</b></td>
                                            <td colspan="3"><?php echo $row->emailid;?></td>
                                            </tr>

                                            <?php
                                            $cnt=$cnt+1;
                                            } ?>

                                        </tbody>
                                    </table>
                                   
                                </div>
                      
                      
                      </div>
                   
                   
                   </div>
                 
                 
                 </div>

                <!-- Table column end -->

            </div><!-- By CodeAstro - codeastro.com -->
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php include '../includes/footer.php' ?>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <!-- apps -->
    <script src="../dist/js/app-style-switcher.js"></script>
    <script src="../dist/js/feather.min.js"></script>
    <script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <script src="../assets/extra-libs/c3/d3.min.js"></script>
    <script src="../assets/extra-libs/c3/c3.min.js"></script>
    <script src="../assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="../assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="../dist/js/pages/dashboards/dashboard1.min.js"></script>
</body>

</html>