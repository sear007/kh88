(function($) {
$.fn.formatNumberElement = function() {
    $(this).text(parseFloat($(this)[0]['innerText']).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'))
    return $(this);
}
})( jQuery );
window.formatNumber = function(value,fix,currency) {
    return currency+" "+(value).toFixed(fix).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}
window.timer = function(minuteId,secondsId,second){
    var minutesLabel = document.getElementById(minuteId);
    var secondsLabel = document.getElementById(secondsId);
    var totalSeconds = second;
    setInterval(setTime, 1000);
    function setTime() {
        ++totalSeconds;
        secondsLabel.innerHTML = pad(totalSeconds % 60);
        minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
    }
    function pad(val) {
        var valString = val + "";
        if (valString.length < 2) {
            return "0" + valString;
        } else {
            return valString;
        }
    }
}
    
    
  