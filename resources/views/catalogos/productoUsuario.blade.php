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
        z-index: 999;
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

</style>





<script src="{{asset("LDCI/js/productoUsuario.js")}}" ></script>




