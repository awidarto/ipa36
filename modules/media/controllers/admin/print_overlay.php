print view

<script language=javascript>
    function printWindow() {
        bV = parseInt(navigator.appVersion);
        if (bV >= 4) window.print();
    }
    printWindow();
    window.close();
</script>