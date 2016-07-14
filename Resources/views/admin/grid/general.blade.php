@include('media::admin.grid.partials.content', ['isWysiwyg' => false])
<script>
    $(document).ready(function () {
        $('.jsInsertImage').on('click', function (e) {
            e.preventDefault();
            var mediaId = $(this).data('id'),
                filePath = $(this).data('file-path');
            if(window.opener.old) {
                if(window.opener.single) {
                    window.opener.includeMediaSingleOld(mediaId, filePath);
                    window.close();
                } else {
                    window.opener.includeMediaMultipleOld(mediaId, filePath);
                }
            } else {
                if(window.opener.single) {
                    window.opener.includeMediaSingle(mediaId, filePath);
                    window.close();
                } else {
                    window.opener.includeMediaMultiple(mediaId, filePath);
                }
            }
        });
    });
</script>
</body>
</html>
