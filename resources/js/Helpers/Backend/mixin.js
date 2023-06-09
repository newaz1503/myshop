Vue.mixin({
    computed: {
        years() {
            const year = new Date().getFullYear()
            const yearCount = 2019 - (year - 1990);
            return Array.from({ length: year - yearCount }, (value, index) => 1990 + index)
        }
    },
    methods: {
        // ================= Set Breadcrumbs=================
        setBreadcrumbs(model, type, model_name) {
            let modelName = model_name ? model_name : model;
            if (type == 'index') {
                var breadcrumb = [
                    { route: model + ".index", title: modelName + " List" }
                ];
            } if (type == 'create') {
                var breadcrumb = [
                    { route: model + ".index", title: modelName + " List" },
                    { route: model + ".create", title: modelName + " Create" }
                ];
            } else if (type == 'edit') {
                var breadcrumb = [
                    { route: model + ".index", title: modelName + " List" },
                    { route: model + ".edit", title: modelName + " Edit" }
                ];
            } else if (type == 'view') {
                var breadcrumb = [
                    { route: model + ".index", title: modelName + " List" },
                    { route: model + ".show", title: modelName + " View" }
                ];
            }
            breadcrumbs.dispatch("setBreadcrumbs", breadcrumb);
        },

        // ================= notification =================
        notification(msg, type) {
            if (type == 'success') {
                this.flashMessage.success({
                    title: "Success !!",
                    icon: this.$root.baseurl + "/admin/images/success.svg",
                    message: msg
                });
            } else if (type == 'error') {
                this.flashMessage.error({
                    title: "Error !!",
                    icon: this.$root.baseurl + "/admin/images/error.svg",
                    message: msg
                });
            } else if (type == 'warning') {
                this.flashMessage.warning({
                    title: "Warning !!",
                    icon: this.$root.baseurl + "/admin/images/warning.svg",
                    message: msg
                });
            }
        },

        // ================= scroll top =================
        scrollTop(x = 0, y = 0) {
            window.scrollTo(x, y)
        },

        // ================= SHOW IMAGE =================
        showImage(e, imagePath, dataPath, fileClass = null, pdf = null) {
            $("." + fileClass).children('.custom-file-label').html("File attached");
            let files = e.target.files || e.dataTransfer.files;
            if (files.length) {
                this.image[imagePath] = e.target.files[0];
                if (dataPath) {
                    if (pdf) {
                        this.data[dataPath] = this.$root.attach;
                    } else {
                        this.data[dataPath] = URL.createObjectURL(e.target.files[0]);
                    }
                }
            }

        },

        // ================= SHOW GLOBALLY IMAGE =================
        showImageGlobal(e, imagePath, dataPath, fileClass = null, pdf = null) {
            $("." + fileClass).children('.custom-file-label').html("File attached");
            let files = e.target.files || e.dataTransfer.files;
            if (files.length) {
                this.$parent.data[dataPath] = e.target.files[0];
                if (dataPath) {
                    if (pdf) {
                        this.$parent.image[dataPath] = this.$root.attach;
                    } else {
                        this.$parent.image[dataPath] = URL.createObjectURL(e.target.files[0]);
                    }
                }
            }
        },
        // ================= SHOW CROP IMAGE =================
        showCropImage(event, field, fileClass = null) {
            $("." + fileClass).children('.custom-file-label').html("File attached");
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = e => {
                    this.$parent.image[field] = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
            this.$bvModal.show('canvas')
        },

        // ================= print html page =================
        print: function (elementId, documentTitle) {
            $(".action").css("display", "none");
            $(".base-table-thead").removeClass("bg-purple text-white");

            setTimeout(() => {
                $(".action").show();
                $(".base-table-thead").addClass("bg-purple text-white");
            }, 500);
            const prtHtml = document.getElementById(elementId).innerHTML;
            let customStyle = '<style>table{border-collapse: collapse;}</style>'
            let stylesHtml = '';
            for (const node of [...document.querySelectorAll('link[rel="stylesheet"], style')]) {
                stylesHtml += node.outerHTML;
            }
            const WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
            WinPrint.document.write(`<!DOCTYPE html>
                <html>
                <head>
                <title>${documentTitle}</title>
                ${stylesHtml}
                ${customStyle}
                </head>
                <body>
                    ${prtHtml}
                </body>
                </html>`);
            WinPrint.document.close();
            WinPrint.focus();
            WinPrint.print();
            // WinPrint.close();
        },
        printHandler(sectionId,title) {
            var printContents = document.getElementById(sectionId).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            document.title = title
            window.print();
            document.body.innerHTML = originalContents;
            window.location.reload()
        }
    }
})
