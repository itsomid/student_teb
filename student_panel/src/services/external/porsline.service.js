/**
 * Initializes the Porsline script.
 */
export const initPorsline = () => {
    /**
     * Loads the Porsline script asynchronously.
     */
    (function (){
        var script = document.createElement('script');
        script.src = "https://survey.porsline.ir/embed/eyJib3JkZXIiOiJub25lIiwid2lkdGgiOiIxMDAlIiwiaGVpZ2h0IjoiMTAwJSJ9/OKzNFnxy";
        script.defer = true;
        document.getElementsByTagName('head')[0].appendChild(script);
    }())
}
