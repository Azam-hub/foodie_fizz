$(".account-action-list-opener").click(function () {
    $(".account-action-list").toggle()
})
$(".search-bar-opener").click(function () {
    if ($(".search-bar").css("display") == "none") {
        $(".search-bar").css("display", "flex")
    } else {
        $(".search-bar").css("display", "none")
    }
})
$("section").click(function () {
    $(".search-bar").hide()
    $(".account-action-list").hide()
})


$('.for-mobile-account-action-list').slideUp()
$('.for-mobile-account-action-list-opener').click(function () {
    $('.for-mobile-account-action-list').slideToggle()
    
}) 
$(".links").slideUp()
$(".bars").click(function () {
    $(".links").slideToggle()
    
})


// ------------------------ Messages Function -------------------------

function success_msg(msg) {
    var text = `<div class="msg success-msg">
                <div class="left">
                    <ion-icon class="icon" name="checkmark-circle-outline"></ion-icon>
                </div>
                <div class="right">
                    <p>${msg}</p>
                </div>
            </div>`;
    return text;
}
function danger_msg(msg) {
    var text = `<div class="msg danger-msg">
                <div class="left">
                    <ion-icon class="icon" name="alert-circle-outline"></ion-icon>
                </div>
                <div class="right">
                    <p>${msg}</p>
                </div>
            </div>`;
    return text;
}
function primary_msg(msg) {
    var text = `<div class="msg primary-msg">
                <div class="left">
                    <ion-icon class="icon" name="checkmark-circle-outline"></ion-icon>
                </div>
                <div class="right">
                    <p>${msg}</p>
                </div>
            </div>`;
    return text;
}
