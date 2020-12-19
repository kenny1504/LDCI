
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
             var nombrelogico="Xxx"
             var parametros="dependent=yes,locationbar=no,scrollbars=yes,menubar=yes,resizable,screenX=80,screenY=80,width=900,height=1400";
             var htmltext="<embed width=100% height=100% type='application/pdf' src='data:application/pdf,"+escape(data) +"'></enbed>";
             var detailwindows= window.open("",nombrelogico,parametros);
             detailwindows.document.write(htmltext);
             detailwindows.document.close();
         });
 }
