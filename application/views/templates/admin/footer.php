    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.0.2
        </div>
        <strong>Copyright &copy; <?php echo date('Y')?> <a href="<?php echo base_url() ?>">Payroll-Carstore</a>.</strong> All rights
        reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php echo asset_plugin_js('jquery/jquery.min.js')?>
<?php echo asset_plugin_js('bootstrap/js/bootstrap.bundle.min.js')?>
<?php echo asset_plugin_js('select2/js/select2.full.min.js')?>
<?php echo asset_plugin_js('bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')?>
<?php echo asset_plugin_js('moment/moment.min.js')?>
<?php echo asset_plugin_js('inputmask/min/jquery.inputmask.bundle.min.js')?>
<?php echo asset_plugin_js('datatables/jquery.dataTables.min.js')?>
<?php echo asset_plugin_js('datatables-bs4/js/dataTables.bootstrap4.min.js')?>
<?php echo asset_plugin_js('datatables-rowgroup/js/rowGroup.bootstrap4.min.js')?>
<?php echo asset_plugin_js('daterangepicker/daterangepicker.js')?>
<?php echo asset_plugin_js('bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')?>
<?php echo asset_plugin_js('tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')?>
<?php echo asset_plugin_js('bootstrap-switch/js/bootstrap-switch.min.js')?>
<?php echo asset_plugin_js('sweetalert2/sweetalert2.min.js')?>
<?php echo asset_js('adminlte.min.js')?>
<?php echo asset_js('demo.js')?>
<?php echo asset_plugin_js('icheck/icheck.min.js')?>
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2({ allowClear: true })

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

  })

  $(document).ready(function(){
    <?php if($filejs){ ?>
      $.getScript("<?php echo $filejs ?>", function(data, status){
      }).fail(function(){
        console.log("js not found");
      });
    <?php } ?>
    
    $("#imgFile").change(function() {
      readURL(this);
    });
  });

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $('#showImage').attr('src', e.target.result);
      }
      
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
</body>
</html>