<template>
    <select class="form-select" @change="changed($event)">
        <option value="pending" :selected="this.selected_option === 'pending'" class="bg-warning">در حال بررسی</option>
        <option value="approved" :selected="this.selected_option === 'approved'" class="bg-success">تایید شده</option>
        <option value="rejected" :selected="this.selected_option === 'rejected'" class="bg-danger">تایید نشده</option>
        <option value="management-review" :selected="this.selected_option === 'management-review'" class="bg-danger">بررسی مدیریت</option>
    </select>
</template>

<script>
import axios from "axios";

export default {
    name: "CardTransactionSelect",
    props:[
        'url',
        'selected_option'
    ],
    beforeCreate() {
            console.log(this.selected_option)
        },
    methods:{
        changed(event){
            axios.patch(this.url,
                    {status: event.target.value}
           ).then(res => {
               console.log('DONE!')

                Toastify({
                    text: "وضعیت کارت به کارت به موفقیت تغییر کرد",
                    duration: 3000000,
                        close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "center", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                },
                onClick: function(){} // Callback after click
            }).showToast();

            }).catch()

        }
    }
}
</script>

<style scoped>

</style>
