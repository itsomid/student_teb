export function useReagent() {

    function setReagentCode(reagentCode){
        if (reagentCode) {
            localStorage.setItem('reagentCode', JSON.stringify(reagentCode));
        }
    }

    function getReagentCode(){
        return JSON.parse(localStorage.getItem('reagentCode'))
    }

    function removeReagentCode(){
        return localStorage.removeItem('reagentCode')
    }

    return {
        setReagentCode,
        getReagentCode,
        removeReagentCode
    }
}