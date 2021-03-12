/**
 * This function auto updates the Date and Time based on real Date and Time
 * Ex: When you on the create new page, and you are on that page in 10 mins until submit the form
 *     The Time row in the form will be auto updated every 1 min.
 */
function refreshTime() {
        var today = new Date();
        document.getElementById('timecarddate').value =
            today.getFullYear() + '-' + ((today.getMonth() + 1) < 10 ? '0' : '') + (today.getMonth() + 1) + '-' + (today
            .getDate() < 10 ? '0' : '') + today.getDate();
        document.getElementById('timer').value =
            (today.getHours() < 10 ? '0' : '') + today.getHours() + ':' + (today.getMinutes() < 10 ? '0' : '') + today
            .getMinutes();
        setTimeout(refreshTime, 1000);
        }
        refreshTime();
