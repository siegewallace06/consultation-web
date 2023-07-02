<div wire:ignore>
    <input id="{{ $trixId }}" type="hidden" name="content" value="{{ $value }}">
    <trix-editor wire:ignore class="trix-editor rounded border-gray-300" input="{{ $trixId }}"></trix-editor>

    <script>
        var trixEditor = document.getElementById("{{ $trixId }}")
        var mimeTypes = ["image/png", "image/jpeg", "image/jpg"];

        addEventListener("trix-blur", function(event) {
            @this.set('value', trixEditor.getAttribute('value'))
        });

        addEventListener("trix-file-accept", function(event) {
            if (!mimeTypes.includes(event.file.type)) {
                // file type not allowed, prevent default upload
                return event.preventDefault();
            }
        });

        addEventListener("trix-attachment-add", function(event) {
            uploadTrixImage(event.attachment);
        });
        addEventListener("trix-attachment-remove", function(event) {
            removeAttachment(event);
        });

        function removeAttachment(event) {
            @this.removeAttachments(event.attachment.attachment.previewURL);
        }

        function uploadTrixImage(attachment) {
            // upload with livewire
            @this.upload(
                'photos',
                attachment.file,
                function(uploadedURL) {

                    // We need to create a custom event.
                    // This event will create a pause in thread execution until we get the Response URL from the Trix Component @completeUpload
                    const trixUploadCompletedEvent = `trix-upload-completed:${btoa(uploadedURL)}`;
                    const trixUploadCompletedListener = function(event) {
                        attachment.setAttributes(event.detail);
                        window.removeEventListener(trixUploadCompletedEvent, trixUploadCompletedListener);
                    }

                    window.addEventListener(trixUploadCompletedEvent, trixUploadCompletedListener);

                    // call the Trix Component @completeUpload below
                    @this.call('completeUpload', uploadedURL, trixUploadCompletedEvent);
                },
                function() {},
                function(event) {
                    attachment.setUploadProgress(event.detail.progress);
                },

            )
            // complete the upload and get the actual file URL
        }
    </script>
</div>
