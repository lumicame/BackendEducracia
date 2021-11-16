<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">


        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <center>

           <!--  <form>
        <script
            src="https://checkout.epayco.co/checkout.js"
            class="epayco-button"
            data-epayco-key="491d6a0b6e992cf924edd8d3d088aff1"
            data-epayco-amount="50000"
            data-epayco-name="Vestido Mujer Primavera"
            data-epayco-description="Vestido Mujer Primavera"
            data-epayco-currency="cop"
            data-epayco-country="co"
            data-epayco-test="true"
            data-epayco-external="true"
            data-epayco-response="https://ejemplo.com/respuesta.html"
            data-epayco-confirmation="https://ejemplo.com/confirmacion">
        </script>
    </form> -->
            <form action="https://checkout.wompi.co/p/" method="GET">
              <!-- OBLIGATORIOS -->
              <input type="hidden" name="public-key" value="pub_test_tcUoNwMeZKAvaur0E0AHYhZ5mOxcrbP7" />
              <input type="hidden" name="currency" value="COP" />
              <h3><label>¿Cuanto desea aportar?</label></h3>
              <br>
              <input type="hidden" id="input" name="amount-in-cents" value="">
                <input type="text" inputmode="numeric" id="amount"  value="" style="
                border-radius: 5px;
                font-size: 20px;
                padding: 10px;
                margin-bottom: 10px;
            ">
            <br>
            <input type="hidden" name="customer-data:email" value="{{$email}}" />
            <input type="hidden" name="redirect-url" value="http://31.220.52.235/save" />
              <input type="hidden" name="reference" value="{{$reference}}" />
              <!-- OPCIONALES -->
              <button type="submit" style="
                background: #8806ce;
                color: white;
                border-radius: 5px;
                font-size: 20px;
                border: none;
                padding: 10px;
            ">Aportar</button>
        </form>
    </center>
        <!-- jQuery -->
        <script src="{{asset('js/jquery.min.js')}}"></script>
        <script>
            var ammount=0;
            $("#amount").keyup(function(e){ 
                 $(event.target).val(function (index, value ) {
                    var val=value.replace(/\D/g, "")
                        .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
                       console.log("Puntos "+val.replace(/,/g, '')); 
                       $("#input").val(val.replace(/,/g, '')+"00")
            return val;
        });
               /* var sin=$("#amount").val();
                sin=Intl.NumberFormat().format(sin);
                console.log("Puntos "+sin);
                sin.replace(/./g, ',');
                console.log("Sin "+sin);*/
               // $("#amount").val(Intl.NumberFormat().format(sin));
                
                
               // $("#input").val(Intl.NumberFormat().format($("#amount").val())+"00")
        });
            

        </script>
    </body>

</html>