<link rel="stylesheet" href="/assets/stylesheets/imgUploader.min.css">
<script src="/assets/javascripts/imgUploader.min.js"></script>
<script>
    var uploadUrl = '{{ route('upload') }}';
    function initPictureList(handle, id, name, srcUrl, thumbUrl, withDelete) {
        $("#"+id).before('<div class="imguploader-doneitem" style="width: 100px;height: 100px">\n' +
            '      <a class="fancybox" href="'+srcUrl+'" rel="group">\n' +
            '        <img src="'+thumbUrl+'">\n' +
            '      </a>\n' + (withDelete? '      <span class="imguploader-delbtn">×</span>\n': '') +
            '      <span class="imguploader-progress" style="width: 100%; display: none;"></span>\n' +
            '      <input name="'+name+'_preview[]" class="'+name+'_preview" value="'+srcUrl+'" type="hidden">\n' +
            '      <input name="'+name+'_thumb[]" class="'+name+'_thumb" value="'+thumbUrl+'" type="hidden">\n' +
            '    </div>')
        $('#' + handle.target).find('.imguploader-numcount').text(handle.container.children('.imguploader-doneitem').length + '/' + handle.imgNum);
        if(handle.container.children('.imguploader-doneitem').length == handle.imgNum ){
            handle.handler.fadeOut();
        }
    }
</script>