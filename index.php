<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Example</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h2>CRUD Example</h2>

       
        <form id="crud-form" method="post">
            <input type="hidden" id="id" placeholder="id">
            <div class="mb-3">
                <input type="text" class="form-control" id="title" placeholder="Title">
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" id="description" placeholder="Description">
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" id="slug" placeholder="Slug">
            </div>
            <div class="mb-3">
                <select class="form-select" id="category">
                  
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>

        <table id="data-table" class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Slug</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="data-body">

            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <!-- Custom Script -->
    <script src="script.js"></script>
</body>

</html>
