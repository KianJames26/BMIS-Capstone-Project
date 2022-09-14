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
            </div>
        </div>


        <div class="page-2">
            <div class="container">
                
            </div>
        </div>

        <div class="page-3">
            <div class="container"></div>
        </div>

    </form>
</body>
</html>