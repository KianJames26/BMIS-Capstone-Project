<?php
    require_once '../phpMethods/dompdf/vendor/autoload.php';
    include '../phpMethods/connection.php';
    $conn = OpenCon();
    use Dompdf\Dompdf;
    $img1 = "../../img/logo.png";
    $file1 = base64_encode(file_get_contents($img1));
    $base64_1 = "data:image/png;base64,{$file1}";
    $img2 = "../../img/deped.png";
    $file2 = base64_encode(file_get_contents($img2));
    $base64_2= "data:image/png;base64,{$file2}";
    $dompdf = new Dompdf();
    $dompdf->getOptions()->getChroot();
    define("DOMPDF_ENABLE_REMOTE", false);

    $gradeLevel = $_POST['grade-level'];
    $section = $_POST['section'];
    $schoolYear = $_POST['school-year'];
    $htmlContent = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
        <style>
            *{
            padding: 0;
            margin: 0;
            box-sizing: content-box;
            
        }
        table{
            text-align: center;
            margin-bottom: 20px;
            width:100%;
            }
        img{
            width: 100px;
            height: 100px;
        }
        .column{
            display: inline-block;
            width: 23%;
            vertical-align:middle; 
        }
        .column1{
            display: inline-block;
            width: 10%;
            padding-top: 10px;
            vertical-align:middle; 
        }
        main > h1{
            font-size: 24px;
            text-align: center;
        }
        main > table{
            width: 90%;
            margin: 20px 5%;
        }
        main > table > thead > tr > th{
            font-size: 18px;
        }
        main > table > tbody > tr > td{
            font-size: 14px;
        }
        main > table > thead > tr > th, main > table > tbody > tr > td{
            white-space: nowrap;
            padding: 5px 10px;
            text-align: center;
        }
        main > table,
        main > table > thead > tr > th,
        main > table > tbody > tr > td{
            border: 1px solid black;
            border-collapse: collapse;
        }
        main > table > thead > tr > th{
            background-color: #dddddd;
        }
        </style>
    </head>
    <body>
        <table align="center">
            <tr>
                <td><img src="'.$base64_1.'" alt=""></td>
                <td><h3>Barasoain Memorial Inegrated School</h3>
            <p>A. Mabini Street, Mojon, Malolos, Bulacan</p></td>
                <td><img src="'.$base64_2.'" alt=""></td>
            </tr>
        </table>
        <div class="center">
        <main>
            <h1>Grade '.$gradeLevel.' Section '.$section.' S.Y '.$schoolYear.'</h1>
            <table>
                <thead>
                    <tr>
                        <th>LRN</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Suffix</th>
                        <th>Gender</th>
                    </tr>
                </thead>
                <tbody>
    ';
    
    $queryStudents = "SELECT * FROM `$schoolYear`
    JOIN students ON `$schoolYear`.enrolled_lrn = students.lrn
    WHERE `$schoolYear`.grade_level = '$gradeLevel' AND `$schoolYear`.section = '$section'";

    if ($result = mysqli_query($conn, $queryStudents)) {
        if (mysqli_num_rows($result) == 0) {
            $htmlContent .= '<tr>
                <td colspan="100%"><h1>Empty Data</h1</td>
            </tr>';
        }else{
            while ($res = mysqli_fetch_assoc($result)) {
                $htmlContent .= "<tr><td>". $res['lrn'] ."</td><td>". $res['last_name'] ."</td><td>". $res['first_name'] ."</td><td>". $res['middle_name'] ."</td><td>". $res['suffix'] ."</td><td>".$res['gender'] ."</td></tr>";
            }
        }
    }
    $htmlContent .= "</tbody>
    </table>
</main>
</div>
</body>
</html>";
    $dompdf->loadHtml($htmlContent);

    $dompdf->setPaper('A4', 'Landscape');

    $fileName = $schoolYear."grade".$gradeLevel."section".$section;

    $dompdf->render();
    header("Content-type:application/pdf");
    header("Content-disposition: inline;filename=".$fileName);
    $dompdf -> stream($fileName, ["Attachment" => false]);
?>