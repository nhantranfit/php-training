<?php
session_start();

include('functions.php');

$results = [];
$id = isset($_GET['id']) ? $_GET['id'] : '';

// if (isset($_GET['list'])) {
//     if (isAdmin()) {
//         $query = "SELECT * FROM users";
//         $results = mysqli_query($conn, $query);
//     }
// }

$page = 1; //khởi tạo trang ban đầu
$limit = 2; //số bản ghi trên 1 trang (2 bản ghi trên 1 trang)


$arrs_list = mysqli_query($conn, "SELECT id from users");
$total_record = mysqli_num_rows($arrs_list); //tính tổng số bản ghi có trong bảng khoahoc

$total_page = ceil($total_record / $limit); //tính tổng số trang sẽ chia

//xem trang có vượt giới hạn không:
if (isset($_GET["list"]))
    $page = $_GET["list"]; //nếu biến $_GET["page"] tồn tại thì trang hiện tại là trang $_GET["page"]
if ($page < 1) $page = 1; //nếu trang hiện tại nhỏ hơn 1 thì gán bằng 1
if ($page > $total_page) $page = $total_page; //nếu trang hiện tại vượt quá số trang được chia thì sẽ bằng trang cuối cùng

//tính start (vị trí bản ghi sẽ bắt đầu lấy):
$start = ($page - 1) * $limit;

//lấy ra danh sách và gán vào biến $arrs:
$arrs = mysqli_query($conn, "SELECT * from users limit $start,$limit");
?>

<html>

<head>
    <title>Register</title>

    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/font-awesome.min.css">
    <link rel="stylesheet" href="public/css/styles.css">
</head>

<body>
    <div class="container">
        <div class="header">
        <div class="row">
                <div class="col-md-6">
                    <h2>List User</h2>
                </div>
                <div class="col-md-6">
                    <form action="search.php" method="get" class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="keyword">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" style="margin-top: 10px">Search</button>
                    </form>
                </div>
            </div>
        </div>

        <form>
            <?php echo display_error(); ?>
            <?php if (isset($_SESSION['success'])) : ?>
                <div class="error success">
                    <h3>
                        <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                        ?>
                    </h3>
                </div>
            <?php endif ?>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">AVT</th>
                        <th scope="col">ID</th>
                        <th scope="col">Username</th>
                        <th scope="col">Full name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($arrs as $arr) : ?>
                        <tr scope="row">
                            <td><img src="./public/images/<?php echo $arr['image'];?>" class="img-fluid" alt="" style="width:50px; height:50px;"></td>
                            <td><?php echo $arr['id']; ?></td>
                            <td><?php echo $arr['username']; ?></td>
                            <td><?php echo $arr['fullname']; ?></td>
                            <td><?php echo $arr['email']; ?></td>
                            <td>
                                <a href="./userdetail.php?id=<?php echo $arr['id'] ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a href='./edit.php?id=<?php echo $arr['id'] ?>'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                <a href=""><i class="fa fa-times" aria-hidden="true" ></i></a>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                <li <?php if ($page == $i) echo "class='active'"; ?>><a href="list.php?list=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php } ?>
        </ul>
        <div class="back" style="text-align: center">
            <button type="button" class="btn btn-info" onClick="javascript:history.go(-1)">Back</button>
            <a href="admin.php" class="btn btn-info">Add User ++</a>

        </div>
    </div>
</body>

</html>