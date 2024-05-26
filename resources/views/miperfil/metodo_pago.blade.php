<div id="metodoPagoForm" class="modal">
    <form class="modal-content animate" action="{{ route('compras_coches.store') }}" method="POST">
        @csrf
        <div class="container">
            <label for="metodo_pago"><b>Método de Pago</b></label>
            <select name="metodo_pago" id="metodo_pago">
                <option value="tarjeta">Tarjeta</option>
                <option value="paypal">PayPal</option>
            </select>
            <button type="submit">Finalizar Compra</button>
        </div>
    </form>
</div>