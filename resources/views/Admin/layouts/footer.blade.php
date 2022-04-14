<!-- Main Footer -->
<footer class="main-footer">
    <!-- <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0-rc
    </div> -->
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ url('/design/AdminLTE') }}/plugins/jquery/jquery.min.js"></script>

<!-- Lazy Load -->
<script src="{{ url('/design/AdminLTE') }}/plugins/lazyload/lazyload.js"></script>

<!-- <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script> -->
@if(strtolower(langDirection()) == 'rtl')
<!-- Bootstrap 4 rtl -->
<script src="{{ url('/design/AdminLTE/RTL') }}/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ url('/design/AdminLTE/RTL') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{ url('/design/AdminLTE/RTL') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ url('/design/AdminLTE/RTL') }}/dist/js/adminlte.js"></script>
<!-- popper  -->
@else

<!-- Bootstrap -->
<script src="{{ url('/design/AdminLTE') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="{{ url('/design/AdminLTE') }}/dist/js/adminlte.js"></script>
@endif

<!-- OPTIONAL SCRIPTS -->
<!-- <script src="{{ url('/design/AdminLTE') }}/plugins/chart.js/Chart.min.js"></script> -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="{{ url('/design/AdminLTE') }}/dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="{{ url('/design/AdminLTE') }}/dist/js/pages/dashboard3.js"></script> -->


<script>
    $("img.lazyload").lazyload();
</script>

@stack('scripts')
</body>

</html>
