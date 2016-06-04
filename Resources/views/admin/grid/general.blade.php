@include('media::admin.grid.partials.content', ['isWysiwyg' => false])
<script>
    $(document).ready(function () {
        $('.jsInsertImage').on('click', function (e) {
            e.preventDefault();
            var mediaId = $(this).data('id'),
                filePath = $(this).data('file-path');
            window.opener.includeMedia(mediaId, filePath);
            window.close();
        });
    });
</script>
</body>
</html>
