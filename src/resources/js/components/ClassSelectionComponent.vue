<template>
    <div class="classino-autocomplete">
        <input
            id="product-inp"
            :placeholder="defaultValue && defaultValue.product_id ? `(#${defaultValue.product_id}) ${defaultValue.product_name}` : 'نام محصول را وارد کنید.'"
            class="form-control"
            v-model="inputValue"
            @keyup="onKeyUp"
            @focus="onFocus"
            @focusout="onFocusOut"
            autocomplete="off"
        />
        <input
            id="my_input_product_id"
            :name="inputName"
            type="hidden"
            :value="selectedProductId || defaultValue"
        />
        <div
            class="classino-autocomplete-container"
            id="product-container"
            :style="{ display: containerVisible ? 'block' : 'none' }"
        >
            <ul id="product-info">
                <li v-for="product in products" :key="product.product_id">
          <span @click="selectProduct(product)">
            (#{{ product.product_id }}) {{ product.name }}
          </span>
                    <ul v-if="product.children && product.children.length" :data-parent="product.product_id">
                        <li
                            v-for="child in product.children"
                            :key="child.product_id"
                            @click="selectProduct(child)"
                        >
                            (#{{ child.product_id }}) {{ child.name }}
                        </li>
                    </ul>
                </li>
            </ul>
            <span id="product-not-found" v-if="!products.length && noResults">نتیجه ای یافت نشد.</span>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';

export default {
    props: {
        product: {
            type: Object,
            default: null
        },
        inputName: {
            type: String,
            required: true
        },
        defaultValue: {
            type: String,
            default: null
        }
    },
    setup(props) {
        const inputValue = ref('');
        const selectedProductId = ref(null);
        const products = ref([]);
        const containerVisible = ref(false);
        const noResults = ref(false);
        const searchStartLength = ref(3);

        // Initialize the input with default values if provided
        onMounted(() => {
            if (props.defaultValue) {
                const defaultValue = JSON.parse(props.defaultValue)
                inputValue.value = `(#${defaultValue.product_id}) ${defaultValue.product_name}`;
                selectedProductId.value = defaultValue.product_id;
            }
        });
        const onKeyUp = () => {
            const productName = inputValue.value;
            if (productName.length >= searchStartLength.value) {
                fetchProducts(productName);
            } else {
                noResults.value = true;
                containerVisible.value = true;
            }
        };

        const onFocus = () => {
            if (inputValue.value.length === 0) {
                containerVisible.value = false;
            } else {
                containerVisible.value = true;
            }
        };

        const onFocusOut = () => {
            setTimeout(() => {
                containerVisible.value = false;
            }, 200); // Add a short delay to allow item clicks to be registered
        };

        const fetchProducts = (productName) => {
            // Replace with your actual API call
            fetch(`/admin/course/search/${productName}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.length) {
                        products.value = data;
                        noResults.value = false;
                    } else {
                        noResults.value = true;
                    }
                    containerVisible.value = true;
                })
                .catch(error => {
                    console.error('Error:', error);
                    noResults.value = true;
                    containerVisible.value = true;
                });
        };

        const selectProduct = (product) => {
            selectedProductId.value = product.product_id;
            inputValue.value = `(#${product.product_id}) ${product.name}`;
            containerVisible.value = false;
        };

        return {
            inputValue,
            selectedProductId,
            products,
            containerVisible,
            noResults,
            searchStartLength,
            onKeyUp,
            onFocus,
            onFocusOut,
            fetchProducts,
            selectProduct
        };
    }
};
</script>

<style>
.classino-autocomplete{
    position: relative;
}
.classino-autocomplete-container{
    left: 0;
    position: absolute;
    width: 100%;
    z-index: 2;
    background-color: #fff;
    border-radius: 4px;
    box-shadow: 0 0.5em 1em -0.125em hsla(0,0%,4%,.1), 0 0 0 1px hsla(0,0%,4%,.02);
}
.classino-autocomplete-container > ul{
    list-style-type: none;
    overflow: auto;
    max-height: 200px;
    margin-bottom: 5px;
    padding-bottom: .5rem;
    padding-top: .5rem;
    padding-right: 0;
    padding-left: 0;
}
.classino-autocomplete-container .is-disabled {
    padding: 10px;
}
.classino-autocomplete-container li{
    color: #4a4a4a;
    display: block;
    font-size: 1rem;
    cursor:pointer;
    line-height: 1.5;
    padding: .5rem 1rem;
    position: relative;
}

.classino-autocomplete-container > ul > li > span{
    font-weight: 700;
    font-size: 1rem;
    line-height: 3rem;
}
.classino-autocomplete-container > ul > li > ul{
    padding-right: 0;
}

.classino-autocomplete-container > ul > li  >ul >li {
    background: #eaeaea;
}
.classino-autocomplete-container span:hover{
    cursor: pointer;
    background-color: #e9e9e9;

}
.classino-autocomplete-container.danger{
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
    cursor: not-allowed;
    padding: 15px;
}
</style>
