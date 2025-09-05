export function useUrlBuilder(){
    function imageUrlBuilder(src) {
        `${import.meta.env.VITE_APP_STORE_IMAGE_URL}/uploads/images/shop/${src}`
    }

    return { imageUrlBuilder }
}
