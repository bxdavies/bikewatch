if(document.body.contains(document.getElementById('bikeColor'))){
    const bikeColor = document.getElementById('bikeColor');
    var nameThatColorMatch = ntc.name(bikeColor.getAttribute('value'));
    bikeColor.innerHTML = bikeColor.innerHTML + nameThatColorMatch[1];
}

function imageModal(event) {
    document.getElementById('modalImage').src = event.target.src;
    document.getElementById('imageModal').checked = true;
}