/**
 * Initializes the Tavoos script.
 */
export const initTavoos = ()=> {
    /**
     * Loads the Tavoos script asynchronously.
     */
    var now = new Date();
    var sniper_head = document.getElementsByTagName("head")[0];
    var sniper_script = document.createElement("script");
    sniper_script.type = "text/javascript";
    sniper_script.async = true;
    var sniper_script_address = 'https://cdn.tavoos.net/services/retargeting/2730/sniper.js';
    sniper_script.src = sniper_script_address + '?v=' + now.getFullYear().toString() + '0' + now.getMonth() + '0' + now.getDate() + '0' + now.getHours();
    sniper_head.appendChild(sniper_script);
}