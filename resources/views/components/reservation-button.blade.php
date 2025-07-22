<div class="reservation-button" x-data="{ open: false, sending: false, confirmed: false, errorMsg: '', formData: {} }">
    <button class="cta-button" @click="$store.reservation.open = true">RESERVAR AHORA</button>
</div>