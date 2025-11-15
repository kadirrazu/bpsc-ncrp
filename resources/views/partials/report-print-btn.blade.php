<button class="btn btn-secondary" onclick="printReportDiv('div-to-print')">
    Print Report
</button>

<script>
    function printReportDiv() {
        let divContents = document.getElementById("div-to-print").innerHTML;
        let printWindow = window.open('', '', 'height=1000, width=1000');
        printWindow.document.open();
        printWindow.document.write(`
            <html>
            <head>
                <title>Report Print</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 30px; }
                    h1 { color: #333; }
                </style>
                <!-- Icons. Uncomment required icon fonts -->
                <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

                <!-- Core CSS -->
                <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
                <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
                <link rel="stylesheet" href="{{ asset('assets/css/dataTables.dataTables.min.css') }}" />
                <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
            </head>
            <body>
                ${divContents}
            </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    }
</script>