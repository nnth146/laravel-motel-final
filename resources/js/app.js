import './bootstrap';
import Alpine from 'alpinejs'
import mask from '@alpinejs/mask'

Alpine.plugin(mask)

window.Alpine = Alpine

document.addEventListener('alpine:init', () => {
    Alpine.data('imgPreview', () => ({
        src: null,
        previewFile() {
            let file = this.$el.files[0];
            if (!file === -1) return;
            this.src = null;
            let reader = new FileReader();

            reader.onload = e => {
                this.src = e.target.result;
            }

            reader.readAsDataURL(file);
        }
    }));
    Alpine.data('multiImgPreview', () => ({
        images: [],
        previewMultiFile() {
            let files = this.$el.files;
            this.images = [];

            if (files.length > 10) {
                window.alert('upload maximum 10 file');
                files = [];
                return;
            }

            for (let i = 0; i < files.length; i++) {
                if (!files[i] === -1) return;

                let reader = new FileReader();

                reader.onload = e => {
                    this.images.push(e.target.result);
                }

                reader.readAsDataURL(files[i]);
            }
        }
    }));

    Alpine.data('editProfile', () => ({
        canEdit: false,
        edit() {
            if(this.canEdit) return;

            this.canEdit = true;
            let end = this.$el.value.length;
            this.$el.setSelectionRange(end, end);
        },
        onCanEditChange(){
            this.$el.readOnly = !this.canEdit;
        },
        cancelEdit() {
            this.canEdit = false;
        }
    }));

    Alpine.data('liveSearch', () => ({
        rooms: null,
        searching: false,
        liveSearch() {
            var self = this;
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    self.rooms = JSON.parse(this.responseText);
                }
            }
            let url = "rooms/search?search=".concat(encodeURIComponent(self.$el.value));
            xhttp.open("GET", url, true);
            xhttp.send();
        },
    }));

    Alpine.data('liveSearchRooms', () => ({
        rooms: null,
        searching: false,
        liveSearch() {
            var self = this;
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    self.rooms = JSON.parse(this.responseText);
                }
            }
            let url = "/users/rooms/search?search=".concat(encodeURIComponent(self.$el.value));
            xhttp.open("GET", url, true);
            xhttp.send();
        },
    }));
});

Alpine.start()
