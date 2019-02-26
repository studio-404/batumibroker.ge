
function slide_next(current, last) {
    var next = current + 1;
   
    if ($("#promo_" + next).length > 0) {
        $("#promo_" + current).fadeOut();
        $("#promo_" + next).fadeIn();

        arrow(next, last);
    } else {
        $("#promo_" + current).fadeOut();
        $("#promo_0").fadeIn();

        arrow(0, last);
    }
}
function slide_prev(current, last) {
    var prev = current - 1;

    if ($("#promo_" + prev).length > 0) {
        $("#promo_" + current).fadeOut();
        $("#promo_" + prev).fadeIn();


        arrow(prev, last);
    } else {
        $("#promo_" + current).fadeOut();
        $("#promo_" + last).fadeIn();

        arrow(last, last);
    }
}

function arrow(current, last) {
    $("#slide .arrow-left").html('<a href="javascript:slide_prev(' + current + ',' + last + ');"></a>');
    $("#slide .arrow-right").html('<a href="javascript:slide_next(' + current + ', ' + last + ');"></a>');
}