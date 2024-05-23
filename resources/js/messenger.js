/**
 * --------------
 * Reusable Functions
 * --------------
 */

function imagePreview(input, selector) {
    if (input.files && input.files[0]) {
        var render = new FileReader();

        render.onload = function (e) {
            $(selector).attr("src", e.target.result);
        };
        render.readAsDataURL(input.files[0]);
    }
}

/**
 * search users
 */

function searchUsers(query) {
    $.ajax({
        method: "GET",
        url: "/messenger/search",
        data: { query: query },
        success: function (data) {
            $(".user_search_result").html(data.records);
        },
        error: function (xhr, status, error) {},
    });
}

function debounce(callback, delay) {
    let timerId;
    return function (...args) {
        clearTimeout(timerId);
        timerId = setTimeout(() => {
            callback.apply(this, args);
        }, timerId);
    };
}

/**
 * ----------------
 * On load DOM
 * ---------------
 */

$(document).ready(function () {
    $("#select_file").change(function () {
        imagePreview(this, ".profile-image-preview");
    });

    // searc action on keyup

    const debouncedsearch = debounce(function () {
        const value = $(".user_search").val();
        searchUsers(value);
    }, 500);

    $(".user_search").on("keyup", function () {
        let query = $(this).val();
        // console.log(query);
        debouncedsearch();
    });
});
