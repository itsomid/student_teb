<template>
    <div class="row course-section">
        <div class="col-md-5">
            <div class="form-group">
               <input name="name"
                      id="name"
                      class="form-control"
                      placeholder="نام را وارد کنید."
                      required>
            </div>
        </div>
        <div class="col-md-5">
            <dynamic-select
                url="http://127.0.0.1:8000/api/users"
                label="اننتخاب دانش آموز"
                input_name="consumer_user_id"
                default_selected=""
                option_title="name"
                option_value="id"
            ></dynamic-select>
        </div>
        <div class="col-md-2 d-flex justify-content-center align-items-start">
            <button class="btn btn-success text-white mb-5" @click="addCourse" type="button">+</button>
            <input type="hidden" id="image_src">
        </div>
    </div>

    <div class="col-md-6 m-auto mb-5">
        <ul class="list-group">
            <li class="list-group-item" v-for="course in courses">
                <img :src="course.image_src" class="img-rounded" style="">
                <p v-text="course.name"></p>
                <button href="" class="btn btn-danger text-white" type="button" @click="removeItem(course.id)">X</button>
            </li>
        </ul>
    </div>

    <div class="col-md-5">
        <button class="btn btn-danger text-white" type="button" style="margin-bottom: 20px"
                @click="$emit('removeSection', section)">حذف این Secction
            <i class="fa fa-recycle"></i>
        </button>
    </div>
</template>

<script>

export default {
    name: "PackageSectionComponent",
    mounted() {
        // course-ajax-search
        // this.select2_class = 'course-ajax-search'+this.section.id;
        // let select2Class = this.select2_class;
        // $(function(){
        //   $('.'+select2Class).select2({
        //     ajax: {
        //       url: '/find_product',
        //       dataType: 'json',
        //       processResults: function (data) {
        //         console.log(data);
        //         return {
        //           results: data
        //         };
        //       }
        //     }
        //   });
        //   $('.'+select2Class).on('select2:select', function (e) {
        //     let image_src = e.params.data.image_src;
        //     $('#image_src').val(image_src);
        //   });
        // })

        this.section_name = this.section.title;
        this.courses = this.section.courses;


    },
    props: {
        section: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            courses: [],
            section_name: '',
            image_src: '',
            select2_class: '',
        }
    },
    methods: {
        fireSectionNameChange(e) {
            console.log(e.target.value);

            let section = this.section;
            section.title = this.section_name;
            section.courses = this.courses;

            this.$emit('changeSec', section);
        },
        addCourse() {
            let select2Class = this.select2_class;
            let image_src2 = document.getElementById('image_src')

            // let image_src = $('#image_src').val();
            // let product_id = $('.'+select2Class).select2('val');
            // let product_name = $('.'+select2Class).select2('data')[0].text;

            let findId = this.courses.filter(item => item.id == 1);
            if (findId.length > 0) {
                return;
            }

            this.courses.push({
                id: 1,
                name: 'درس اول یکتا',
                image_src: 'http://127.0.0.1:8000/images/avatars/male/4.png'
            });

            let section = this.section;
            section.courses = this.courses;
            this.$emit('changeSec', this.section)
        },
        removeItem(id) {
            this.courses = this.courses.filter((item) => item.id != id);

            let section = this.section;
            section.title = this.section_name;
            section.courses = this.courses;
            this.$emit('changeSec', this.section)
        },
    }
}
</script>

<style scoped>
.list-group-item {
    display: flex !important;
    justify-content: space-between;
    align-items: center;
}

.list-group-item img {
    width: 50px;
    height: 50px;
}

.list-group-item p {
    width: 65%;
    text-align: right;
}
</style>
