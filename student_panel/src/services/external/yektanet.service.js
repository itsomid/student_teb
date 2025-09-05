/**
 * Initializes the Yektanet analytics.
 */
export const initYektanet = ()=> {
    /**
     * Loads the Yektanet analytics script asynchronously.
     * @param {Window} t - The window object.
     * @param {Document} e - The document object.
     * @param {string} n - The name of the analytics object.
     */
    !function (t, e, n) {
        t.yektanetAnalyticsObject = n, t[n] = t[n] || function () {
            t[n].q.push(arguments)
        }, t[n].q = t[n].q || [];
        var a = new Date, r = a.getFullYear().toString() + "0" + a.getMonth() + "0" + a.getDate() + "0" + a.getHours(),
            c = e.getElementsByTagName("script")[0], s = e.createElement("script");
        s.id = "ua-script-nVOgPAwt"; s.dataset.analyticsobject = n;
        s.async = 1; s.type = "text/javascript";
        s.src = "https://cdn.yektanet.com/rg_woebegone/scripts_v3/nVOgPAwt/rg.complete.js?v=" + r, c.parentNode.insertBefore(s, c)
    }(window, document, "yektanet");
}