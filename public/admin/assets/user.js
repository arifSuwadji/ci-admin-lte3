let ajaxJson = $("#dataJson").val();
let urlEditData = $("#editData").val();
let hapusJson = $("#hapusJson").val();
let urlGantiPassword = $("#gantiPassword").val();
let adminGrup = $("#adminGrup").val();
let sessionIdAdmin = $("#sessionIdAdmin").val();
let table = $('#tableData').DataTable({
    'paging'      : true,
    'lengthChange': true,
    'searching'   : true,
    'ordering'    : true,
    'autoWidth'   : false,
    'info'        : true,
    'processing'  : true,
    'serverSide'  : true,
    'ajax' : ajaxJson,
    'columns' : [
      {
        "mRender": function(data, type, full){
            return '<span class="pull-right">'+full['pengguna_id']+'</span>';
        }
      },
      { "data": "nama_pengguna" },
      { "data": "email"},
      { "data": "nama_grup"},
      { "mRender": function(data, type, full){
          if(adminGrup == 1 || sessionIdAdmin == full['pengguna_id'] && full[19]){
            return '<a href="javascript:void(0);" onClick="gantiPassword('+full['pengguna_id']+')"<button class="btn btn-info btn-sm text-bold">Ganti Password</button>';
          }else{
            return '<a href="javascript:void(0);" onClick="javascript:void(0)"<button class="btn btn-default btn-sm text-bold" disabled>Ganti Password</button>';
          }
      }},
      { "mRender": function(data, type, full){
          let aksesEdit = ""; let aksesHapus = "";
          let editData = `editData(${full['pengguna_id']})`;
          let hapusData = `hapusData(${full['pengguna_id']})`;
          let colorButtonEdit = "btn-warning";
          let colorButtonHapus = "btn-danger";
          if(!full[10]){
              aksesEdit = "disabled";
              editData = "";
              colorButtonEdit = "btn-default";
          }
          if(!full[12]){
              aksesHapus = "disabled";
              hapusData = "";
              colorButtonHapus = "btn-default";
          }
          return `<div class="btn-group dropleft">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-ellipsis-v"></span></button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="javascript:void(0);" onClick="${editData}">
                            <button class="btn ${colorButtonEdit} btn-block btn-sm text-bold ${aksesEdit}">Edit</button>
                        </a>
                        <a class="dropdown-item" href="javascript:void(0);" onClick="${hapusData}">
                            <button class="btn ${colorButtonHapus} btn-block btn-sm text-bold ${aksesHapus}">Hapus</button>
                        </a>
                    </div>
                </div>`;
      }}
    ],
    language: {
        "searchPlaceholder": "Cari ",
        "sSearch": "",
        "lengthMenu": "&emsp;Menampilkan _MENU_ per halaman",
        "processing": "<span class='fa fa-spinner fa-spin fa-lg'></span><br>Memproses data...",
        "info": "&emsp;Menampilkan _START_ - _END_ dari _TOTAL_ data",
        "zeroRecords": "Maaf - tidak ada yang ditemukan",
        "infoEmpty": "&emsp;Tidak ada data yang tersedia",
        "infoFiltered": "&emsp;(filter dari _MAX_ total data)",
        "paginate": {
            "first": "Pertama",
            "last": "Terakhir",
            "next": "Selanjutnya",
            "previous": "Sebelumnya"
        },
    },
  });

table.on( 'order.dt search.dt', function () {
    table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        //cell.innerHTML = i+1;
        cell.innerHTML = i+1;
    } );
} ).draw();

table.on('draw.dt', function(){
    table.column(0).nodes().each( function (cell, i) {
        let info = table.page.info();
        let page = info.page;
        let length = table.page.len();
        if(page >= 1){
            page = page * length;
        }
        cell.innerHTML = page+i+1;
    } );
});

function gantiPassword(idAdmin){
    console.log("id admin "+idAdmin);
    $(location).attr("href", urlGantiPassword+'/'+idAdmin);
}

function editData(idAdmin){
    console.log("id admin "+idAdmin);
    $(location).attr("href", urlEditData+'/'+idAdmin);
}

function hapusData(idAdmin){
    console.log("id admin "+idAdmin);
    $.post(hapusJson, {pengguna_id: idAdmin}, function(data, status){
        console.log(data);
        if(data.status == 'success'){
            Swal.fire({
              position: 'top-end',
              type: 'success',
              title: 'Data Telah dihapus',
              showConfirmButton: false,
              timer: 2000
            }).then(function(){
              table.ajax.reload( null, false );
            });
          }else{
            Swal.fire({
              position: 'top-end',
              type: 'error',
              title: 'Data Tidak dihapus',
              showConfirmButton: false,
              timer: 2000
            }).then(function(){
              table.ajax.reload( null, false );
            });
        }
    }).fail(function(){
        Swal.fire({
            position: 'top-end',
            type: 'warning',
            title: 'Url tidak ditemukan',
            showConfirmButton: false,
            timer: 2000
        })
    });
}

  function toRp(a,b,c,d,e){e=function(f){return f.split('').reverse().join('')};b=e(parseInt(a,10).toString());for(c=0,d='';c<b.length;c++){d+=b[c];if((c+1)%3===0&&c!==(b.length-1)){d+=',';}}return'\t'+e(d)+''}
  
  // Wrap IIFE around your code
  (function($, viewport){
      $(document).ready(function() {
  
          // Executes only in XS breakpoint
          if(viewport.is('xs')) {
              // ...
          }
  
          // Executes in SM, MD and LG breakpoints
          if(viewport.is('>=sm')) {
              // ...
              /*let column = table.column(6);
              column.visible(!column.visible());*/
          }
  
          // Executes in XS and SM breakpoints
          if(viewport.is('<md')) {
              // ...
              /*let column = table.column(0);
              column.visible(!column.visible());*/
          }
  
          // Execute code each time window size changes
          $(window).resize(
              viewport.changed(function() {
                  if(viewport.is('xs')) {
                      // ...
                  }
              })
          );
      });
  })(jQuery, ResponsiveBootstrapToolkit);
  