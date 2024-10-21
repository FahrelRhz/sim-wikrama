<link href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>

<script>
    function initializeDataTable(selector, ajaxUrl, columns) {
        return $(selector).DataTable({
            processing: true,
            serverSide: true,
            ajax: ajaxUrl,
            columns: columns,
        });
    }
</script>
