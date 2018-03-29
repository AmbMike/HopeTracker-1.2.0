/*
 * Copyright (c) 2017.
 */


if($('#myBarChart').length > 0){
    $(document).ready(function () {
        'use strict';

        setCompleteTasks(activitiesPie);

        activitiesBarChartLogins();

    });
    function  setCompleteTasks(callback) {
        'use strict';
        /** Get the total number of activities completed by the user. */
        $.post(RELATIVE_PATH + '/config/processing.php',{form :'Get Activity Counts' },function (data) {
            /** the call back to the pie chart function in order to pass the ajax data to the file */

            callback(data.completedActivities,$('.total-activities').text());
        },'json');

    }
    /** Creates the pie chart for the status modal using the above ajax function */
    function activitiesPie(activitiesCount,total_activities) {
        'use strict';

        /**
         * File For: HopeTracker.com
         * File Name: .
         * Author: Mike Giammattei
         * Created On: 10/30/2017, 12:58 PM
         */
        var ctx = document.getElementById("myChart");
        var ctx = document.getElementById("myChart").getContext("2d");
        var ctx = $("#myChart");
        var ctx = "myChart";

        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                datasets: [{
                    data: [activitiesCount, total_activities,$("[data-skipped-course]").text()],
                    backgroundColor: [
                        'rgb(74, 191, 2)',
                        'rgb(191, 191, 191)',
                        'rgb(11, 118, 173)'
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    "Completed",
                    "Incomplete",
                    "Skipped"

                ]
            },
            options: {
                legend: {display: false},
                title: {
                    display: true,
                    text: 'Activities Completed'
                }
            }
        });

    }

    function activitiesBarChartLogins() {

        $.post(RELATIVE_PATH + '/config/processing.php',{form : 'Grouped User Logins By Week'}, function (data) {
            LoginsByWeekdayPieChart(data);
        },'json');
    }
    function LoginsByWeekdayPieChart(weekdays) {
        'use strict';
        /** Bar Chart */
        var ctx2 = document.getElementById("myBarChart");
        var ctx2 = document.getElementById("myBarChart").getContext("2d");
        var ctx2 = $("#myBarChart");
        var ctx2 = "myBarChart";

        var weekdaysArr = $.map(weekdays, function(el) { return el; });
        var myBarChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ["Mon", "Tue", "Wed", "Thur", "Fri", "Sat", "Sun"],
                datasets: [
                    {
                        label: "Days of Week Logged In",
                        backgroundColor: ["#064260", "#074F73", "#095C86", "#096492", "#0B77AD", "#0C84C0", "#0C84C0"],
                        data: weekdaysArr
                    }
                ]
            },
            options: {
                legend: {display: false},
                title: {
                    display: true,
                    text: 'Days Logged In'
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

    /** Line Chart */
    getJournalByWeekday();
    function getJournalByWeekday() {
        $.post(RELATIVE_PATH + '/config/processing.php',{form : 'Grouped User Journal By Week'}, function (data) {
            journalByWeekdayPieChart(data);
        },'json');
    }

    function journalByWeekdayPieChart(weekdays) {
        var weekdaysArr = $.map(weekdays, function(el) { return el; });
        new Chart(document.getElementById("lineChart"), {
            type: 'line',
            data: {
                labels: ["Mon", "Tue", "Wed", "Thur", "Fri", "Sat", "Sun"],
                datasets: [{
                    label: "Journals",
                    data: weekdaysArr,
                    borderColor: "#3e95cd",
                    fill: true
                },
                ]
            },
            options: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Journal Entries By Week'
                }
            }
        });

    }
}

