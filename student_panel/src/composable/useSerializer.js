/**
 * Composable function for serializing JSON objects into comma-separated values.
 * @returns {{ commaSeparatedSerializer: (json: Object<string, any>) => Object<string, any> }} An object containing the commaSeparatedSerializer function.
 */
export function useSerializer() {
    /**
     * Serializes JSON object properties into comma-separated values.
     * @param {Object<string, any>} json The JSON object to serialize.
     * @returns {Object<string, any>} The JSON object with serialized properties.
     */
    const commaSeparatedSerializer = (json) => {
        Object.keys(json).forEach((key) => {
            if (Array.isArray(json[key])) json[key] = json[key].join(',');
        });
        return json;
    };

    /**
     * Deserializes comma-separated values into an array of integers.
     * @param {string} csv The comma-separated values to deserialize.
     * @returns {number[]} An array of integers parsed from the comma-separated values.
     */
    const commaSeparatedDeserializer = (json) => {
        const array = []

        json.split(',').forEach((number, index) =>{
            array[index] = parseInt(number)
        })
        return  array;
    };


    return {
        commaSeparatedSerializer,
        commaSeparatedDeserializer,
    };
}
