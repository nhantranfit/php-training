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
            <h2>List User</h2>
           
        </div>
        <form action="search.php" method="get" class="form-inline my-2 my-lg-0">
                <input type="radio" id="username" name="check" value="username" checked="checked">
                <label for="username">Username</label>
                <input type="radio" id="fullname" name="check" value="fullname">
                <label for="fullname">Fullname</label>
                <input type="radio" id="email" name="check" value="email">
                <label for="email">Email</label>
                <br>
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="keyword">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit" style="margin-top: 10px">Search</button>
            </form>

        <form>
            <?php echo display_error(); ?>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">AVT</th>
                        <th scope="col">Username</th>
                        <th scope="col">Full name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($arrs as $arr) : ?>
                        <tr scope="row">
                            <td><?php if ($arr['user_type'] === "admin") { ?>
                                    <img src="./public/images/admin_profile.png" class="img-fluid" alt="" style="width:50px;height:50px;">
                                <?php } else { ?>
                                    <img src="./public/images/user_profile.png" class="img-fluid" alt="" style="width:50px;height:50px;">
                                <?php } ?>
                            </td>
                            <td><?php echo $arr['username']; ?></td>
                            <td><?php echo $arr['fullname']; ?></td>
                            <td><?php echo $arr['email']; ?></td>
                            <td>
                                <a href="./userdetail.php?id=<?php echo $arr['id'] ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a href='./edit.php?id=<?php echo $arr['id'] ?>'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                <a href='delete_user.php?id=<?php echo $arr['id'] ?>' name="delete_user"><i class="fa fa-times" aria-hidden="true" onClick="return confirm('Nhấn oke để xoá.')"></i></a>

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
            <br><a href="admin.php">Add User ++</a>

        </div>
    </div>
</body>

</html>