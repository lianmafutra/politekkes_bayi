<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
  
</head>
<style>
    th {
  border-top: 1px solid #dddddd;
  border-bottom: 1px solid #dddddd;
  border-right: 1px solid #dddddd;
  background-color: cornflowerblue
}

.button {
    
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 10px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 12px;

  cursor: pointer;
}
.button{border-radius: 12px;}
th:first-child {

  border-left: 1px solid #dddddd;
}
    </style>
<body>
    
    <table id="table_id" class="cell-border"style="width:100%">
        <thead>
            <tr>
                <th style="width: 5px">No</th>
                <th>Nama Balita</th>
                <th>Hasil Pertumbuhan</th>
                <th>Hasil Perkembangan</th>
                <th style="width: 5px">Aksi</th>
            </tr>
        </thead>
        <tbody>
          
        </tbody>

    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
   
<script>

let id = "";

$( document ).ready(function() {
    $(document).on('click', '.detail', function (e) {
        e.preventDefault();
        id= $(this).attr('data-id');
        AndroidFunction.getDataWebview(id);
    });
    
$('#table_id').DataTable({
        processing: true,
        paginate: false,
        serverSide: true,
        url: 'api/rekap/harian/',
        columns: [
            { data: 'DT_RowIndex'},
            { data: 'nama_balita', },
            { data: 'kode_pertumbuhan' },
            { data: 'kode_tindakan_perkembangan'},
            { data: 'aksi'},
        ]
    });

  
});
    </script>
</body>
</html>