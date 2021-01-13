<style>
    .carousel-indicators .active {
        background-color: blue!important;
    }

    .carousel-control-next .carousel-control-prev
    {
        background-color: blue!important;
    }

    .slide {width: 30%!important;}

    .carousel-control-prev,
    .carousel-control-next{
        height: 50px;
        width: 50px;
        outline:white;
        background-size: 100%, 100%;
        border-radius: 50%;
        border: 1px solid white;
        background-color:white;
    }

    .carousel-control-prev-icon {
        background-image:url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23009be1' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E");
        width: 30px;
        height: 48px;
    }
    .carousel-control-next-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23009be1' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E");
        width: 30px;
        height: 48px;
    }
    .carousel-caption{
        background-color:#009be1;
        opacity: 70%;
    }

    /* Make the tag position relative to the figure */
    .figure.tag {
        position: relative;
        z-index: 1;
    }
    /* set the base styles all tags should use */
    .figure.tag::before {
        position: absolute;
        top: 10%;
        display: block;
        color: white;
        padding: 0.5rem 1rem;
        font-weight: bold;
    }


    .bb::before, .bb::after, .bb {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        content: "Nos Quedamos Sin Productos :O";
    }

    .bb {
        width: 200px;
        height: 200px;
        margin: auto;
        background: url("//ldci.cargologisticsintermodal.com/LDCI/img/Logo-Intermodal.png") no-repeat 50%/70% rgba(0, 0, 0, 0.1);
        color: #4444dd;
        box-shadow: white;
    }
    .bb::before, .bb::after {
        content: "";
        z-index: -1;
        margin: -5%;
        box-shadow: inset 0 0 0 2px;
        animation: clipMe 8s linear infinite;
    }
    .bb::before {
        animation-delay: -4s;
    }
    .bb:hover::after, .bb:hover::before {
        background-color: lightskyblue;
    }

    @keyframes clipMe {
        0%, 100% {
            clip: rect(0px, 220px, 2px, 0px);
        }
        25% {
            clip: rect(0px, 2px, 220px, 0px);
        }
        50% {
            clip: rect(218px, 220px, 220px, 0px);
        }
        75% {
            clip: rect(0px, 220px, 220px, 218px);
        }
    }
    html,
    body {
        height: 100%;
    }

    body {
        position: relative;
        background-color: white;
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

</style>

<script src="{{asset("LDCI/js/productoUsuario.js")}}" ></script>





