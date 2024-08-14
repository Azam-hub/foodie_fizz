// --------------- Sidebar Hide/Show ---------------

$(".lines").click(function () {
        
    if ($(".head-main-container").hasClass("sidebar-active")) {
        localStorage.setItem("active", true)
    } else {
        localStorage.setItem("active", false)
    }
    $('.sidebar').css({
        transition: ".5s"
    })
    $(".head-main-container").toggleClass("sidebar-active")

})
if ((localStorage.getItem("active")) == 'false') {
    $(".head-main-container").addClass("sidebar-active")
} else {
    $(".head-main-container").removeClass("sidebar-active")
}

// --------------- Sections hide/show ---------------


$(".sidebar .down .section h3").click(function () {
    var section_id = $(this).parent().attr("id")

    if (!("displayed" in localStorage)) {
        localStorage.setItem("displayed", JSON.stringify([]))
    }
    
    if ($(this).parent().hasClass("displayed")) {
        
        var local_storage_array = JSON.parse(localStorage.getItem("displayed"))

        const index = local_storage_array.indexOf(section_id);
        if (index > -1) {
            local_storage_array.splice(index, 1);
        }
        localStorage.setItem("displayed", JSON.stringify(local_storage_array))

    } else {
        var local_storage_array = JSON.parse(localStorage.getItem("displayed"))
        local_storage_array.push(section_id)
        
        localStorage.setItem("displayed", JSON.stringify(local_storage_array))
    }

    $(this).parent().toggleClass("displayed")
    $(this).next().slideToggle(300)
    
})

if ("displayed" in localStorage) {
    
    var local_storage_array = JSON.parse(localStorage.getItem("displayed"))

    $.each(local_storage_array, function (index, value) {

        if ($(`#${value}`).length){
            
            $(`#${value}`).addClass("displayed")
            // $(`#${value} i`).css({
            //     transition: '0s'
            // })
    
            var uls = $(`#${value}`)[0].children[1]
            $(uls).slideDown()
        }
    })
    
}




// if ((localStorage.getItem(section_id)) == 'false') {
//     $(".head-main-container").addClass("sidebar-active")
// } else {
//     $(".head-main-container").removeClass("sidebar-active")
// }





// End