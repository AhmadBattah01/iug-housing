<?php
session_start();
include('../includes/dbconn.php');
include('../includes/check-login.php');
check_login();
//code for registration
if (isset($_POST['submit'])) {
    $roomno = $_POST['room'];
    $seater = $_POST['seater'];
    $feespm = $_POST['fpm'];
    $foodstatus = $_POST['foodstatus'];
    $stayfrom = $_POST['stayf'];
    $duration = $_POST['duration'];   
    $emailid = $_POST['email'];
    $query = "INSERT into  registration(roomno,seater,feespm,foodstatus,stayfrom,duration,emailid) values(?,?,?,?,?,?,?)";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('iiiisis', $roomno, $seater, $feespm, $foodstatus, $stayfrom, $duration, $emailid);
    $stmt->execute();
    echo "<script>alert('تم الحجز بنجاح');</script>";
}
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>حجز غرفة</title>
    <!-- Custom CSS -->
    <link href="../assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="../assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../dist/css/style.min.css" rel="stylesheet">

    <script>
        function getSeater(val) {
            $.ajax({
                type: "POST",
                url: "get-seater.php",
                data: 'roomid=' + val,
                success: function(data) {
                    //alert(data);
                    $('#seater').val(data);
                }
            });

            $.ajax({
                type: "POST",
                url: "get-seater.php",
                data: 'rid=' + val,
                success: function(data) {
                    //alert(data);
                    $('#fpm').val(data);
                }
            });
        }
    </script>

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
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin6">
            <?php include 'includes/navigation.php' ?>
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
                <?php include 'includes/sidebar.php' ?>
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
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-7 align-self-center">
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">حجز غرفة للطالب</h4>
                        <div class="d-flex align-items-center">
                            <!-- <nav aria-label="breadcrumb">
                                
                            </nav> -->
                        </div>
                    </div>

                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

                <form method="POST">

                    <?php
                    $stmt = $mysqli->prepare("SELECT emailid FROM registration WHERE emailid=? ");
                    $stmt->bind_param('s', $uid);
                    $stmt->execute();
                    $stmt->bind_result($email);
                    $rs = $stmt->fetch();
                    $stmt->close();

                    if ($rs) { ?>
                        <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>رسالة: </strong> لقد قمت سابقا بحجز غرفة
                        </div>
                    <?php } else {
                        echo "";
                    }
                    ?>


                    <!-- <div class="col-7 align-self-center">
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Hostel Bookings</h4>
                    </div> -->


                    <div class="row">


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">رقم الغرفة</h4>
                                    <div class="form-group mb-4">
                                        <select class="custom-select mr-sm-2" name="room" id="room" onChange="getSeater(this.value);" onBlur="checkAvailability()" required id="inlineFormCustomSelect">
                                            <option selected>اختر...</option>
                                            <?php $query = "SELECT * FROM rooms";
                                            $stmt2 = $mysqli->prepare($query);
                                            $stmt2->execute();
                                            $res = $stmt2->get_result();
                                            while ($row = $res->fetch_object()) {
                                            ?>
                                                <option value="<?php echo $row->room_no; ?>"> <?php echo $row->room_no; ?></option>
                                            <?php } ?>
                                        </select>
                                        <span id="room-availability-status" style="font-size:12px;"></span>
                                    </div>

                                </div>
                            </div>
                        </div>



                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">تاريخ الحجز</h4>
                                    <div class="form-group">
                                        <input type="date" name="stayf" id="stayf" class="form-control" required>
                                    </div>

                                </div>
                            </div>
                        </div>



                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">عدد الاشخاص في الغرفة</h4>
                                    <div class="form-group">
                                        <input type="text" id="seater" name="seater" placeholder="عدد الاشخاص  المقيمين في الغرفة." required class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">المدة الاجمالية للسكن</h4>
                                    <div class="form-group mb-4">
                                        <select class="custom-select mr-sm-2" id="duration" name="duration">
                                            <option selected>اختر...</option>
                                            <option value="1">شهر</option>
                                            <option value="2">شهرين</option>
                                            <option value="3">ثلاث اشهر</option>
                                            <option value="4">اربع اشهر</option>
                                            <option value="5">خمس اشهر</option>
                                            <option value="6">ست اشهر</option>
                                            <option value="7">سبعة اشهر</option>
                                            <option value="8">ثمانية اشهر </option>
                                            <option value="9">تسعة اشهر</option>
                                            <option value="10">عشرة اشهر</option>
                                            <option value="11">احد عشر شهر </option>
                                            <option value="12">اثنا عشر شهر</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-6 col-lg-4" style="display: none;">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">حالة الغذاء</h4>
                                    <!-- <div class="custom-control custom-radio">
                                        <input type="radio" id="customRadio1" value="1" name="foodstatus" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadio1">سوف يتم اضافة 50 الف دينار شهريا <code>مطلوب </code></label>
                                    </div> -->
                                    <div class="custom-control custom-radio"  >
                                        <input type="text" id="customRadio2" value="0" name="foodstatus" class="custom-control-input" checked>
                                        <label class="custom-control-label" for="customRadio2">غير مطلوب</label>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">اجمالي الرسوم في الشهر</h4>
                                    <div class="form-group">
                                        <input type="text" name="fpm" id="fpm" placeholder="اجمالي الرسوم الخاصة بك" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">المجموع الكامل لمدة السكن المحددة</h4>
                                    <div class="form-group">
                                        <input type="text" name="ta" id="ta" placeholder="اكتب المجموع الكامل لمدة سكن الطالب.." required class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4 class="card-title mt-5">المعلومات الشخصية للطالب</h4>
                    <div class="row">                      
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">البريد الالكتروني</h4>
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" placeholder="البريد الالكتروني" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-actions">
                            <div class="text-center">
                                <button type="submit" name="submit" class="btn btn-success">تسجيل</button>
                                <button type="reset" class="btn btn-dark">الغاء</button>
                            </div>
                        </div>


                </form>

            </div>
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

    <!-- Custom Ft. Script Lines -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('input[type="checkbox"]').click(function() {
                if ($(this).prop("checked") == true) {
                    $('#paddress').val($('#address').val());
                    $('#pcity').val($('#city').val());
                    $('#ppincode').val($('#pincode').val());
                }

            });
        });
    </script>

    <script>
        function checkAvailability() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check-availability.php",
                data: 'roomno=' + $("#room").val(),
                type: "POST",
                success: function(data) {
                    $("#room-availability-status").html(data);
                    $("#loaderIcon").hide();
                },
                error: function() {}
            });
        }
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#duration').keyup(function() {
                var fetch_dbid = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: "ins-amt.php?action=userid",
                    data: {
                        userinfo: fetch_dbid
                    },
                    success: function(data) {
                        $('.result').val(data);
                    }
                });


            })
        });
    </script>

</body>

</html>