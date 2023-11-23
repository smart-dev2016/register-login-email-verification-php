<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  $(document).ready(function () {
    $('.alert-close').on('click', function (c) {
      $('.main-mockup').fadeOut('slow', function (c) {
        $('.main-mockup').remove();
      });
    });
  });
</script>

</body>

</html>