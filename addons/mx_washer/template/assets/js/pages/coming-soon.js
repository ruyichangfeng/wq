$(document).ready(function() {
      $('#counter').countdown('2017/09/27', function(event) {
          $(this).php(event.strftime('%d:%H:%M:%S'));
      });
});