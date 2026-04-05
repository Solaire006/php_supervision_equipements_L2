setTimeout(function() {
    var msg = document.getElementById('message');
    if (msg) msg.style.display = 'none';
}, 3000);

function ouvrirPopup(id) {
    document.getElementById('popup-id').value = id;
    document.getElementById('popup-supprimer').style.display = 'block';
    document.getElementById('overlay-supprimer').style.display = 'block';
}

function fermerPopup() {
    document.getElementById('popup-supprimer').style.display = 'none';
    document.getElementById('overlay-supprimer').style.display = 'none';
}