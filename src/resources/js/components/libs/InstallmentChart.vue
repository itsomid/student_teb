<template>
    <div class="col-12 text-center">
        <VueApexCharts class="w-100" type="line" :options="options" :series="series" ></VueApexCharts>
    </div>
</template>

<script>
import VueApexCharts from 'vue3-apexcharts'
export default {
    name: "InstallmentChart",
    props:['installmentData'],

    components:{VueApexCharts},
    data(){
        return{
            quizData:[{"name":"پارسا آذرشین امیر 3","score":null,"quiz_done":false},{"name":"azmone jalase 2 new version جلسه 2","score":null,"quiz_done":false}],
            options:{
                chart: {
                    type: 'bar'
                },
                series: [{
                    data: [{
                        x: 'category A',
                        y: 10
                    }, {
                        x: 'category B',
                        y: 18
                    }, {
                        x: 'category C',
                        y: 13
                    }]
                }]
            },
            series: [{
                name: 'نمره',
                data: []
            }],
        }
    },

    beforeMount() {
        let x=[];
        let y=[];
        this.quizData.forEach(function (element) {
            let score = element.score === null ? 0 : element.score
            x.push(element.name.substring(0,9))
            y.push(score)
        });

        // this.options.xaxis.categories = x;
        this.series[0].data = y;


    },
}
</script>

<style scoped>

</style>
