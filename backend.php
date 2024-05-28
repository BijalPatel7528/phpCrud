<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_POST['action'] == 'add') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $slug = $_POST['slug'];

    $created_at = date("Y-m-d H:i:s");
    $updated_at = date("Y-m-d H:i:s");

    $sql = "INSERT INTO articles (title, description, category, slug, created_at, updated_at) 
    VALUES ('$title', '$description', '$category', '$slug', '$created_at', '$updated_at')";

    if ($conn->query($sql) === TRUE) {
        echo "Record added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if ($_POST['action'] == 'update') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $slug = $_POST['slug'];

    $sql = "UPDATE articles SET title='$title', description='$description', category='$category', slug='$slug' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

if ($_POST['action'] == 'fetch') {
    
    $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
    $length = isset($_POST['length']) ? intval($_POST['length']) : 10; // Default length
    $keyword = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';

   
    $sql = "SELECT COUNT(*) as total FROM articles";
    if (!empty($keyword)) {
        $sql .= " WHERE title LIKE '%$keyword%' OR description LIKE '%$keyword%' OR slug LIKE '%$keyword%'";
    }
    $totalRecordsQuery = mysqli_query($conn, $sql);
    $totalRecordsData = mysqli_fetch_assoc($totalRecordsQuery);
    $totalRecords = $totalRecordsData['total'];

    $sql = "SELECT * FROM articles";
    if (!empty($keyword)) {
        $sql .= " WHERE title LIKE '%$keyword%' OR description LIKE '%$keyword%' OR slug LIKE '%$keyword%'";
    }
    $sql .= " LIMIT $start, $length";
    $query = mysqli_query($conn, $sql);
    $data = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = $row;
    }

    $response = [
        "draw" => $draw,
        "recordsTotal" => $totalRecords,
        "recordsFiltered" => $totalRecords,
        "data" => $data
    ];

    echo json_encode($response);
    exit;
}


if ($_POST['action'] == 'delete') {
    $id = $_POST['id'];
    $sql = "DELETE FROM articles WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

if ($_POST['action'] == 'fetch_categories') {
    $sql = "SELECT * FROM category";
    $result = $conn->query($sql);
    $categories = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
        echo json_encode($categories);
    } else {
        echo "0 results";
    }
}

if ($_POST['action'] == 'fetch_single_id') {
    $id = $_POST['id'];
    $sql = "SELECT * FROM articles WHERE id='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo "Record not found";
    }
}

// no need 
// Search button operation

// if ($_POST['action'] == 'search') {
//     $keyword = $_POST['keyword'];
//     $sql = "SELECT * FROM articles WHERE title LIKE '%$keyword%' OR description LIKE '%$keyword%' OR slug LIKE '%$keyword%'";
//     $result = $conn->query($sql);
//     if ($result->num_rows > 0) {
//         while ($row = $result->fetch_assoc()) {
//             echo "<tr><td>" . $row['title'] . "</td><td>" . $row['description'] . "</td><td>" . $row['slug'] . "</td><td><button class='edit-btn' data-id='" . $row['id'] . "'>Edit</button><button class='delete-btn' data-id='" . $row['id'] . "'>Delete</button></td></tr>";
//         }
//     } else {
//         echo "No results found";
//     }
// }


$conn->close();
