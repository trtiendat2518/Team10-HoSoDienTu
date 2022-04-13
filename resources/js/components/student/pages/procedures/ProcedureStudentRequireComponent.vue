<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Điền các thông tin yêu cầu</p>
        </div>

        <div class="grid">
            <div class="widget-box">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="widget-box-title">THÔNG TIN ĐĂNG KÝ</h4>
                        <hr />
                        <div class="widget-box-content">
                            <form class="form">
                                <div
                                    class="form-item mt-3"
                                    v-for="(input, index) in procedures_input"
                                    :key="'input_' + index"
                                    v-show="procedures_input.length > 0"
                                >
                                    <div class="form-input small active">
                                        <label for="profile-name">{{ input }}</label>
                                        <input
                                            type="text"
                                            class="half"
                                            :name="'input_' + index"
                                            :id="'input_' + index"
                                            :placeholder="'Nhập ' + input"
                                        />
                                    </div>
                                </div>

                                <div
                                    class="form-item mt-3"
                                    v-for="(area, index) in procedures_area"
                                    :key="'area_' + index"
                                    v-show="procedures_area.length > 0"
                                >
                                    <div class="form-input small active">
                                        <label for="profile-name">{{ area }}</label>
                                        <textarea
                                            :name="'area_' + index"
                                            :id="'area_' + index"
                                            rows="3"
                                            :placeholder="'Nhập ' + area"
                                        ></textarea>
                                    </div>
                                </div>

                                <div
                                    class="form-item mt-3"
                                    v-for="(select, index) in procedures_select"
                                    :key="'select_' + index"
                                    v-show="procedures_select.length > 0"
                                >
                                    <div class="form-select">
                                        <label for="profile-name">{{ procedures_select_title(select) }}</label>
                                        <select :name="'select_' + index" :id="'select_' + index">
                                            <option value="" disabled selected>Chọn {{ procedures_select_title(select) }}</option>
                                            <option v-for="value in procedures_option_value(select)" :key="value" :value="value">{{
                                                value
                                            }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div
                                    class="form-item mt-3"
                                    v-for="(file, index) in procedures_file"
                                    :key="'file_' + index"
                                    v-show="procedures_file.length > 0"
                                >
                                    <div class="form-input small active">
                                        <label for="profile-name">{{ file }}</label>
                                        <input type="file" :name="'file_' + index" :id="'file_' + index" ref="file" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4 class="widget-box-title">PHƯƠNG THỨC THANH TOÁN</h4>
                        <hr />
                        <div class="form-group">
                            <label>
                                <i class="fa fa-check-circle" aria-hidden="true"></i>
                                Giao hàng tận nơi và thanh toán khi nhận hàng (COD)
                            </label>
                        </div>
                        <div class="widget-box-content border-widget">
                            <h4>THÔNG TIN NGƯỜI NHẬN:</h4>
                            <hr />
                            <form class="form">
                                <div class="form-item mt-3">
                                    <div class="form-input small active">
                                        <label for="profile-name">Họ và tên</label>
                                        <input type="text" class="half" v-model="name" />
                                    </div>
                                </div>
                                <div class="form-item mt-3">
                                    <div class="form-input small active">
                                        <label for="profile-name">số điện thoại</label>
                                        <input type="text" class="half" v-model="phone" />
                                    </div>
                                </div>
                                <div class="form-item mt-3">
                                    <div class="form-input small active">
                                        <label for="profile-name">Địa chỉ nhận hàng</label>
                                        <input type="text" class="half" v-model="address" />
                                    </div>
                                </div>
                                <div class="form-item mt-3 mb-3">
                                    <div class="form-input small active">
                                        <label for="profile-name">Ghi chú</label>
                                        <textarea rows="3" v-model="note"></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="padding-style">
                            <button class="btn btn-primary" @click="store()">Gửi</button>
                            <router-link class=" btn btn-danger mt-3" tag="button" :to="{ name: 'procedurestudentindex' }">
                                Huỷ
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            student_id: this.$studentId,
            procedure_id: this.$route.params.idProcedureStudent,
            quantity: this.$route.params.totalQuantity,
            procedures: [],
            procedures_input: [],
            procedures_area: [],
            procedures_select: [],
            procedures_file: [],
            array_input: [],
            array_area: [],
            array_select: [],
            array_file: [],
            name: '',
            phone: '',
            address: '',
            note: ''
        }
    },
    mounted() {
        this.fetchProcedures()
    },
    watch: {
        $route(to, from) {
            this.procedure_id = to.params.idProcedureStudent
            this.quantity = to.params.totalQuantity
        }
    },
    methods: {
        fetchProcedures(page_url) {
            page_url = `../../api/student/procedure/yeu-cau-thuc-tuc-sv/${this.procedure_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    let input = res.data[0].procedure_input
                    let area = res.data[0].procedure_area
                    let select = res.data[0].procedure_select
                    let file = res.data[0].procedure_file

                    this.procedures_input = input.split('; ')
                    if (area == '' || area == null) {
                        this.procedures_area = []
                    } else {
                        this.procedures_area = area.split('; ')
                    }

                    if (select == '' || select == null) {
                        this.procedures_select = []
                    } else {
                        this.procedures_select = select.split('; ')
                    }

                    if (file == '' || file == null) {
                        this.procedures_file = []
                    } else {
                        this.procedures_file = file.split('; ')
                    }
                    this.procedures = res.data
                })
                .catch(err => console.log(err))
        },
        procedures_select_title(select) {
            let titleSelect = select.split(': ')
            return titleSelect[0]
        },
        procedures_option_value(select) {
            let titleSelect = select.split(': ')
            return titleSelect[1].split(', ')
        },
        store() {
            this.array_input = []
            this.array_area = []
            this.array_select = []
            this.array_file = []

            let formData = new FormData()
            formData.append('student_id', this.student_id)
            formData.append('procedure_id', this.procedure_id)
            formData.append('procedure_require_quantity', this.quantity)

            for (let i = 0; i < this.procedures_input.length; i++) {
                const value = document.getElementById('input_' + i).value
                if (value == '') {
                    this.$swal({
                        title: 'Vui lòng nhập đầy đủ thông tin',
                        icon: 'error',
                        confirmButtonText: 'OK!',
                        timer: 3500
                    })
                } else {
                    this.array_input.push(value)
                }
            }
            let joinInput = this.array_input.join('; ')
            formData.append('procedure_require_input', joinInput)

            if (this.name == '' || this.phone == '' || this.address == '') {
                this.$swal({
                    title: 'Vui lòng nhập đầy đủ thông tin nhận hàng',
                    icon: 'error',
                    confirmButtonText: 'OK!',
                    timer: 3500
                })
            } else {
                formData.append('procedure_require_name', this.name)
                formData.append('procedure_require_phone', this.phone)
                formData.append('procedure_require_address', this.address)
                formData.append('procedure_require_note', this.note)
            }

            if (this.procedures_area.length > 0) {
                for (let i = 0; i < this.procedures_area.length; i++) {
                    const value = document.getElementById('area_' + i).value
                    if (value == '') {
                        this.$swal({
                            title: 'Vui lòng nhập đầy đủ thông tin',
                            icon: 'error',
                            confirmButtonText: 'OK!',
                            timer: 3500
                        })
                    } else {
                        this.array_area.push(value)
                    }
                }
                let joinArea = this.array_area.join('; ')
                formData.append('procedure_require_area', joinArea)
            }

            if (this.procedures_select.length > 0) {
                for (let i = 0; i < this.procedures_select.length; i++) {
                    const value = document.getElementById('select_' + i).value
                    if (value == '') {
                        this.$swal({
                            title: 'Vui lòng nhập đầy đủ thông tin',
                            icon: 'error',
                            confirmButtonText: 'OK!',
                            timer: 3500
                        })
                    } else {
                        this.array_select.push(value)
                    }
                }
                let joinSelect = this.array_select.join('; ')
                formData.append('procedure_require_select', joinSelect)
            }

            if (this.procedures_file.length > 0) {
                for (let i = 0; i < this.procedures_file.length; i++) {
                    if (this.$refs.file[i].length == 0) {
                        this.$swal({
                            title: 'Vui lòng nhập đầy đủ thông tin',
                            icon: 'error',
                            confirmButtonText: 'OK!',
                            timer: 3500
                        })
                    } else {
                        formData.append('procedure_require_file[]', this.$refs.file[i].files[0])
                    }
                }
            }

            axios
                .post('../../api/student/procedure/yeu-cau-thuc-tuc-sv', formData)
                .then(res => {
                    this.$router.push({ name: 'procedurestudentlist' })
                    this.$swal({
                        title: 'Gửi thành công!',
                        icon: 'success',
                        confirmButtonText: 'OK!',
                        timer: 3500
                    })
                })
                .catch(err => console.log(err))
        }
    }
}
</script>

<style scoped>
.border-widget {
    padding: 17px 30px 0;
    border: 1px dashed black;
}
.padding-style {
    padding: 17px 30px 0;
}
input,
select,
textarea {
    background-color: #f4f4f46e !important;
}
</style>
