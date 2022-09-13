

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/default.css">
    <link rel="stylesheet" href="../css/enrollment_form.css">
    <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap/bootstrap-grid.min.css">
    <link rel="stylesheet" href="../css/bootstrap/bootstrap-reboot.min.css">
    <script src="https://code.iconify.design/iconify-icon/1.0.0/iconify-icon.min.js"></script>
    <title>Enrollment Form</title>
</head>
<body>
<div class="enrollment-card-center dm-sans">
        <div class="enrollment-card-content enrollment-card-firstpage">

        <div class="grid-container">

            <div class="grid-child dropdown-label">
                Grade level to enroll<span class="asterisk">*</span>
            </div>
        
            <div class="grid-child">
                <select id="gradelevel">
                    <option value="1">10</option>
                    <option value="2">9</option>
                    <option value="3">8</option>
                    <option value="4">7</option>
                    <option value="5">6</option>
                    <option value="6">5</option>
                    <option value="7">4</option>
                    <option value="8">3</option>
                    <option value="9">2</option>
                    <option value="10">1</option>
                </select>
            </div>
          
        </div>

        <header class="open-sans">
            Personal Information
        </header>
        <div class="sub-header">
            All labels with <span class="asterisk">*</span> are required
        </div>

        <form>
            <div class="form-group">
                <label for="formGroupExampleInput"class="form-label">LRN (Learner Reference Number)<span class="asterisk">*</span></label>
                <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Enter the 12 digits number" style="width: 50%;">
              </div>

            <div class="form-row">
              <div class="col">
               <label for="input" class="form-label">Last Name<span class="asterisk">*</span></label>
                <input type="text" class="form-control" placeholder="Enter your last name">
              </div>

              <div class="col">
                <label for="input" class="form-label">First Name<span class="asterisk">*</span></label>
                <input type="text" class="form-control" placeholder="Enter your first name">
              </div>

            </div>

            <div class="form-row">

                <div class="col">
                 <label for="input" class="form-label">Middle Name</label>
                  <input type="text" class="form-control" placeholder="Enter your middle name">
                </div>

                <div class="col">
                  <label for="input" class="form-label">Suffix</label>
                  <input type="text" class="form-control" placeholder="Enter your suffix">
                </div>

              </div>
              <div class="align-right">
                <button id="go-to-two"><iconify-icon icon="fluent:chevron-circle-right-28-regular" class="next-button-first"></iconify-icon></button>
              </div>
          </form>
      </div>
      
    </div>
</body>
</html>