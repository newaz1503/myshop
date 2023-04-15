Vue.mixin({
    computed: {
        years() {
            const year = new Date().getFullYear()
            const yearCount = 2019 - (year - 1990);
            return Array.from({ length: year - yearCount }, (value, index) => 1990 + index)
        }
    },
    methods: {
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

        // ================= print html page =================
        print: function (elementId, documentTitle) {
            $(".action").css("display", "none");
            $(".base-table-thead").removeClass("bg-purple text-white");
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
        },
        PDFDownloader(downloadArea,filename) {
            console.log(downloadArea)
            const doc = new jsPDF();
            autoTable(doc, {html: downloadArea});
            doc.save(filename + ".pdf");
            // setTimeout(() => $(".action").show(), 300);
        },
    }
})
