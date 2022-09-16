<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/enrollment_form.css">
    <link rel="stylesheet" href="../css/default.css">
    <title>Enrollment Form</title>
</head>
<body>
    
    <form action="get">
        <div class="page-1">
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
                        <input type="text" name="lrn" id="lrn" placeholder="Enter 12 Digit Number">
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
                            <option value="JR">JR.</option>
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
                    <img src="../img/next.png" alt="NEXT" id="go-to-page2">
                </div>
            </div>
        </div>


        <div class="page-2">
            <div class="container">
                <div class="row">
                    <div class="column">
                        <p class="header">Personal Information</p>
                        <p class="sub-header">All labels with <span class="required"></span> are required</p>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                    <label for="gender">Gender <span class="required"></span></label>
                </div>
                <div class="radio-group">
                    <label for="gender-choice1"><input id="gender-choice" type="radio" name="gender-choice" value="male"/> Male</label>
                    <label for="gender-choice2"><input id="gender-choice" type="radio" name="gender-choice" value="female"/> Female</label>
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
                        <input type="tel" name="contact-number" id="contact-number" placeholder="Enter your Contact Number">
                    </div>
                    <div class="column">
                        <label for="email">Email <span class="required"></span></label>
                        <input type="email" name="email" id="email" placeholder="Enter your Email Address">
                    </div>
                </div>
                <div class="row navigation">
                    <img src="../img/previous.png" alt="PREVIOUS" id="back-to-page1">
                    <img src="../img/next.png" alt="NEXT" id="go-to-page3">
                </div>
            </div>
        </div>

        <div class="page-3">
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
                    <div class="column"></div>
                    <div class="column"></div>
                    <div class="column"></div>
                </div>
            </div>
        </div>

    </form>
</body>
</html>