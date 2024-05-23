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
let searchPage = 1;
let nomoreSearch = false;
let searchTempValue = "";
let setSearchLoading = false;
function searchUsers(query) {
    if (query != searchTempValue) {
        searchPage = 1;
        nomoreSearch = false;
    }

    searchTempValue = query;

    if (!setSearchLoading && !nomoreSearch) {
        $.ajax({
            method: "GET",
            url: "/messenger/search",
            data: { query: query, page: searchPage },
            beforeSend: function () {
                setSearchLoading = true;
                let loader = `
                    <div class="text-center search-loader">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                `;

                $(".user_search_list_result").append(loader);
            },
            success: function (data) {
                setSearchLoading = false;
                $(".user_search_list_result").find(".search-loader").remove();
                if (searchPage < 2) {
                    $(".user_search_list_result").html(data.records);
                } else {
                    $(".user_search_list_result").append(data.records);
                }

                nomoreSearch = searchPage >= data?.last_page;
                if (!nomoreSearch) searchPage += 1;

                searchPage += 1;
            },
            error: function (xhr, status, error) {
                $(".user_search_list_result").find(".search-loader").remove();
            },
        });
    }
}
function actionOnScroll(selector, callback, topScroll = false) {
    $(selector).on("scroll", function () {
        let element = $(this).get(0);
        const condition = topScroll
            ? element.scrollTop == 0
            : element.scrollTop + element.clientHeight >= element.scrollHeight;

        if (condition) {
            callback();
        }
    });
}

function debounce(callback, delay) {
    let timerId;
    return function (...args) {
        clearTimeout(timerId);
        timerId = setTimeout(() => {
            callback.apply(this, args);
        }, delay);
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
    //search pagination
    actionOnScroll(".user_search_result", function () {
        let value = $(".user_search").val();
        searchUsers(value);
    });
});
