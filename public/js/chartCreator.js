$(document).ready(function() {
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
                    toFixedFix = function(n, prec) {
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
                                    callback: function(value, index, values) {
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
                                label: function(tooltipItem, chart) {
                                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                    return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
                                }
                            }
                        },
                    }
                });
            }


            var currentFirstRowButton = '';
            //$("#firstRow").hide();
            $("#secondRow").hide();
            $("#thirdRow").hide();

            //######################## - Première ligne - ######################## 

            //Quand on clic sur la 1ere ligne, met tout en gris et change la couleur du bouton cliqué
            function clicFirstRow(str) {
                $("#thirdRow").hide();
                if ($(str).css('background-color') == "rgb(202, 180, 55)") {
                    firstRowGrey()
                    secondRowGrey()
                    $("#secondRow").hide();
                } else {
                    //On met tou en gris  
                    firstRowGrey()
                    secondRowGrey()

                    //On change la couleur du bouton cliqué
                    $(str).css("background-color", "#cab437");
                    currentFirstRowButton = str;
                    $("#secondRow").show();
                }
            }



            //Premiere ligne   
            //Quand on clic sur le 1er bouton
            $("#1").click(function() {
                clicFirstRow('#1')

            });

            //Quand on clic sur le bouton
            $("#2").click(function() {
                clicFirstRow('#2')
            });

            $("#3").click(function() {
                $("#secondRow").hide();
                $("#thirdRow").hide();
                //On met tou en gris  
                firstRowGrey()
                secondRowGrey()

                //On change la couleur du bouton cliqué

                $("#3").css("background-color", "#cab437");
            });




            //######################## - Deuxième ligne - ######################## 

            $("#11").click(function() {
                clicSecondRow('#11');
            });

            $("#12").click(function() {
                clicSecondRow('#12');
            });
            $("#13").click(function() {
                clicSecondRow('#13');
            });
            $("#14").click(function() {
                clicSecondRow('#14');
            });

            function clicSecondRow(str) {
                //On met tout en gris  
                secondRowGrey()
                    //On change la couleur du bouton cliqué
                $(str).css("background-color", "#cab437");

                //Si on a appuyer sur le nombre d'inscrits
                if (currentFirstRowButton == '#1') {
                    switch (str) {
                        //Par heure
                        case '#11':
                            //Change le titre du graphique
                            $('#graphTitle').html('Nombre D\'inscrit par Jour');

                            //Récupération des données
                            $.ajax({ url: "http://serveur1.arras-sio.com/symfony4-4149/API/public/api/custom/getLesUsersLastDay", method: "GET", dataType: "json" }).done(function(data) {
                                console.log(data);
                                var dates = []

                                data.forEach(element => {
                                    var x = Date.parse(element.createdat);
                                    dates.push(new Date(x.getTime() - x.getTimezoneOffset() * 60 * 1000).toISOString().replace('T', ' '));
                                });


                                var lesDates = {}
                                dates.forEach(date => {
                                    console.log(date)

                                    var x = new Date(Date.UTC(date.getFullYear(), date.getMonth(), date.getDay(), date.getHours(), date.getMinutes(), date.getSeconds(), date.getMilliseconds()))
                                    console.log(x)
                                    lesDates[x.getDay()].push(date)
                                });


                               // console.log(lesDates)

                                var datenow = new Date()
                                var x = new Date(Date.UTC(datenow.getFullYear(), datenow.getMonth(), datenow.getDay(), datenow.getHours(), datenow.getMinutes(), datenow.getSeconds(), datenow.getMilliseconds()))
                               
                               


                                





                                var ctx = document.getElementById("annoncesParCat").getContext('2d');;
                                var myChart = new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels: ["January", "February", "March", "April", "May", "June"],
                                        datasets: [{
                                            label: "Revenue",
                                            backgroundColor: "#4e73df",
                                            hoverBackgroundColor: "#2e59d9",
                                            borderColor: "#4e73df",
                                            data: datas,
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
                                                    callback: function(value, index, values) {
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
                                                label: function(tooltipItem, chart) {
                                                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                                    return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
                                                }
                                            }
                                        },
                                    }
                                });
















                            });





                            $("#thirdRow").show();
                            break;
                        case '#12':
                            $('#graphTitle').html('Nombre D\'inscrit par Semaine');
                            chart2();
                            $("#thirdRow").show();
                            break;

                        case '#13':
                            $('#graphTitle').html('Nombre D\'inscrit par Mois');
                            chart2();
                            $("#thirdRow").show();
                            break;

                        case '#14':
                            $('#graphTitle').html('Nombre D\'inscrit par Année');
                            chart2();
                            $("#thirdRow").show();
                            break;
                    }
                }

            }





            //######################## - Fonctions - ######################## 

            function firstRowGrey() {
                $("#1").css("background-color", "grey");
                $("#2").css("background-color", "grey");
                $("#3").css("background-color", "grey");

            }

            function secondRowGrey() {
                $("#11").css("background-color", "grey");
                $("#12").css("background-color", "grey");
                $("#13").css("background-color", "grey");
                $("#14").css("background-color", "grey");
            }
    

})