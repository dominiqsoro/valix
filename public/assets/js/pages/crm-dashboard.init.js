"use strict";

document.addEventListener("DOMContentLoaded", function () {
    // Charger dynamiquement les données pour sales-overview
    fetch("/dashboard/sales-overview")
        .then(response => response.json())
        .then(data => {
            var options = {
                series: [
                    { name: "Profit", data: data.sales },
                    { name: "Expense", data: data.expenses }
                ],
                chart: {
                    type: "bar",
                    height: 353,
                    parentHeightOffset: 0,
                    stacked: true,
                    toolbar: { show: false }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "30%",
                        borderRadius: 4
                    }
                },
                dataLabels: { enabled: false },
                xaxis: { categories: data.months },
                grid: {
                    show: true,
                    padding: { top: -18, right: 0, bottom: 0 },
                    strokeDashArray: 4,
                    xaxis: { lines: { show: true } },
                    yaxis: { lines: { show: false } }
                },
                legend: { position: "bottom" },
                fill: { opacity: 1 },
                colors: ["#287F71", "#dee2e6"]
            };
            var chart = new ApexCharts(document.querySelector("#sales-overview"), options);
            chart.render();
        })
        .catch(error => console.error("Erreur lors du chargement des données :", error));
});

// Configuration pour le graphique radial de croissance
var options = {
    chart: { height: 300, type: "radialBar" },
    plotOptions: {
        radialBar: {
            startAngle: -135,
            endAngle: 135,
            dataLabels: {
                name: { fontSize: "13px", offsetY: 25 },
                value: {
                    offsetY: -15,
                    fontSize: "25px",
                    color: "#343a40",
                    formatter: function (e) { return e + "%"; }
                }
            }
        }
    },
    fill: {
        gradient: {
            enabled: true,
            shade: "dark",
            shadeIntensity: 0.2,
            inverseColors: false,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 50, 65, 91]
        }
    },
    stroke: { dashArray: 7 },
    colors: ["#287F71", "#22c55e"],
    series: [78],
    labels: ["Growth"]
};
var chart = new ApexCharts(document.querySelector("#browservisiting"), options);
chart.render();

// Configuration du graphique radar
options = {
    series: [
        { name: "Top Lead", data: [80, 50, 30, 40, 100, 20] },
        { name: "Cold Lead", data: [20, 30, 40, 80, 20, 80] },
        { name: "Qualified", data: [44, 76, 78, 13, 43, 10] }
    ],
    chart: {
        type: "radar",
        height: 323,
        parentHeightOffset: 0,
        dropShadow: { enabled: true, blur: 1, left: 1, top: 1 },
        toolbar: { show: false }
    },
    stroke: { width: 1 },
    fill: { opacity: 0.1 },
    markers: { size: 3, hover: { size: 4 } },
    yaxis: { stepSize: 20 },
    tooltip: { y: { formatter: function (e) { return e; } } },
    legend: { show: true },
    xaxis: {
        categories: ["2019", "2020", "2021", "2022", "2023", "2024"],
        labels: { show: true, style: { fontSize: "13px", colors: ["#001b2f"] } }
    },
    colors: ["#287F71", "#963b68", "#2786f1"],
    dataLabels: { enabled: false, background: { enabled: true } }
};
chart = new ApexCharts(document.querySelector("#deals-statistics"), options);
chart.render();

// Configuration du graphique en donut
options = {
    chart: { height: 200, type: "donut" },
    plotOptions: { pie: { donut: { size: "75%" } } },
    dataLabels: { enabled: false },
    stroke: { show: true, width: 2, colors: ["transparent"] },
    series: [35, 35, 30],
    legend: {
        show: false,
        position: "bottom",
        horizontalAlign: "center",
        verticalAlign: "middle",
        fontSize: "14px"
    },
    labels: ["Mobile", "Tablet", "Desktop"],
    colors: ["#963b68", "rgba(150, 59, 104, .5)", "rgba(150, 59, 104, .18)"]
};
chart = new ApexCharts(document.querySelector("#productactivity"), options);
chart.render();
