
    function rpt_vendedores()
    {

        showLoad(true);
        var _token= $('input[name=_token]').val();

            $.ajax({
                type:"post",
                url: '/vendedores', //llamada a la ruta
                global:false,
                data:{
                    _token:_token
                }
            })
            .done(function(data,textstatus,jqXHR )
            {
                showLoad(false);
                var nombrelogico="pdf"
                var parametros="dependent=yes,locationbar=no,scrollbars=yes,menubar=yes,resizable,screenX=80,screenY=80,width=900,height=1400";
                var htmltext="<embed width=100% height=100% type='application/pdf' src='data:application/pdf,"+escape(data) +"'></enbed>";
                var detailwindows= window.open("",nombrelogico,parametros);
                if(detailwindows==null)
                {
                    alertError("No se puede mostrar PDF, ventana emergente bloqueada.");
                    alertError("Click en 🔒 para habilitar ventana emergente.");
                }
                else
                {
                    detailwindows.document.write(htmltext);
                    detailwindows.document.close();
                }
            });
    }

    function rpt_clientes()
    {

        showLoad(true);
        var _token= $('input[name=_token]').val();

            $.ajax({
                type:"post",
                url: '/clientes', //llamada a la ruta
                global:false,
                data:{
                    _token:_token
                }
            })
            .done(function(data,textstatus,jqXHR )
            {
                showLoad(false);
                var nombrelogico="pdf"
                var parametros="dependent=yes,locationbar=no,scrollbars=yes,menubar=yes,resizable,screenX=80,screenY=80,width=900,height=1400";
                var htmltext="<embed width=100% height=100% type='application/pdf' src='data:application/pdf,"+escape(data) +"'></enbed>";
                var detailwindows= window.open("",nombrelogico,parametros);
                if(detailwindows==null)
                {
                    alertError("No se puede mostrar PDF, ventana emergente bloqueada.");
                    alertError("Click en 🔒 para habilitar ventana emergente.");
                }
                else
                {
                    detailwindows.document.write(htmltext);
                    detailwindows.document.close();
                }
            });
    }

    function rpt_productos()
    {

        showLoad(true);
        var _token= $('input[name=_token]').val();

            $.ajax({
                type:"post",
                url: '/productos', //llamada a la ruta
                global:false,
                data:{
                    _token:_token
                }
            })
            .done(function(data,textstatus,jqXHR )
            {
                showLoad(false);
                var nombrelogico="pdf"
                var parametros="dependent=yes,locationbar=no,scrollbars=yes,menubar=yes,resizable,screenX=80,screenY=80,width=900,height=1400";
                var htmltext="<embed width=100% height=100% type='application/pdf' src='data:application/pdf,"+escape(data) +"'></enbed>";
                var detailwindows= window.open("",nombrelogico,parametros);
                if(detailwindows==null)
                {
                    alertError("No se puede mostrar PDF, ventana emergente bloqueada.");
                    alertError("Click en 🔒 para habilitar ventana emergente.");
                }
                else
                {
                    detailwindows.document.write(htmltext);
                    detailwindows.document.close();
                }
            });
    }

