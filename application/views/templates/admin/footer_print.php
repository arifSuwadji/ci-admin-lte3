
  <footer class="main-footer" style="border: none; text-align:center; font-size:10px">
  </footer>

  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="/assets/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/assets/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="/assets/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="/assets/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="/plugins/input-mask/jquery.inputmask.js"></script>
<script src="/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- DataTables -->
<script src="/assets/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/assets/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="/plugins/datatables-rowsgroup/dataTables.rowsGroup.js"></script>
<!-- Morris.js charts -->
<script src="/assets/raphael/raphael.min.js"></script>
<script src="/assets/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="/assets/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<!--script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script-->
<!-- jQuery Knob Chart -->
<script src="/assets/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="/assets/moment/min/moment.min.js"></script>
<script src="/assets/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="/assets/bootstrap-datepicker-mobile/bootstrap-datepicker-mobile.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="/plugins/bootstrap-wysihtml5/dist/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="/assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/assets/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/assets/admin-lte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/assets/admin-lte/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/assets/admin-lte/dist/js/demo.js"></script>
<script src="/sweetalert/dist/sweetalert2.min.js"></script>
<!-- jquery price format -->
<script src="/plugins/price/jquery.price_format.min.js"></script>
<!-- Responsive Bootstrap Toolkit -->
<script src="/assets/responsive-bootstrap-toolkit/dist/bootstrap-toolkit.min.js"></script>
<script>
$(function(){
  'use strict';
  $('[data-enable="expandOnHover"]').trigger('click');

  $('.select2').select2({ allowClear: true });

  $('[data-mask]').inputmask();

  $('.date-picker').on('changeDate', function(ev){
    $(this).datepicker('hide');
  });
});
</script>
</body>
</html>
