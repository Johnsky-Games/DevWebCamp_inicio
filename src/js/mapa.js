if(document.querySelector('#mapa')) {
    const lat = -0.179163;
    const lng = -78.483474;
    const zoom = 16;

    const map = L.map('mapa').setView([lat, lng], zoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Tu empresa',
    }).addTo(map);

    L.marker([lat, lng]).addTo(map)
        .bindPopup(`
            <h2 class="mapa__heading">DevWebCamp</h2>
            <p class="mapa__texto">Parque la Karolina</p>
            `)
        .openPopup()
        .bindTooltip('Un Tooltip')
        .openTooltip();
}