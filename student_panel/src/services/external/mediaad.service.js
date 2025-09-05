/**
 * Initializes the MediaAd script.
 */
export const initMediaAd = () => {
    /**
     * Loads the MediaAd script asynchronously.
     */
    (function (){
        var script = document.createElement('script');
        script.src = "https://s1.mediaad.org/serve/24489/retargeting.js";
        script.defer = true;
        document.getElementsByTagName('head')[0].appendChild(script);
    }())
}