    $(document).ready(function () {

        showLoad(true);
        /** Detiene , para mostrar alertSucess  */
        setTimeout(function () {
            $(document).keydown();
            showLoad(false);
        }, 200);

    });


    $(function(){

        'use strict';
        $('#vmap').vectorMap({
            map: 'world_en',
            backgroundColor: '#a5bfdd',
            borderColor: '#818181',
            borderOpacity: 0.25,
            borderWidth: 1,
            color: '#f4f3f0',
            enableZoom: true,
            hoverColor: '#c9dfaf',
            hoverOpacity: null,
            normalizeFunction: 'linear',
            scaleColors: ['#b6d6ff', '#005ace'],
            selectedColor: '#c9dfaf',
            selectedRegions: null,
            showTooltip: true

        });


    });

