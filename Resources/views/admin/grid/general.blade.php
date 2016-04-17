@include('media::admin.grid.partials.content')
<script>
    $(document).ready(function () {
        $('.jsInsertImage').on('click', function (e) {
            e.preventDefault();
            var $this = $(this), mediaId = $this.data('id'), mediaUrl = $this.data('file');
            window.opener.includeMedia(mediaId, mediaUrl);
            window.close();
        });
    });
</script>
</body>
</html>
