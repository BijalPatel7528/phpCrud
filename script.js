// $(document).ready(function () {
    
function fetchAndDisplayData() {
    $.ajax({
        type: 'POST',
        url: 'backend.php',
        data: { action: 'fetch' },
        success: function (response) {
            var jsonData = JSON.parse(response);
            console.log('jsonData  ',jsonData);
            var dataTable = $('#data-table').DataTable();
            dataTable.clear().rows.add(jsonData.data).draw();
        }
    });
}

    function fetchCategories() {
        $.ajax({
            type: 'POST',
            url: 'backend.php',
            data: { action: 'fetch_categories' },
            dataType: 'json',
            success: function (categories) {
                console.log('categories response ',categories);
                $('#category').empty();
                $.each(categories, function (index, category) {
                    $('#category').append('<option value="' + category.Category_ID + '">' + category.Category_Name + '</option>');
                });
            }
        });
    }

    fetchCategories();
 
    $('#data-table').DataTable({
        "processing": true,
        "serverSide": true,
        "search": true,
        "ajax": {
            "url": "backend.php",
            "type": "POST",
            "data": function (d) {
                d.action = 'fetch';
                d.keyword = $('#search-input').val();
            }
        },
        "columns": [
            { "data": "title" },
            { "data": "description" },
            { "data": "slug" },
            { 
                "data": "id",
                "render": function (data, type, row) {
                    return '<button class="edit-btn btn btn-primary" data-id="' + data + '">Edit</button>' +
                           '<button class="delete-btn btn btn-danger" data-id="' + data + '">Delete</button>';
                }
            }
        ]
    });
   
    // $('#search-btn').click(function () {
    //     $('#data-table').DataTable().ajax.reload(); 
    // });
   
$('#crud-form').submit(function (e) {
    e.preventDefault();
    var id = $('#id').val();
    console.log('form id',id);
    var title = $('#title').val();
    var description = $('#description').val();
    var slug = $('#slug').val();
    var category = $('#category').val();

    var data = {
        title: title,
        description: description,
        category: category,
        slug: slug
    };

    if (id) {
        data.action = 'update';
        data.id = id;
    } else {
        data.action = 'add';
    }

    $.ajax({
        type: 'POST',
        url: 'backend.php',
        data: data,
        success: function (response) {
            console.log('response from...',response);
            alert(response);
            fetchAndDisplayData(); 
            $('#crud-form')[0].reset();
            $('#id').val(''); 
        }
    });
});

    $(document).on('click', '.delete-btn', function () {
        var id = $(this).data('id');
        console.log('delete id',id);
        $.ajax({
            type: 'POST',
            url: 'backend.php',
            data: { action: 'delete', id: id },
            success: function (response) {
                alert(response);
                fetchAndDisplayData();
            }
        });
    });

    // Search button operation
    // $('#search-btn').click(function () {
    //     var searchInput = $('#search-input').val();
    //     $.ajax({
    //         type: 'POST',
    //         url: 'backend.php',
    //         data: { action: 'search', keyword: searchInput },
    //         success: function (response) {
    //             $('#data-body').html(response);
    //         }
    //     });
    // });

    $(document).on('click', '.edit-btn', function () {
        var id = $(this).data('id');
        console.log('edit id',id);
        $.ajax({
            type: 'POST',
            url: 'backend.php',
            data: { action: 'fetch_single_id', id: id },
            dataType: 'json',
            success: function (response) {
                $('#id').val(response.id);
                $('#title').val(response.title);
                $('#description').val(response.description);
                $('#slug').val(response.slug);
                $('#category').val(response.category);
            }
        });
    });
// });
