<template>
    <select class="form-select" @change="changed($event)">
        <option value="1" :selected="+this.selected_option === 1" class="bg-warning">در حال بررسی</option>
        <option value="2" :selected="+this.selected_option === 2" class="bg-success">تایید شده</option>
        <option value="3" :selected="+this.selected_option === 3" class="bg-danger">تایید نشده</option>
        <option value="4" :selected="+this.selected_option === 4" class="bg-danger">بررسی مدیریت</option>
    </select>
</template>

<script>
import axios from "axios";

export default {
    name: "DebitCardTransactionSelect",
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
            }).catch()

        }
    }
}
</script>

<style scoped>

</style>
