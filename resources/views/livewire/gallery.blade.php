<div>
    <div>
        <div class="row">
        @foreach ($collections as $img)
            <div class="col col-12 col-sm-6 col-md-2 mb-3">
                <a target="_blank" href="/galleries/{{ $img->name }}"><img class="img-thumbnail" style="height:200px;width:200px;object-fit:cover;object-position:center;" src="/galleries/thumb_{{ $img->name }}"></a>
            </div>
        @endforeach
        </div>
        {{ $collections->links() }}
    </div>
    <form wire:submit.prevent="save">
        <div style="width:100%;display:flex;flex-direction:row;align-items:center;justify-content:flex-start;">
        @foreach($photos as $index => $photo)
            @if ($index == 0)
                <img id="img-preview" width="300px;" height="auto" src="{{ $photo->temporaryUrl() }}">
            @else
                <img id="img-preview" src="{{ $photo->temporaryUrl() }}">
            @endif
        @endforeach
        </div>
        <input id="selector" type="file" accept="image/*">
        @error('photo') <span class="error">{{ $message }}</span> @enderror
        <button class="btn btn-sm btn-primary" type="submit">Save Photo</button>
    </form>
    <script>
        let normalBlob;
        document.addEventListener('livewire:load', function () {
            @this.on('upload:finished', () => {
                console.log(@this.photos)
            })
            @this.on('refresh', () => {
                document.location.search = ''
            })
        })
        document.getElementById('selector').addEventListener('change', (evt) => {
            if (evt.target.files.length > 0) {
                const width = 200;
                const reader = new FileReader();
                const img = new Image();
                let fileType, fileName;

                img.onload = function () {
                    var oc = document.createElement('canvas'), octx = oc.getContext('2d');
                    oc.width = img.width;
                    oc.height = img.height;
                    octx.drawImage(img, 0, 0);
                    while (oc.width * 0.5 > width) {
                       oc.width *= 0.5;
                       oc.height *= 0.5;
                       octx.drawImage(oc, 0, 0, oc.width, oc.height);
                    }
                    oc.width = width;
                    oc.height = oc.width * img.height / img.width;
                    octx.drawImage(img, 0, 0, oc.width, oc.height);
                    oc.toBlob((thumbBlob) => {
                        let file = new File([thumbBlob], fileName, { type: fileType, lastModified:new Date().getTime() });
                        @this.uploadMultiple('photos', [normalBlob, file]);
                    }, fileType)
                }

                reader.addEventListener("load", () => {
                    img.src = reader.result
                }, false);

                if (evt.target.files[0]) {
                    normalBlob = evt.target.files[0];
                    fileName = evt.target.files[0].name;
                    fileType = evt.target.files[0].type;
                    reader.readAsDataURL(evt.target.files[0]);
                }
            }
        });
    </script>
</div>
