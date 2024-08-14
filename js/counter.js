$(document).on('click', '.decrement', function () {
    if ($(this).next().next().hasClass('increment-disabled')) {
        $(this).next().next().removeClass('increment-disabled')
        $(this).next().next().addClass('increment')            
    }

    var curr_num = parseInt($(this).next().text())
    if (curr_num != 1) {
        var decremented_num = curr_num - 1;
        $(this).next().text(decremented_num)
        
    } else {
        $(this).removeClass('decrement')
        $(this).addClass('decrement-disabled')
    }
})

$(document).on('click', '.increment', function () {
    if ($(this).prev().prev().hasClass('decrement-disabled')) {
        $(this).prev().prev().removeClass('decrement-disabled')
        $(this).prev().prev().addClass('decrement')
    }
    
    var curr_num = parseInt($(this).prev().text())

    if (curr_num != 99) {
        var incremented_num = curr_num + 1;
        $(this).prev().text(incremented_num)
        
    } else {
        $(this).removeClass('increment')
        $(this).addClass('increment-disabled')
    }
})