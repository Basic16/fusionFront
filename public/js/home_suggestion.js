/**
 * Script permettant le fonctionnement de l'auto-completion de la barre de recherche de la page d'acceuil
 */

let homeSuggestionSearch = document.getElementById("home_suggestion_search");
let searchInput = document.getElementById("rechercheInput");

let homeSuggestionLocation = document.getElementById("home_suggestion_location");
let locationInput = document.getElementById("locationInput");

searchInput.addEventListener("input", function (e) {
	var saisie = e.target.value;
	if(saisie.length > 0){
		homeSuggestionSearch.style.display = "block";
		ajaxGet("http://serveur1.arras-sio.com/symfony4-4149/API/public/api/custom/getListingCategoryRecherche/?search="+saisie, function (e) {
			homeSuggestionSearch.innerHTML = "";
			JSON.parse(e).forEach(c => {
				var link = document.createElement("li");
					link.className = "list-group-item text-dark";
					link.style.cursor = "pointer";
					link.textContent = c.name;
					link.addEventListener("click", function (e) {
						searchInput.value = e.path[0].innerText;
					});
				homeSuggestionSearch.appendChild(link);
			});
		});
	}else{
		homeSuggestionSearch.style.display = "none";
	}
});

locationInput.addEventListener("input", function (e) {
	var saisie = e.target.value;
	if(saisie.length > 0){
		homeSuggestionLocation.style.display = "block";
		ajaxGet("http://serveur1.arras-sio.com/symfony4-4149/API/public/api/custom/getListingLocationRecherche/?search="+saisie, function (e) {
			homeSuggestionLocation.innerHTML = "";
			JSON.parse(e).forEach(c => {
				var link = document.createElement("li");
					link.className = "list-group-item text-dark";
					link.style.cursor = "pointer";
					link.textContent = c.city;
					link.addEventListener("click", function (e) {
						locationInput.value = e.path[0].innerText;
					});
					homeSuggestionLocation.appendChild(link);
			});
		});
	}else{
		homeSuggestionLocation.style.display = "none";
	}
});


document.querySelector("body").addEventListener("click", function(e){
	homeSuggestionSearch.style.display = "none";
	homeSuggestionLocation.style.display = "none";
});


// Fonction ajax
function ajaxGet(url, callback){
	var req = new XMLHttpRequest();
	req.open("GET", url);
	req.addEventListener("load", function () {
		if(req.status >= 200 && req.status < 400){
			callback(req.responseText);
			console.log("Succès de la requete");
		}else{
			console.log(req.status + " " + req.statusText + " " + url);
		}
	});
	req.addEventListener("error", function () {
    	console.log("Erreur réseau avec l'URL " + url);
	});
	req.send(null);
}