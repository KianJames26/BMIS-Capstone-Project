<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/enrollment_form.css">
    <link rel="stylesheet" href="../css/default.css">
    <title>Enrollment Form</title>
    <script src="../js/multiple_form.js"></script>
</head>
<body>
    <form action="" method="post">
        <div id="page-1">
            <div class="container">
                <div class="row">
                    <label for="grade-level">Grade Level to Enroll <span class="required"></span>  &nbsp;</label>
                    <select name="grade-level" id="grade-level">
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
                </div>

                <div class="row">
                    <div class="column">
                        <p class="header">Personal Information</p>
                        <p class="sub-header">All labels with <span class="required"></span> are required</p>
                    </div>
                </div>

                <div class="row">
                    <div class="column">
                        <label for="lrn">LRN (Learners Reference Number) <span class="required"></span></label>
                        <input type="number" name="lrn" id="lrn" placeholder="Enter 12 Digit Number">
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
                            <option value="null">none</option>
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
                    <div onclick="goToPageTwo()" class="next-page"><img src="../img/next.png" alt="NEXT" ></div>
                </div>
            </div>
        </div>
<!-- END OF PAGE 1 -->
        <div id="page-2">
            <div class="container">
                <div class="row">
                    <div class="column">
                        <p class="header">Personal Information</p>
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
                    <div class="column">
                        <label for="birthplace">Birthplace <span class="required"></span></label>
                        <input type="text" name="birthplace" id="birthplace" placeholder="Enter your Birthplace">
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <label for="contact-number">Contact Number <span class="required"></span></label>
                        <input type="number" name="contact-number" id="contact-number" placeholder="Enter your Contact Number - e.g 09121231234" minlength="11" maxlength="11">
                    </div>
                    <div class="column">
                        <label for="email">Email <span class="required"></span></label>
                        <input type="email" name="email" id="email" placeholder="Enter your Email Address">
                    </div>
                </div>
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
                        <p class="header">Address</p>
                        <p class="sub-header">All labels with <span class="required"></span> are required</p>
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <label for="house-address">House number & Street <span class="required"></span></label>
                        <input type="text" name="house-address" id="house-address" placeholder="Enter House Number & Street">
                    </div>
                    <div class="column">
                        <label for="barangay">Barangay <span class="required"></span></label>
                        <input type="text" name="barangay" id="barangay" placeholder="Enter Barangay">
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <label for="city">City <span class="required"></span></label>
                        <input type="text" name="city" id="city" placeholder="Enter City">
                    </div>
                    <div class="column">
                        <label for="province">Province <span class="required"></span></label>
                        <input type="text" name="province" id="province" placeholder="Enter Province">
                    </div>
                </div>
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
                        <input type="number" name="parent-contact" id="parent-contact" placeholder="Enter Parent/Guardian Contact No. " minlength="11" maxlength="11">
                    </div>
                    <div class="column">
                        <label for="relationship">Relationship <span class="required"></span></label>
                        <input type="text" name="relationship" id="relationship" placeholder="Enter relationship">
                    </div>
                </div>
                <div class="row navigation">
                    <div onclick="goToPageTwo()"><img src="../img/previous.png" alt="PREVIOUS"></div>
                    <div onclick="goToPageFour()" class="next-page"><img src="../img/next.png" alt="NEXT" ></div>
                </div>
            </div>
        </div>
<!-- END OF PAGE 3 -->
        <div id="page-4">
            <div class="container">
                <div class="row">
                    <div class="column">
                        <p class="header">Educational Attainment</p>
                        <p class="sub-header">All labels with <span class="required"></span> are required</p>
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <label for="last-school">Last School Attended <span class="required"></span></label>
                        <input type="text" name="last-school" id="last-school" placeholder="Enter your Last School">
                    </div>
                    <div class="column">
                        <label for="last-school-address">Last School Attended Address <span class="required"></span></label>
                        <input type="text" name="last-school-address" id="last-school-address" placeholder="Enter your Last School Address">
                    </div>
                </div>
                <div class="row">
                    <div class="column" style="width: 100%;">
                        <p class="header">File Upload</p>
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
                            <input type="file" name="student-picture" id="student-picture">
                        </div>
                    </div>
                    <div class="row">
                        <div class="column1">
                            <label for="report-card">Form 138 <span class="required"></span></label>
                        </div>
                        <div class="column2">
                            <input type="file" name="report-card" id="report-card">
                        </div>
                    </div>
                    <div class="row">
                        <div class="column1">
                            <label for="birth-certificate">Birth Certificate <span class="required"></span></label>
                        </div>
                        <div class="column2">
                            <input type="file" name="birth-certificate" id="birth-certificate">
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
                    <p class="header">Personal Information</p>
                </div>
                <div class="row">
                    <div class="column">
                        <p class="content">LRN (Learner's Reference Number) : </p>
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <p class="data" id="showLRN"></p>
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
                        <p class="content">Contact Number : </p>
                    </div>
                    <div class="column">
                        <p class="content">Email : </p>
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <p class="data" id="showContactNumber"></p>
                    </div>
                    <div class="column">
                        <p class="data" id="showEmail"></p>
                    </div>
                </div>

                <div class="row">
                    <p class="header">Address Information</p>
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
                    <p class="header">Educational Attainment</p>
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

                <div class="row navigation">
                    <div onclick="goToPageFour()"><img src="../img/previous.png" alt="PREVIOUS"></div>
                    <button type="submit" id="submit">Submit</button>
                </div>
                
            </div>
        </div>
<!-- END OF PAGE 5 -->
    </form>
    <script src="../js/numberOnly.js"></script>
</body>
</html>