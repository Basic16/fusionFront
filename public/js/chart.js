$(document).ready(function () {
     // Set new default font family and font color to mimic Bootstrap's default styling
     Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
     Chart.defaults.global.defaultFontColor = '#858796';

     function number_format(number, decimals, dec_point, thousands_sep) {
         // *     example: number_format(1234.56, 2, ',', ' ');
         // *     return: '1 234,56'
         number = (number + '').replace(',', '').replace(' ', '');
         var n = !isFinite(+number) ? 0 : +number,
             prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
             sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
             dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
             s = '',
             toFixedFix = function (n, prec) {
                 var k = Math.pow(10, prec);
                 return '' + Math.round(n * k) / k;
             };
         // Fix for IE parseFloat(0.55).toFixed(0) = 0;
         s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
         if (s[0].length > 3) {
             s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
         }
         if ((s[1] || '').length < prec) {
             s[1] = s[1] || '';
             s[1] += new Array(prec - s[1].length + 1).join('0');
         }
         return s.join(dec);
     }
     
    function annonces() { //Recupère la liste des categories de prestataires
        $.ajax({ url: "http://serveur1.arras-sio.com/symfony4-4149/API/public/api/listings.json", method: "GET", dataType: "json" }).done(function (data) {
            categories(data);
        });
    }

    function categories(annonces) {
        $.ajax({ url: "http://serveur1.arras-sio.com/symfony4-4149/API/public/api/listing_category_translations.json", method: "GET", dataType: "json" }).done(function (data) {
            chart(annonces, data);
        });

    }

    function chart(annonces, categories) {

        //Defini les Categories de prestataires
        var lesCategories = []
        for (var i = 0; i < categories.length; i++) {
            lesCategories.push(categories[i].name)
        }
        lesCategories = lesCategories.sort()

        console.log(annonces)
        //Associe a chaque categories le nombre d'annonces qu'il y a dedans
        var cat = {};
        lesCategories.forEach(categorie => {
            cat[categorie] = 0
        })

        annonces.forEach(annonce => {
            //console.log(annonce)
            cat[annonce.ListingCategory[0].listingCategoryTranslations[0].name] = cat[annonce.ListingCategory[0].listingCategoryTranslations[0].name] + 1;
        })


        var datas = []

        for (const [key, value] of Object.entries(cat)) {
            datas.push(value)
        }


        //Fait le graphique
        var ctx = document.getElementById('annoncesParCat').getContext('2d');
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
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                //Quand on passe la souris sur une barre
                tooltips: {
                    enabled: true,
                    callbacks: {
                        afterLabel: function (tooltipItem, chart) {
                            var allAnnonces = datas.reduce((a, b) => a + b, 0)
                            return 'Les annonces de cette categorie representent ' + Math.round(((tooltipItem.value / allAnnonces) * 100) * 100) / 100 + '% de toutes les annonces.';
                        },

                    }
                },

                //Pour desactivé la legende
                legend: {
                    display: false
                },


                scales: {
                    yAxes: [{
                        ticks: {
                            stepSize: 1,
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    }

    function chart2() {
        // Bar Chart Example
        var ctx = document.getElementById("annoncesParCat").getContext('2d');;
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["January", "February", "March", "April", "May", "June"],
                datasets: [{
                    label: "Revenue",
                    backgroundColor: "#4e73df",
                    hoverBackgroundColor: "#2e59d9",
                    borderColor: "#4e73df",
                    data: [4215, 5312, 6251, 7841, 9821, 14984],
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'month'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        },
                        maxBarThickness: 25,
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: 15000,
                            maxTicksLimit: 5,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function (value, index, values) {
                                return '$' + number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                    callbacks: {
                        label: function (tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
                        }
                    }
                },
            }
        });
    }

    annonces();

    $("#graphique1").click(function () {

        $('#graphTitle').html("Nombre d'annonces par categorie");

        annonces();
    });



    $("#graphique2").click(function () {

        $('#graphTitle').html('graphique 2');

        chart2();
    });
})