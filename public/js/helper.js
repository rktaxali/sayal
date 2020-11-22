
// Returns current date in YYYY-MM-DD format
function getCurrentDate()
{
    let today = new Date();
    let dd = String(today.getDate()).padStart(2, '0');
    let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    let yyyy = today.getFullYear();
    
    return  yyyy + '-' + mm + '-' + dd;
}


// Returns the passed JS date as MySQL Date (e.g. '2020-12-29')
function getMySQLDate(jsDate)
{
    let dd = String(jsDate.getDate()).padStart(2, '0');
    let mm = String(jsDate.getMonth() + 1).padStart(2, '0'); //January is 0!
    let yyyy = jsDate.getFullYear();
    return  yyyy + '-' + mm + '-' + dd;
}


// strDate, e.g. "Fri Nov 20 2020 19:00:00 GMT-0500 (Eastern Standard Time)"
// Retruns "2020-12-20"
function getMySQLDateFromStrDate(strDate)
{
    let jsDate = new Date(strDate);
    return getMySQLDate(jsDate);
}


function hideModal(){
    $(".modal").removeClass("in");
    $(".modal-backdrop").remove();
    $('body').removeClass('modal-open');
    $('body').css('padding-right', '');
    $(".modal").hide();
  }
  

