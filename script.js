document.addEventListener('DOMContentLoaded', loadPlanets); //afficher les planètes

function loadPlanets() {
  var docBod = document.body;
  for (var j = 1; j < 8; j++) {
    (function(i) { 
      var f = i;
      var req = new XMLHttpRequest(); //ouverture d'une requete HTTP
      var URLhost = 'https://swapi.co/api/people/?page=' + f;  //URL de l'api afin de récupérer les données sur les planètes
      req.open('GET', URLhost, true);
      req.addEventListener('load', function() {
        if (req.status >= 200 && req.status < 400) {
          var response = JSON.parse(req.responseText); //convertir notre resultat JSON en objet
          console.log(response); //on affiche les résultats sur la console
          var planetHead = document.createElement('h5');
          docBod.appendChild(planetHead);
          planetHead.textContent = 'Planets Page - ' + f; //F correspond au numéro de la page qui s'incrémente
          var planetList = document.createElement('ol');
          planetHead.appendChild(planetList);

          for (var k = 0; k < response.results.length; k++) {
            (function(y) {
              var planetIn = document.createElement('li');
              planetIn.textContent = response.results[y].name;
              planetList.appendChild(planetIn);
            })(k);
          }

        } else {
          console.log('Error in network request: ' + req.statusText); //En cas d'erreur dans la requête
        }
      });
      req.send(null);
      event.preventDefault();
    })(j);
  }
}