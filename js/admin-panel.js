    $(document).ready(function () {
      $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
        $('#sidebarCollapse').toggleClass('active');
      })
    });

    $(document).ready(function () {
      $('#sidebarCollapseInside').on('click', function () {
        $('#sidebar').toggleClass('active');
      })
    });