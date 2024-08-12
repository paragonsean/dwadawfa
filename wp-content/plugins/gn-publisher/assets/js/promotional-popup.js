function gnpub_set_admin_occasional_ads_pop_up_cookie() {
    var o = new Date();
    o.setFullYear(o.getFullYear() + 1), (document.cookie = "gnpub_hide_admin_occasional_ads_pop_up_cookie_feedback=1; expires=" + o.toUTCString() + "; path=/");
}
function gnpub_delete_admin_occasional_ads_pop_up_cookie() {
    document.cookie = "gnpub_hide_admin_occasional_ads_pop_up_cookie_feedback=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;";
}
function gnpub_get_admin_occasional_ads_pop_up_cookie() {
    for (var o = "gnpub_hide_admin_occasional_ads_pop_up_cookie_feedback=", a = decodeURIComponent(document.cookie).split(";"), e = 0; e < a.length; e++) {
        for (var c = a[e]; " " == c.charAt(0); ) c = c.substring(1);
        if (0 == c.indexOf(o)) return c.substring(o.length, c.length);
    }
    return "";
}
jQuery(function (o) {
    var a = gnpub_get_admin_occasional_ads_pop_up_cookie();
    void 0 !== a && "" !== a && o("details#gnpub-ocassional-pop-up-container").attr("open", !1),
        o("details#gnpub-ocassional-pop-up-container span.gnpub-promotion-close-btn").click(function (a) {
            o("details#gnpub-ocassional-pop-up-container summary").click();
        }),
        o("details#gnpub-ocassional-pop-up-container summary").click(function (a) {
            var e = o(this).parents("details#gnpub-ocassional-pop-up-container"),
                c = o(e).attr("open");
            void 0 !== c && !1 !== c ? gnpub_set_admin_occasional_ads_pop_up_cookie() : gnpub_delete_admin_occasional_ads_pop_up_cookie();
        });
});
