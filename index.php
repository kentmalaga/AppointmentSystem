<?php include_once './config.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    </head>
    <body>  
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 ">
                    <div class="appoinment-content">
                        <img src="assets/img/img-3.jpg" alt="" class="img-fluid"/>
                        <div class="emergency">
                            <h2 class="text-lg"><i class="icofont-phone-circle text-lg"></i>+91 88272 13789</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-10 ">
                    <div class="appoinment-wrap mt-5 mt-lg-0">
                        <h2 class="mb-2 title-color">Book appoinment</h2>
                        <p class="mb-4">
                            Now you can get an online appointment, We will get back to you and fix a meeting with doctors.
                        </p>

                        <?php
                        if (isset($_POST['submit'])) {

                            if (isset($_POST['department']) && !empty($_POST['doctors']) && !empty($_POST['date']) && !empty($_POST['time']) && !empty($_POST['name']) && !empty($_POST['phone']) && !empty($_POST['message'])) {
                                $statement = $DB->prepare('INSERT INTO appoinments (doctor,department,app_date,app_time,patient_name,phone,msg) VALUES (:doctor,:department,:app_date,:app_time,:patient_name,:phone,:msg)');



                                $is_done = $statement->execute([
                                    'doctor' => $_POST['doctors'],
                                    'department' => $_POST['department'],
                                    'app_date' => $_POST['date'],
                                    'app_time' => $_POST['time'],
                                    'patient_name' => $_POST['name'],
                                    'phone' => $_POST['phone'],
                                    'msg' => $_POST['message'],
                                ]);

                                if ($is_done) {
                                    echo "<p class='success'>Your appointment has been taken!</p>";
                                    header("Refresh:1;url= success.php");
                                }
                            } else {
                                echo "<p class='error'>Fill out the all form data!</p>";
                            }
                        }
                        ?>

                        <form id="#" class="appoinment-form" method="post" action="#">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <select class="form-control" id="department" name="department">
                                            <option>Choose Department</option>
                                            <?php
                                            $stmt = $DB->prepare("SELECT * FROM department");
                                            $stmt->execute();
                                            $departments = $stmt->fetchAll();
                                            ?>
                                            <?php foreach ($departments as $department): ?>
                                                <option value="<?php echo $department['name']; ?>"><?php echo $department['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <select class="form-control" id="doctors" name="doctors"></select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input name="date" id="date" type="text" class="form-control" placeholder="dd/mm/yyyy">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input name="time" id="time" type="text" class="form-control" placeholder="Time">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input name="name" id="name" type="text" class="form-control" placeholder="Full Name">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input name="phone" id="phone" type="Number" class="form-control" placeholder="Phone Number">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-2 mb-4">
                                <textarea name="message" id="message" class="form-control" rows="6" placeholder="Your Message"></textarea>
                            </div>

                            <input type="submit" name="submit" class="btn btn-main btn-round-full" value="Make Appoinment">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#department').change(function () {

                    var path = "doctors_list.php";
                    var department = $("#department").val();
                    $.ajax({
                        type: "POST",
                        url: path,
                        data: {
                            department: department
                        },
                        success: function (data) {
                            $('#doctors').html(data);
                        }
                    });

                    return false;


                });

                //jquery datepicker
                $("#date").datepicker({
                    dateFormat: 'dd/mm/yy',
                    minDate: 0
                });


                //timepicker
                $('#time').timepicker({

                });
            });

        </script>

    </body>
</html>