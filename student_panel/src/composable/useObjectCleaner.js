/**
 * @created        21/09/2023 - 03:54
 * @author         Nariman Palangi
 * @user           ragnarok
 * @organization
 * @project        hr-rd
 * @file name      useObjectCleaner.js
 * @file dir       src/composable
 */
import {useDateFormatter} from "@/composable/useDate";

export function useCleaner(obj) {
    for (var propName in obj) {
        if (
            obj[propName] === null ||
            obj[propName] === undefined ||
            obj[propName] === ""
        ) {
            delete obj[propName];
        } else if (propName === "from" || propName === "to") {
            obj[propName] = useDateFormatter(obj[propName], 'SERVER', 'en').substring(0, 10);
        }
    }
    return obj;
}