    $(document).ready(function () {

        showLoad(true);
        /** Detiene , para mostrar alertSucess  */
        setTimeout(function () {
            $(document).keydown();
            showLoad(false);
        }, 200);

    });

