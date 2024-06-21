<main class="registro">
    <h2 class="registro__heading"><?php echo $titulo; ?></h2>
    <p class="registro__descripcion">Elige tu Plan</p>

    <div class="paquetes__grid">
        <div <?php aos_animacion(); ?> class="paquete">
            <h3 class="paquete__nombre">Pase Gratis</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso Virtual a DevWebCamp</li>
            </ul>

            <p class="paquete__precio">$ 0</p>

            <form action="/finalizar-registro/gratis" method="POST">
                <input type="submit" value="Inscripción Gratis" class="paquetes__submit">
            </form>
        </div>
        <div <?php aos_animacion(); ?> class="paquete">
            <h3 class="paquete__nombre">Pase Presencial</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso Presencial a DevWebCamp</li>
                <li class="paquete__elemento">Pase por 2 días</li>
                <li class="paquete__elemento">Acceso a talleres y conferencias</li>
                <li class="paquete__elemento">Acceso a la grabaciones</li>
                <li class="paquete__elemento">Camisa del Evento</li>
                <li class="paquete__elemento">Comida y Bebida</li>
            </ul>

            <p class="paquete__precio">$ 199</p>

            <div style="text-align: center;">
                <div id="paypal-container-PVHQCMRVVN6QA"></div>
            </div>
        </div>
        <div <?php aos_animacion(); ?> class="paquete">
            <h3 class="paquete__nombre">Pase Virtual</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso Virtual a DevWebCamp</li>
                <li class="paquete__elemento">Pase por 2 días</li>
                <li class="paquete__elemento">Acceso a talleres y conferencias</li>
                <li class="paquete__elemento">Acceso a la grabaciones</li>
            </ul>

            <p class="paquete__precio">$ 49</p>
        </div>
    </div>
</main>

<script <script
    src="https://www.paypal.com/sdk/js?client-id=Aaow0J2pbxg-viEznEJBBaEWkZRfYHnrMfnEQvkBLhQ_LqXvDz5VViRnJtDvum4HCJ-1Exh30vaZNWbj&components=buttons">
</script>
<script>
paypal.Buttons({
    style: {
        layout: 'vertical',
        color: 'blue',
        shape: 'pill',
        label: 'buynow'
    },
    createOrder: function(data, actions) {

        return actions.order.create({
            purchase_units: [{
                description: '1',
                amount: {
                    currency_code: 'USD',
                    value: '199.00'
                }
            }]
        });
    },
    onApprove: function(data, actions) {
        return actions.order.capture().then(function(orderData) {
            //Full available details
            const datos = new FormData();
            datos.append('paquete_id', orderData.purchase_units[0].description);
            datos.append('pago_id', orderData.purchase_units[0].payments.captures[0].id);

            fetch('/finalizar-registro/pagar', {
                    method: 'POST',
                    body: datos
                })
                .then(respuesta => respuesta.json())
                .then(resultado => {
                    if (resultado.resultado) {
                        actions.redirect(
                            'http://localhost:3000/finalizar-registro/conferencias');
                    }
                });
        });
    },
    onError: function(err) {
        console.log(err);
    },
    onCancel: function(data) {
        console.log('OnCancel', data);
    }
}).render('#paypal-container-PVHQCMRVVN6QA');
</script>