
<link rel="stylesheet" href="{{asset("assets/bracket/lib/jqvmap/jqvmap.css")}}"  >


    <div>
        <div id="vmap" class="ht-250 ht-sm-350 ht-md-450 bg-gray-300 rounded"></div>
    </div>



<script src="{{asset("assets/bracket/lib/highlightjs/highlight.pack.js")}}" ></script>
<script src="{{asset("assets/bracket/lib/jqvmap/jquery.vmap.js")}}" ></script>
<script src="{{asset("assets/bracket/lib/jqvmap/maps/jquery.vmap.world.js")}}" ></script>
<script src="{{asset("assets/bracket/js/jquery.vmap.sampledata.js")}}" ></script>

<script>
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
</script>
