<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

try {
    if (isset($_POST['add_product'])) {
    
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $details = mysqli_real_escape_string($conn, $_POST['details']);
        $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
        $image = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploaded_img/' . $image;
        $video = $_FILES['video']['name'];
        $video_size = $_FILES['video']['size'];
        $video_tmp_name = $_FILES['video']['tmp_name'];
        $video_folder = 'uploaded_videos/' . $video;
    
        // Check if directories exist, if not create them
        if (!is_dir('uploaded_img')) {
            mkdir('uploaded_img', 0777, true);
        }
        if (!is_dir('uploaded_videos')) {
            mkdir('uploaded_videos', 0777, true);
        }
    
        $select_product_name = mysqli_query($conn, "SELECT name FROM `video` WHERE name = '$name'") or die('query failed');
    
        if (mysqli_num_rows($select_product_name) > 0) {
            $message[] = 'Video name already exists!';
        } else {
            $insert_product = mysqli_query($conn, "INSERT INTO `video`(name, details, image, video, kategori) VALUES('$name', '$details', '$image', '$video', '$kategori')") or die('query failed');
    
            if ($insert_product) {
                if ($video_size > 50000000) { // Adjust the size limit as needed
                    $message[] = 'Video size is too large!';
                } else {
                    if (move_uploaded_file($video_tmp_name, $video_folder)) {
                        if ($image_size > 2000000) { // Adjust the size limit as needed
                            $message[] = 'Image size is too large!';
                        } else {
                            if (move_uploaded_file($image_tmp_name, $image_folder)) {
                                $message[] = 'Video and image added successfully!';
                            } else {
                                $message[] = 'Failed to upload image!';
                            }
                        }
                    } else {
                        $message[] = 'Failed to upload video!';
                    }
                }
            }
        }
    }
    
    if (isset($_GET['delete'])) {
    
        $delete_id = $_GET['delete'];
        $select_delete_video = mysqli_query($conn, "SELECT video FROM `video` WHERE id = '$delete_id'") or die('query failed');
        $fetch_delete_video = mysqli_fetch_assoc($select_delete_video);
        $select_delete_image = mysqli_query($conn, "SELECT image FROM `video` WHERE id = '$delete_id'") or die('query failed');
        $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
        unlink('uploaded_videos/' . $fetch_delete_video['video']);
        unlink('uploaded_img/' . $fetch_delete_image['image']);
        mysqli_query($conn, "DELETE FROM `video` WHERE id = '$delete_id'") or die('query failed');
        mysqli_query($conn, "DELETE FROM `cart` WHERE pid = '$delete_id'") or die('query failed');
        header('location:admin_video.php');
    }
} catch (\Throwable $th) {
    die($th->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videos</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom Admin CSS File Link -->
    <link rel="stylesheet" href="css/admin_style.css">

    <style>
        /* Styling for the product table */
        .table-container {
            width: 100%;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 18px;
        }
        table th {
            background-color: #f2f2f2;
        }
        .product-video {
            max-width: 100px;
            height: auto;
        }
        .product-image {
            max-width: 100px;
            height: auto;
        }
        .empty {
            text-align: center;
            padding: 10px;
        }
    </style>

</head>
<body>
    
<?php @include 'admin_header.php'; ?>

<section class="add-products">
    <form action="" method="POST" enctype="multipart/form-data">
        <h3>Add New Video</h3>
        <input type="text" class="box" required placeholder="Enter video name" name="name">
        <textarea name="details" class="box" required placeholder="Enter video details" cols="30" rows="10"></textarea>
        <h2 style="font-size: 18px;">IMAGE</h2>
        <input type="file" accept="image/jpg, image/jpeg, image/png" required class="box" name="image">
        <h2 style="font-size: 18px;">VIDEO</h2>
        <input type="file" accept="video/mp4, video/mkv, video/avi" required class="box" name="video">
        <select name="kategori" id="" style="font-weight: 600; font-size: 16px; text-align: center;" class="box">
            <option value="balita">CARA MEMPERLAKUKAN BALITA DENGAN BENAR</option>
            <option value="anak_7_tahun">CARA MENDIDIK ANAK YANG BERUMUR 7 TAHUN</option>
            <option value="pelajari">PELAJARI INI SEBELUM KAMU MENIKAH</option>
        </select>
        <input type="submit" value="Add Video" name="add_product" class="btn">
    </form>
</section>

<section class="show-products">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="text-align: center;">Image</th>
                    <th style="text-align: center;">Video</th>
                    <th style="text-align: center;">Name</th>
                    <th style="text-align: center;">Details</th>
                    <th style="text-align: center;">Category</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select_products = mysqli_query($conn, "SELECT * FROM `video`") or die('query failed');
                if (mysqli_num_rows($select_products) > 0) {
                    while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                ?>
                <tr>
                    <td style="text-align: center;"><img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="product-image"></td>
                    <td style="text-align: center;"><video src="uploaded_videos/<?php echo $fetch_products['video']; ?>" class="product-video" controls></video></td>
                    <td style="text-align: center;"><?php echo $fetch_products['name']; ?></td>
                    <td style="text-align: center;"><?php echo $fetch_products['details']; ?></td>
                    <td style="text-align: center;"><?php echo $fetch_products['kategori']; ?></td>
                    <td style="text-align: center;">
                        <a href="admin_update_video.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">Update</a>
                        <a href="admin_video.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Delete this video?');">Delete</a>
                    </td>
                </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="5" class="empty">No video added yet!</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</section>

<script src="js/admin_script.js"></script>

</body>
</html>
