<?php
session_start();
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['issue'])) {
        $studentid = $_POST['studentid'];
        $bookid = $_POST['bookid'];
        $issuedate = date("Y-m-d");

        // Check if book is available or already issued
        $sql = "SELECT id FROM tblissuedbookdetails WHERE BookId=:bookid AND ReturnDate IS NULL";
        $query = $dbh->prepare($sql);
        $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            echo "<script>alert('Book already issued to another student.');</script>";
        } else {
            // Issue book
            $sql = "INSERT INTO tblissuedbookdetails(StudentId,BookId,IssuesDate) VALUES(:studentid,:bookid,:issuedate)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':studentid', $studentid, PDO::PARAM_STR);
            $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
            $query->bindParam(':issuedate', $issuedate, PDO::PARAM_STR);
            $query->execute();

            echo "<script>alert('Book issued successfully');</script>";
        }
    }
?>
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Online Library Management System | Issue Book</title>
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/css/style.css" rel="stylesheet" />
    </head>

    <body>
        <!------MENU SECTION START-->
        <?php include('includes/header.php'); ?>
        <!-- MENU SECTION END-->
        <div class="content-wrapper">
            <div class="container">
                <div class="row pad-botm">
                    <div class="col-md-12">
                        <h4 class="header-line">Issue a Book</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Issue Book
                            </div>
                            <div class="panel-body">
                                <form role="form" method="post">
                                    <div class="form-group">
                                        <label>Student ID</label>
                                        <input class="form-control" type="text" name="studentid" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Book ID</label>
                                        <input class="form-control" type="text" name="bookid" required />
                                    </div>
                                    <button type="submit" name="issue" class="btn btn-info">Issue Book</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FOOTER SECTION END-->
        <?php include('includes/footer.php'); ?>
        <script src="assets/js/jquery-1.10.2.js"></script>
        <script src="assets/js/bootstrap.js"></script>
    </body>

    </html>
<?php } ?>