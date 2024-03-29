<?php
    include 'phpMethods/connection.php';
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/enrollment_form.css">
    <link rel="stylesheet" href="../css/default.css">
    <title>Enrollment Form</title>
    <script src="../js/transferree_form.js"></script>
    <script>
        <?php
            $conn = OpenCon();
            $resultWhile = mysqli_query($conn, "SELECT lrn from students");
            $lrnArray = array();

            while ($row = mysqli_fetch_array($resultWhile)){
                $lrnArray[] = $row;
            }

        $activeShoolYearQuery = "SELECT * FROM school_years WHERE isActive = true";
            if ($res = mysqli_fetch_array(mysqli_query($conn, $activeShoolYearQuery))) {
                $activeShoolYear = $res['school_year'];
            }
        ?>
        const existingLrn = <?php echo json_encode($lrnArray);?>;
    </script>
</head>
<body>
    <div class="hidden" onload="topFunction()">
        <dialog id="dialog-box">
            <p class="title">Data Privacy Act</p>
            <p class="reminder">The information collected in the enrollment form will be treated according to Data Privacy Act of 2012.</p>
            <div class="actions">
                <button id="return" onclick="location.href='../index.php'">Return</button>
                <button id="continue">Continue</button>
            </div>
        </dialog>
    </div>
    <script>
        const continueBtn = document.getElementById('continue');
        const dialogBox = document.getElementById('dialog-box');
        
        continueBtn.addEventListener('click', unshowDialog);
        function unshowDialog() {
            dialogBox.classList.toggle("disappear");
            setTimeout(()=>{
                dialogBox.style.display="none";
                document.getElementsByClassName('hidden')[0].style.display='none';
            },400);
        }
    </script>
    <form autocomplete="off" id="form" action="generate_qr.php" method="post" onkeydown="return event.key != 'Enter';" enctype="multipart/form-data">
        <div id="hidden-error"></div>
        <div id="page-1">
            <div class="container">
                <div class="row">
                    <label for="grade-level">Grade Level to Enroll <span class="required"></span>  &nbsp;</label>
                    <select name="grade-level" id="grade-level">
                        <option value="" hidden="true"></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                    <label style="margin-left: auto;">School Year: <?= $activeShoolYear?></label>
                </div>

                <div class="row">
                    <div class="column">
                        <p class="header">Student Information</p>
                        <p class="sub-header">All labels with <span class="required"></span> are required</p>
                    </div>
                </div>

                <div class="row">
                    <div class="column">
                        <label for="lrn">LRN (Learners Reference Number) <span class="required"></span></label>
                        <input type="number" name="lrn" id="lrn" placeholder="Enter 12 Digit Number" maxLength="12">
                        <script>
                            const inputLrn = document.getElementById('lrn');
                            inputLrn.addEventListener('input', function() {
                                this.value = this.value.substring(0, 12); 
                            });
                        </script>
                    </div>
                    <div class="column">
                        <label for="gwa">Last School Year Average <span class="required"></span></label>
                        <input type="number" name="gwa" step="any" id="gwa" placeholder="Enter your Average Last School Year (74-100)">
                        <script>
                            const inputGrade = document.getElementById('gwa');
                            inputGrade.addEventListener('change', function() {
                                if (this.value < 74) {
                                this.value = 74;
                                } else if (this.value > 100) {
                                this.value = 100;
                                }
                            });
                        </script>
                    </div>
                </div> 
                
                <div class="row">
                    <div class="column">
                        <label for="last-name">Last Name <span class="required"></span></label>
                        <input type="text" name="last-name" id="last-name" placeholder="Enter your Last Name">
                    </div>
                    <div class="column">
                        <label for="first-name">First Name <span class="required"></span></label>
                        <input type="text" name="first-name" id="first-name" placeholder="Enter your First Name">
                    </div>
                </div>

                <div class="row">
                    <div class="column">
                        <label for="middle-name">Middle Name</label>
                        <input type="text" name="middle-name" id="middle-name" placeholder="Enter your Middle Name">
                    </div>
                    <div class="column">
                        <label for="suffix">Suffix</label>
                        <select name="suffix" id="suffix">
                            <option value="">none</option>
                            <option value="Jr">Jr</option>
                            <option value="I">I</option>
                            <option value="II">II</option>
                            <option value="III">III</option>
                            <option value="IV">IV</option>
                            <option value="V">V</option>
                            <option value="VI">VI</option>
                        </select>
                    </div>
                </div>
                <div class="row navigation">
                    <div onclick="goToPageTwo(existingLrn)" class="next-page"><img src="../img/next.png" alt="NEXT" ></div>
                </div>
            </div>
        </div>
<!-- END OF PAGE 1 -->
        <div id="page-2">
            <div class="container">
                <div class="row">
                    <div class="column">
                        <p class="header">Student Information</p>
                        <p class="sub-header">All labels with <span class="required"></span> are required</p>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                    <label for="gender-choice">Gender <span class="required"></span></label>
                </div>
                <div class="radio-group">
                    <label for="null" style="display: none;"><input id="null" type="radio" name="gender-choice" value="null" checked="checked"/>Null</label>
                    <label for="gender-male"><input id="gender-male" type="radio" name="gender-choice" value="Male"/> Male</label>
                    <label for="gender-female"><input id="gender-female" type="radio" name="gender-choice" value="Female"/> Female</label>
                </div>
                <div class="row">
                    <div class="column">
                        <label for="birthday">Date of Birth <span class="required"></span></label>
                        <input type="date" name="birthday" id="birthday">
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <label for="birthProvince">Birthplace Province<span class="required"></span></label>
                        <select name="birthProvince" id="birthProvince" class="input"></select>
                    </div>
                    <div class="column">
                        <label for="birthCity">Birthplace City<span class="required"></span></label>
                        <select name="birthCity" id="birthCity" class="input"></select>
                        <input type="hidden" name="birthplace" id="birthplace">
                    </div>
                    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"></script>
                    <script type="text/javascript" src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations.js"></script>
                    <script type="text/javascript">
                    var birth_place_handlers = {
                        fill_cities: function(){
                            var province_code = $(this).val();
                            $('#birthCity').ph_locations( 'fetch_list', [{"province_code": province_code}]);
                        },
                    };
                    $(function(){
                        $('#birthProvince').on('change', birth_place_handlers.fill_cities);

                        
                        $('#birthCity').ph_locations({'location_type': 'cities'});
                        $('#birthProvince').ph_locations({'location_type': 'provinces'});
                        $('#birthProvince').ph_locations('fetch_list');
                    });
                    </script>
                </div>
                <div class="row">
                    <div class="column">
                        <label for="last-school">Last School Attended <span class="required"></span></label>
                        <input type="text" name="last-school" id="last-school" placeholder="Enter your Last School">
                    </div>
                    <div class="column">
                        <label for="last-school-address-handler">Last School Attended Address <span class="required"></span></label>
                        <select name="last-school-address-handler" id="last-school-address-handler" class="input"></select>
                        <input type="hidden" name="last-school-address" id="last-school-address">
                    </div>
                    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"></script>
                    <script type="text/javascript" src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations.js"></script>
                    <script type="text/javascript">
                    $(function(){
                        $('#last-school-address-handler').ph_locations({'location_type': 'provinces'});
                        $('#last-school-address-handler').ph_locations('fetch_list');
                    });
                    </script>
                </div>
                <!-- <div class="row">
                    <div class="column">
                        <label for="contact-number">Contact Number <span class="required"></span></label>
                        <input type="number" name="contact-number" id="contact-number" placeholder="Enter your Contact Number - e.g 09121231234" minlength="11" maxlength="11">
                    </div>
                    <div class="column">
                        <label for="email">Email <span class="required"></span></label>
                        <input type="email" name="email" id="email" placeholder="Enter your Email Address">
                    </div>
                </div> -->
                <div class="row navigation">
                    <div onclick="goToPageOne()"><img src="../img/previous.png" alt="PREVIOUS"></div>
                    <div onclick="goToPageThree()" class="next-page"><img src="../img/next.png" alt="NEXT" ></div>
                </div>
            </div>
        </div>
<!-- END OF PAGE 2 -->
<div id="page-3">
            <div class="container">
                <div class="row">
                    <div class="column">
                        <p class="header">Student Address</p>
                        <p class="sub-header">All labels with <span class="required"></span> are required</p>
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <label for="house-address">House Number & Street</label>
                        <input type="text" name="house-address" id="house-address" placeholder="Enter House Number & Street">
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <label for="regionHandler">Region<span class="required"></label>
                        <select name="regionHandler" class="input" id="region"></select>
                    </div>
                    
                    <div class="column">
                        <label for="provinceHandler">Province<span class="required"></span></label>
                        <select name="provinceHandler" class="input" id="province"></select>
                        <input type="hidden" name="province" id="provinceValue">
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <label for="cityHandler">City <span class="required"></span></label>
                        <select name="cityHandler" class="input" id="city"></select>
                        <input type="hidden" name="city" id="cityValue">
                    </div>
                    <div class="column">
                        <label for="barangayHandler">Barangay <span class="required"></span></label>
                        <select name="barangayHandler" class="input" id="barangay"></select>
                        <input type="hidden" name="barangay" id="barangayValue">
                    </div>
                </div>
                <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"></script>
                <script type="text/javascript" src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations.js"></script>
                <script type="text/javascript">
                    var my_handlers = {
                        fill_provinces:  function(){
                            var region_code = $(this).val();
                            $('#province').ph_locations('fetch_list', [{"region_code": region_code}]);
                        },
                        fill_cities: function(){
                            var province_code = $(this).val();
                            $('#city').ph_locations( 'fetch_list', [{"province_code": province_code}]);
                        },
                        fill_barangays: function(){
                            var city_code = $(this).val();
                            $('#barangay').ph_locations('fetch_list', [{"city_code": city_code}]);
                        }
                    };
                    $(function(){
                        $('#region').on('change',my_handlers.fill_provinces);
                        $('#province').on('change', my_handlers.fill_cities);
                        $('#city').on('change', my_handlers.fill_barangays);

                        $('#region').ph_locations({'location_type': 'regions'});
                        $('#province').ph_locations({'location_type': 'provinces'});
                        $('#city').ph_locations({'location_type': 'cities'});
                        $('#barangay').ph_locations({'location_type': 'barangays'});
                        $('#region').ph_locations('fetch_list');
                    });
                </script>
                <div class="row">
                    <p class="header">Parent/Guardian Information</p>
                </div>
                <div class="row">
                    <div class="column">
                        <label for="parent-fullname">Full Name <span class="required"></span></label>
                        <input type="text" name="parent-fullname" id="parent-fullname" placeholder="Enter Parent/Guardian Full Name">
                    </div>
                    <div class="column">
                        <label for="parent-contact">Contact Number <span class="required"></span></label>
                        <input type="number" name="parent-contact" id="parent-contact" placeholder="Enter Parent/Guardian Contact No. " maxlength="11">
                        <script>
                            const inputMobile = document.getElementById('parent-contact');
                            inputMobile.addEventListener('input', function() {
                                this.value = this.value.substring(0, 11); 
                            });
                        </script>
                    </div>
                    <div class="column">
                        <label for="relationship">Relationship <span class="required"></span></label>
                        <input type="text" name="relationship" id="relationship" placeholder="Enter relationship">
                    </div>
                </div>
                <div class="row navigation">
                    <div onclick="goToPageTwo(existingLrn)"><img src="../img/previous.png" alt="PREVIOUS"></div>
                    <div onclick="goToPageFour()" class="next-page"><img src="../img/next.png" alt="NEXT" ></div>
                </div>
            </div>
        </div>
<!-- END OF PAGE 3 -->
        <div id="page-4">
            <div class="container">
                <div class="row">
                    <div class="column" style="width: 100%;">
                        <p class="header">File Upload</p>
                        <p class="sub-header">All labels with <span class="required"></span> are required</p>
                        <p class="sub-header">Please follow the instructions below</p>
                        <p class="sub-header" style="font-weight: bolder;">For the 1x1 picture, upload a picture with a png format.The picture must have a white background. Upload form 138 and birth certificate as pdf file.</p>
                    </div>
                </div>
                <div class="file-upload">
                    <div class="row">
                        <div class="column1">
                            <label for="student-picture">1x1 picture <span class="required"></span></label>
                        </div>
                        <div class="column2">
                            <input type="file" name="student-picture" id="student-picture" onchange="return studentPictureValidation()">
                        </div>
                    </div>
                    <div class="row">
                        <div class="column1">
                            <label for="report-card">Form 138 <span class="required"></span></label>
                        </div>
                        <div class="column2">
                            <input type="file" name="report-card" id="report-card" onchange="return pdfValidation('report-card')">
                        </div>
                    </div>
                    <div class="row">
                        <div class="column1">
                            <label for="birth-certificate">Birth Certificate <span class="required"></span></label>
                        </div>
                        <div class="column2">
                            <input type="file" name="birth-certificate" id="birth-certificate" onchange="return pdfValidation('birth-certificate')">
                        </div>
                    </div>
                </div>
                <div class="row navigation">
                    <div onclick="goToPageThree()"><img src="../img/previous.png" alt="PREVIOUS"></div>
                    <div onclick="goToPageFive()" class="next-page"><img src="../img/next.png" alt="NEXT" ></div>
                </div>
            </div>
        </div>
<!-- END OF PAGE 4 -->
        <div id="page-5">
            <div class="container">
                <div class="row">
                    <p class="header">Student Information</p>
                </div>
                <div class="row">
                    <div class="column">
                        <p class="content">LRN (Learner's Reference Number) : </p>
                    </div>
                    <div class="column">
                        <p class="content">Grade Level : </p>
                    </div>
                    <div class="column">
                        <p class="content">GWA : </p>
                    </div>
                    <div class="column">
                        <p class="content">School Year : </p>
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <p class="data" id="showLRN"></p>
                    </div>
                    <div class="column">
                        <p class="data" id="showGrade"></p>
                    </div>
                    <div class="column">
                        <p class="data" id="showGWA"></p>
                    </div>
                    <div class="column">
                        <p class="data"><?= $activeShoolYear?></p>
                    </div>
                </div>

                <div class="row">
                    <div class="column">
                        <p class="content">Last Name : </p>
                    </div>
                    <div class="column">
                        <p class="content">First Name : </p>
                    </div>
                    <div class="column">
                            <p class="content">Middle Name : </p>
                        </div>
                        <div class="column">
                            <p class="content">Suffix : </p>
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <p class="data" id="showLName"></p>
                    </div>
                    <div class="column">
                        <p class="data" id="showFName"></p>
                    </div>
                    <div class="column">
                        <p class="data" id="showMName"></p>
                    </div>
                    <div class="column">
                        <p class="data" id="showSuffix"></p>
                    </div>
                </div>

                <div class="row">
                    <div class="column">
                        <p class="content">Gender : </p>
                    </div>
                    <div class="column">
                        <p class="content">Date of Birth : </p>
                    </div>
                    <div class="column">
                        <p class="content">Place of Birth : </p>
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <p class="data" id="showGender"></p>
                    </div>
                    <div class="column">
                        <p class="data" id="showBirthday"></p>
                    </div>
                    <div class="column">
                        <p class="data" id="showBirthPlace"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <p class="content">Last School Attended</p>
                    </div>
                    <div class="column">
                        <p class="content">Last School Attended Address</p>
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <p class="data" id="showLastSchool"></p>
                    </div>
                    <div class="column">
                        <p class="data" id="showLastSchoolAddress"></p>
                    </div>
                </div>

                <div class="row">
                    <p class="header">Student Address</p>
                </div>
                <div class="row">
                    <div class="column">
                        <p class="content">House Number & Street : </p>
                    </div>
                    <div class="column">
                        <p class="content">Barangay : </p>
                    </div>
                    <div class="column">
                        <p class="content">City : </p>
                    </div>
                    <div class="column">
                        <p class="content">Province : </p>
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <p class="data" id="showHouse"></p>
                    </div>
                    <div class="column">
                        <p class="data" id="showBarangay"></p>
                    </div>
                    <div class="column">
                        <p class="data" id="showCity"></p>
                    </div>
                    <div class="column">
                        <p class="data" id="showProvince"></p>
                    </div>
                </div>

                <div class="row">
                    <p class="header">Parent/Guardian Informaction</p>
                </div>
                <div class="row">
                    <div class="column">
                        <p class="content">Parent/Guardian Full Name</p>
                    </div>
                    <div class="column">
                        <p class="content">Parent/Guardian Contact</p>
                    </div>
                    <div class="column">
                        <p class="content">Relationship</p>
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <p class="data" id="showParentFullName"></p>
                    </div>
                    <div class="column">
                        <p class="data" id="showParentContact"></p>
                    </div>
                    <div class="column">
                        <p class="data" id="showParentRelationship"></p>
                    </div>
                </div>

                <div class="row">
                    <p class="header">File Upload</p>
                </div>
                <div class="row">
                    <div class="column">
                        <p class="content">1x1 Picture : </p>
                    </div>
                    <div class="column">
                        <p class="content">Form 138 : </p>
                    </div>
                    <div class="column">
                        <p class="content">Birth Certificate : </p>
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <p class="data" id="showPicture"></p>
                    </div>
                    <div class="column">
                        <p class="data" id="showReportCard"></p>
                    </div>
                    <div class="column">
                        <p class="data" id="showBirthCertificate"></p>
                    </div>
                </div>
                <input type="hidden" name="school-year" id="school-year" value="<?= $activeShoolYear ?>">
                <div class="row navigation">
                    
                    <div onclick="goToPageFour()"><img src="../img/previous.png" alt="PREVIOUS"></div>
                    <button name="submit" type="submit" id="submit">Submit</button>
                </div>
                
            </div>
        </div>
<!-- END OF PAGE 5 -->
    </form>
    <script src="../js/numberOnly.js"></script>
</body>
</html>