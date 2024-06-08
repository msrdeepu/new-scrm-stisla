/**
 * --------------
 * Global Variables
 * --------------
 */

var temporaryMsgId = 0;
const messegeForm = $(".messege-form"),
    messageBoxContainer = $(".wsus__chat_area_body"),
    messageInput = $(".message-input"),
    csrf_token = $("meta[name=csrf_token]").attr("content");

const getMessengerId = () => $("meta[name=id]").attr("content");
const setMessengerId = (id) => $("meta[name=id]").attr("content", id);

/**
 * --------------
 * Reusable Functions
 * --------------
 */

function enableChatBoxLoader() {
    $(".wsus__chat_app").removeClass("show_info");
}

function disableChatBoxLoader() {
    $(".wsus__chat_app").removeClass("d-none");
    $(".wsus__message_paceholder").addClass("d-none");
    $(".wsus__message_paceholder_black").addClass("d-none");
}

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
 * --------------------------------
 * Fetch id data and update view
 * --------------------------------
 */

function IDinfo(id) {
    $.ajax({
        method: "GET",
        url: "messenger/id-info",
        data: { id: id },
        beforeSend: function () {
            NProgress.start();
            enableChatBoxLoader();
        },
        success: function (data) {
            // fetch messeges
            fetchMessages(data.fetch.id);
            // fetch messeges
            $(".messenger-header").find("img").attr("src", data.fetch.avatar);
            $(".messenger-header").find("h4").text(data.fetch.name);
            $(".messenger-info-view .user_photo")
                .find("img")
                .attr("src", data.fetch.avatar);
            $(".messenger-info-view").find(".user_name").text(data.fetch.name);
            $(".messenger-info-view")
                .find(".user_unique_name")
                .text(data.fetch.user_name);

            NProgress.done();
            disableChatBoxLoader();
        },
        error: function (xhr, status, error) {
            disableChatBoxLoader();
        },
    });
}
/**
 * --------------------------------
 * Send Messege
 * --------------------------------
 */
function sendMessege() {
    temporaryMsgId += 1;
    let hasAttachment = !!$(".attachment-input").val();
    let tempId = `temp_${temporaryMsgId}`;
    const inputValue = messageInput.val();
    if (inputValue.length > 0 || hasAttachment) {
        const formData = new FormData($(".messege-form")[0]);
        formData.append("id", getMessengerId());
        formData.append("temporaryMsgId", tempId);
        formData.append("_token", csrf_token);
        const formObject = {};

        formData.forEach((value, key) => {
            formObject[key] = value;
        });

        $.ajax({
            method: "POST",
            url: "messenger/send-message",
            data: formData,
            dataType: "JSON",
            processData: false,
            contentType: false,
            beforeSend: function () {
                if (hasAttachment) {
                    messageBoxContainer.append(
                        sendTempMessegeCard(inputValue, tempId, true)
                    );
                } else {
                    messageBoxContainer.append(
                        sendTempMessegeCard(inputValue, tempId)
                    );
                }
                scrollToBottom(messageBoxContainer);
                messageFormReset();
            },
            success: function (data) {
                const tempMsgCardElement = messageBoxContainer.find(
                    `.messege-card[data-id=${data.tempId}]`
                );
                tempMsgCardElement.before(data.message);
                tempMsgCardElement.remove();
            },
            error: function (xhr, status, error) {},
        });
    }
}

function sendTempMessegeCard(message, tempId, attachment = false) {
    if (attachment) {
        return `  <div class="wsus__single_chat_area messege-card" data-id="${tempId}">
        <div class="wsus__single_chat chat_right">
            <div class="pre_loader">
                <div class="spinner-border text-light" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            ${message.length > 0 ? `<p class="messages">${message}</p>` : ""}
            <span class="time"> now</span>
            <a class="action" href="#"><i class="fas fa-trash"></i></a>
        </div>
    </div>
`;
    } else {
        return ` <div class="wsus__single_chat_area messege-card" data-id="${tempId}">
        <div class="wsus__single_chat chat_right">
            <p class="messages">${message}</p>
            <span class="clock"><i class="fas fa-clock"></i> now</span>
            <a class="action" href="#"><i class="fas fa-trash"></i></a>
        </div>
    </div>
    `;
    }
}

function messageFormReset() {
    messegeForm.trigger("reset");
    $(".attachment-block").addClass("d-none");
}

/**
 * Fetch Messeges from database
 */

let messagePage = 1;
let noMoreMessages = false;
let messegesLoading = false;

function fetchMessages(id) {
    if (!noMoreMessages) {
        $.ajax({
            method: "GET",
            url: "messenger/fetch-messages",
            data: {
                _token: csrf_token,
                id: id,
                page: messagePage,
            },
            success: function (data) {
                messageBoxContainer.html(data.messages);
                scrollToBottom(messageBoxContainer);

                if (messagePage == 1) {
                    messageBoxContainer.html(data.messages);
                    scrollToBottom(messageBoxContainer);
                } else {
                    messageBoxContainer.prepend(data.messages);
                }
                // pagination lock and page increment
                noMoreMessages = messagePage >= data?.last_page;
                if (!noMoreMessages) messagePage += 1;
            },
            error: function (xhr, status, error) {},
        });
    }
}

/**
 * ----------------
 * slide to bottom
 * ---------------
 */

function scrollToBottom(container) {
    $(container)
        .stop()
        .animate({
            scrollTop: $(container)[0].scrollHeight,
        });
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

    //onclick action for messenger items
    $("body").on("click", ".messenger-list-item", function () {
        // alert("Hello Sandeep");
        let userId = $(this).attr("data-id");
        setMessengerId(userId);
        IDinfo(userId);
    });

    // send messege
    $(".messege-form").on("submit", function (e) {
        e.preventDefault();
        sendMessege();
    });

    /**
     * Send attachments
     */
    $(".attachment-input").change(function () {
        imagePreview(this, ".attachment-preview");
        $(".attachment-block").removeClass("d-none");
    });
    $(".cancel-attachment").on("click", function () {
        messageFormReset();
        $(".emojionearea-editor").text("");
    });

    //message pagination
    actionOnScroll(
        ".wsus__chat_area_body",
        function () {
            fetchMessages(getMessengerId());
        },
        true
    );
});
