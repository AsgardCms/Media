@include('media::admin.grid.partials.content')
<script>
    $(document).ready(function () {
        $('.jsInsertImage').on('click', function (e) {
            e.preventDefault();
            var mediaId = $(this).data('id');
            window.opener.includeMedia(mediaId);
            window.close();
        });
    });
</script>
</body>
</html>
