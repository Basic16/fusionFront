$(document).ready(function() {

    function prestaCategories() { //Recupère la liste des categories de prestataires
        $.ajax({ url: "http://serveur1.arras-sio.com/symfony4-4149/API/public/index.php/api/listing_categories.json", method: "GET", dataType: "json" }).done(function(data) {
            users(data);
        });
    }

    function users(categories) { //Recupère la liste des annonces et leurs categories
        $.ajax({ url: "http://serveur1.arras-sio.com/symfony4-4149/API/public/index.php/api/listing_listing_categories", method: "GET", dataType: "json" }).done(function(data) {
            chart(categories, data);
        });
    }

    function chart(categories, annonces) {

        //Defini les Categories de prestataires
        var lesCategories = []
        for (var i = 0; i < categories.length; i++) {
            if (!lesCategories.includes(categories[i].listingCategoryTranslations[0].name))
                lesCategories.push(categories[i].listingCategoryTranslations[0].name)
        }
        lesCategories = lesCategories.sort()


        //Associe a chaque categories le nombre d'annonces qu'il y a dedans
        var cat = {};
        lesCategories.forEach(categorie => {
            cat[categorie] = 0
        })

        annonces.forEach(annonce => {
            cat[annonce.listingCategory.listingCategoryTranslations[0].name] = cat[annonce.listingCategory.listingCategoryTranslations[0].name] + 1;
        })


        var datas = []

        for (const [key, value] of Object.entries(cat)) {
            datas.push(value)
        }


        //Fait le graphique
        var ctx = document.getElementById('weddersParCategorie').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: lesCategories,
                datasets: [{
                    label: 'Nombre d\'annonces',
                    data: datas,
                    borderWidth: 1
                }]
            },
            options: {
                //Quand on passe la souris sur une barre
                tooltips: {
                    enabled: true,
                    callbacks: {
                        afterLabel: function(tooltipItem, chart) {
                            var allAnnonces = datas.reduce((a, b) => a + b, 0)
                            return 'Les annonces de cette categorie representent ' + Math.round(((tooltipItem.value / allAnnonces) * 100) * 100) / 100 + '% de toutes les annonces.';
                        },

                    }
                },


                //Titre du graphique
                title: {
                    display: true,
                    text: 'Nombres d\'annonces par categories'
                },

                //Pour desactivé la legende
                legend: {
                    display: false
                },


                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    }

    prestaCategories();

})