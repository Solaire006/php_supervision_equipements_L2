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

// Combine les 4 champs en une seule IP avant submit
document.addEventListener('DOMContentLoaded', function() {
    var form = document.querySelector('form[method="POST"]');
    if (form) {
        form.addEventListener('submit', function() {
            var ip = document.getElementById('ip1').value + '.' +
                     document.getElementById('ip2').value + '.' +
                     document.getElementById('ip3').value + '.' +
                     document.getElementById('ip4').value;
            document.getElementById('adresse_ip').value = ip;
        });
    }
});

// Auto passer au champ suivant quand 3 chiffres sont tapés
document.addEventListener('DOMContentLoaded', function() {
    ['ip1', 'ip2', 'ip3'].forEach(function(id, index) {
        var input = document.getElementById(id);
        if (input) {
            input.addEventListener('input', function() {
                if (this.value.length === 3) {
                    document.getElementById('ip' + (index + 2)).focus();
                }
            });
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.getElementById('ip' + (index + 2)).focus();
                }
            });
        }
    });
});