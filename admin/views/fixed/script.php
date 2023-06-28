<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>


<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<script>
  let url = window.location.href;

  console.log(url);
  if (url.includes("admin/index.php") || url.include("admin/index.php?page=home")) {
    $(function () {
      $.ajax({
        url:"../models/getAdminStats.php",
        method:"POST",
        success:function (data){
          let stat = JSON.parse(data);
          let arrayStats = Object.values(stat);

          var areaChartData = {
            labels: ['Home', 'Shop', 'Profile', 'Edit profile', 'About', 'Author', 'Single', 'Contact', 'Checkout'],
            datasets: [
              {
                label: 'Home',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: arrayStats
              }
            ]
          }

          //-------------
          //- BAR CHART -
          //-------------
          var barChartCanvas = $('#barChart').get(0).getContext('2d')
          var barChartData = $.extend(true, {}, areaChartData)
          var temp0 = areaChartData.datasets[0]

          barChartData.datasets[0] = temp0

          var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false
          }

          new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
          })
        }
      });

    });
  }

  $(document).ready(function () {
    $(".btnDelete").click(function () {
      console.log("brisanje");
      let id = $(this).data("id");
      let name = $(this).data("name");
      let deleteForm = document.forms["deleteForm"];
      deleteForm[name].value = id;
    });


  });
</script>
