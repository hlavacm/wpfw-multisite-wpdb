jQuery(document).ready(function () {

    jQuery("#category-filters .btn").click(function () {
        jQuery(this).toggleClass("btn-primary");
        jQuery(this).toggleClass("btn-outline-primary");
        loadMorePosts(jQuery(this), true);
    });

    jQuery("#site-filters .btn").click(function () {
        jQuery(this).toggleClass("btn-primary");
        jQuery(this).toggleClass("btn-outline-primary");
        loadMorePosts(jQuery(this), true);
    });

    jQuery("#load-more-posts").click(function () {
        loadMorePosts(jQuery("#load-more-posts"), false);
    });

    function loadMorePosts(input, withReset) {
        var button = jQuery("#load-more-posts");
        var container = jQuery("#posts-container");
        var offset = container.data("offset");
        if (offset < 0) {
            return;
        }

        if (withReset) {
            container.html(null);
            container.data("offset", offset = 0);
            button.css("display", "none");
            input.addClass("loading-upper");
        } else {
            button.addClass("loading-upper");
        }
        container.addClass("loading");

        var categorySlugs = jQuery.map(jQuery("#category-filters button.btn-primary"), function (element) {
            return jQuery(element).data("slug");
        }).join(",");
        var siteIds = jQuery.map(jQuery("#site-filters button.btn-primary"), function (element) {
            return jQuery(element).data("id");
        }).join(",");

        data = {
            action: "kt_zzz_load_more_posts",
            kt_offset: offset,
            kt_category_slugs: categorySlugs,
            kt_site_ids: siteIds
        };

        jQuery.post(myAjax.ajaxurl, data, function (response) {
            if (response == null || response == false) { // empty
                button.css("display", "none");
            } else if (response.indexOf("<div class=\"alert") == 0) { // no results
                button.css("display", "none");
                container.html(response);
            } else { // data
                container.html(container.html() + response);
                var count = jQuery("#posts-container div.card").length;
                container.data("offset", count);
                if (count < 3 || (count - offset) < 3) {
                    button.css("display", "none");
                } else {
                    button.css("display", "inline-block");
                }
            }
            // urls parameters
            if (categorySlugs || siteIds) {
                addOrUpdateUrlParameterValue("category-slugs", categorySlugs);
                addOrUpdateUrlParameterValue("site-ids", siteIds);
            } else {
                removeUrlParameter("category-slugs");
                removeUrlParameter("site-ids");
            }
            button.removeClass("loading-upper");
            input.removeClass("loading-upper");
            container.removeClass("loading");
        });
    }

    // cookie statements
    var ktCookieStatementContainer = jQuery("#ktCookieStatementContainer");
    if (ktCookieStatementContainer && ktCookieStatementContainer.length > 0) {
        if (!checkCookieRecord("kt-cookie-statement-key")) {
            data = {action: "kt_load_cookie_statement_content"};
            jQuery.post(myAjax.ajaxurl, data, function (response) {
                if (response) {
                    ktCookieStatementContainer.html(response);
                }
            });
        }
        jQuery(document).on("click", "#ktCookieStatementConfirm", function () {
            setCookieRecord("kt-cookie-statement-key", 1, 10);
            jQuery("#ktCookieStatement").fadeOut();
        });
    }

});

function removeUrlParameter(parameter) {
    var url = document.location.href;
    var urlParts = url.split("?");
    if (urlParts.length >= 2) {
        var urlBase = urlParts.shift();
        var queryString = urlParts.join("?");
        var prefix = encodeURIComponent(parameter) + "=";
        var parts = queryString.split(/[&;]/g);
        for (var i = parts.length; i-- > 0;) {
            if (parts[i].lastIndexOf(prefix, 0) !== -1) {
                parts.splice(i, 1);
            }
        }
        url = urlBase + "?" + parts.join("&");
        window.history.pushState("", document.title, url);
    }
    return url;
}

// BUJS #1 – getParameterByName by James Padolsey (http://james.padolsey.com/javascript/bujs-1-getparameterbyname/)
function getUrlParameterValue(key) {
    var match = RegExp('[?&]' + key + '=([^&]*)').exec(window.location.search);
    return match && decodeURIComponent(match[1].replace('/\+/g', " "));
}

// add or update query string parameter by Niyaz (http://stackoverflow.com/a/6021027)
function addOrUpdateUrlParameterValue(key, value) {
    var url = window.location.href;
    var regExp = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = url.indexOf('?') !== -1 ? "&" : "?";
    if (url.match(regExp)) {
        window.history.pushState({}, null, url.replace(regExp, '$1' + key + "=" + value + '$2'));
    } else {
        window.history.pushState({}, null, url + separator + key + "=" + value);
    }
}

function getCookieRecord(cookieName) {
    var name = cookieName + "=";
    var cookies = document.cookie.split(';');
    for (var i = 0; i < cookies.length; i++) {
        var cookieValue = cookies[i];
        while (cookieValue.charAt(0) == ' ') {
            cookieValue = cookieValue.substring(1);
        }
        if (cookieValue.indexOf(name) == 0) {
            return cookieValue.substring(name.length, cookieValue.length);
        }
    }
    return "";
}

function checkCookieRecord(cookieName) {
    var cookieValue = getCookieRecord(cookieName);
    if (cookieValue != "") {
        return true;
    }
    return false;
}

function setCookieRecord(cookieName, cookieValue, expirationDaysCount) {
    var date = new Date();
    date.setFullYear(date.getFullYear() + expirationDaysCount);
    document.cookie = cookieName + "=" + cookieValue + "; path=/; expires=" + date.toUTCString();
}