/**
 * Initializes the Goftino widget.
 */
export const initGoftino = () => {
    /**
     * Loads the Goftino widget script asynchronously.
     * @private
     */
    !function () {
        var i = "L1EmdY", a = window, d = document;

        function g() {
            var g = d.createElement("script"), s = "https://www.goftino.com/widget/" + i,
                l = localStorage.getItem("goftino_" + i);
            g.async = !0, g.src = l ? s + "?o=" + l : s;
            d.getElementsByTagName("head")[0].appendChild(g);
        }

        "complete" === d.readyState ? g() : a.attachEvent ? a.attachEvent("onload", g) : a.addEventListener("load", g, !1);
    }();
}