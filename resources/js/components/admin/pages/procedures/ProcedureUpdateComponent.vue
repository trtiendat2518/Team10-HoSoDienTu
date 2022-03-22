<template>
    <div>
        <!-- row -->
        <vue-snotify></vue-snotify>
        <div class="page-header">
            <ol class="breadcrumb">
                <!-- breadcrumb -->
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <router-link tag="a" :to="{ name: 'procedureindex' }">Danh sách thủ tục</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Cập nhật</li>
            </ol>
            <!-- End breadcrumb -->
        </div>
        <button class="btn btn-primary mb-3 btn-3d" @click="back()"><i class="fa fa-arrow-left" aria-hidden="true"></i> Quay lại</button>
        <div class="card">
            <div class="card-header styling">
                <h3 class="card-title">Cập nhật thủ tục</h3>
            </div>
            <div class="card-body">
                <form @submit.prevent="update()" @keydown="form.onKeydown($event)">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="form-label">Tiêu đề <span class="text-danger">(*)</span></label>
                                <input
                                    v-model="form.procedure_title"
                                    :class="{ 'is-invalid': form.errors.has('procedure_title') }"
                                    type="text"
                                    class="form-control"
                                />
                                <div
                                    class="text-danger"
                                    v-if="form.errors.has('procedure_title')"
                                    v-html="form.errors.get('procedure_title')"
                                ></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Mã thủ tục</label>
                                <input
                                    type="text"
                                    name="education_program_code"
                                    class="form-control not-allow"
                                    v-model="form.procedure_code"
                                    disabled
                                />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Danh mục <span class="text-danger">(*)</span></label>
                                <select
                                    class="form-control"
                                    v-model="form.procedure_category"
                                    :class="{ 'is-invalid': form.errors.has('procedure_category') }"
                                >
                                    <option value="" selected disabled>Chọn danh mục</option>
                                    <option disabled>--------------------</option>
                                    <option value="0">Phòng đào tạo</option>
                                    <option value="1">Phòng hành chính</option>
                                    <option value="2">Trung tâm hỗ trợ sinh viên</option>
                                </select>
                                <div
                                    class="text-danger"
                                    v-if="form.errors.has('procedure_category')"
                                    v-html="form.errors.get('procedure_category')"
                                ></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Phương thức <span class="text-danger">(*)</span></label>
                                <select
                                    class="form-control"
                                    v-model="form.procedure_method"
                                    :class="{ 'is-invalid': form.errors.has('procedure_method') }"
                                >
                                    <option value="" selected disabled>Chọn phương thức</option>
                                    <option disabled>--------------------</option>
                                    <option value="0">Nộp Online</option>
                                    <option value="1">Nộp tại Trường</option>
                                </select>
                                <div
                                    class="text-danger"
                                    v-if="form.errors.has('procedure_method')"
                                    v-html="form.errors.get('procedure_method')"
                                ></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Thời gian chuẩn bị <span class="text-danger">(*)</span></label>
                                <div class="input-group mb-2">
                                    <input
                                        type="number"
                                        min="0"
                                        v-model="form.procedure_time"
                                        class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('procedure_time') }"
                                    />
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">ngày</div>
                                    </div>
                                </div>
                                <div
                                    class="text-danger"
                                    v-if="form.errors.has('procedure_time')"
                                    v-html="form.errors.get('procedure_time')"
                                ></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Phí cần trả <span class="text-danger">(*)</span></label>
                                <div class="input-group mb-2">
                                    <input
                                        type="number"
                                        min="0"
                                        v-model="form.procedure_fee"
                                        class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('procedure_fee') }"
                                    />
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">đ</div>
                                    </div>
                                </div>
                                <div
                                    class="text-danger"
                                    v-if="form.errors.has('procedure_fee')"
                                    v-html="form.errors.get('procedure_fee')"
                                ></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nội dung <span class="text-danger">(*)</span></label>
                        <vue-editor
                            v-model="form.procedure_content"
                            :editorToolbar="customToolbar"
                            :style="{ 'border: 1px solid red;': form.errors.has('procedure_content') }"
                        ></vue-editor>
                        <div
                            class="text-danger"
                            v-if="form.errors.has('procedure_content')"
                            v-html="form.errors.get('procedure_content')"
                        ></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Thông tin yêu cầu sinh viên nhập <span class="text-danger">(*)</span></label>
                        <div class="input-group mb-2">
                            <textarea
                                v-model="form.procedure_input"
                                class="form-control"
                                placeholder="Mội thông tin cách nhau bằng dấu chấm phẩy"
                                rows="3"
                                :class="{ 'is-invalid': form.errors.has('procedure_input') }"
                            ></textarea>
                        </div>
                        <div
                            class="text-danger"
                            v-if="form.errors.has('procedure_input')"
                            v-html="form.errors.get('procedure_input')"
                        ></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nội dung yêu cầu sinh viên nhập</label>
                        <div class="input-group mb-2">
                            <textarea
                                v-model="form.procedure_area"
                                class="form-control"
                                placeholder="Mội thông tin cách nhau bằng dấu chấm phẩy"
                                rows="3"
                                :class="{ 'is-invalid': form.errors.has('procedure_area') }"
                            ></textarea>
                        </div>
                        <div class="text-danger" v-if="form.errors.has('procedure_area')" v-html="form.errors.get('procedure_area')"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Những lựa chọn yêu cầu sinh viên chọn</label>
                        <div class="input-group mb-2">
                            <textarea
                                v-model="form.procedure_select"
                                class="form-control"
                                placeholder="Ví dụ: Lựa chọn phân loại: Giỏi, Khá, Trung bình; Ngôn ngữ nội dung: Tiếng việt, Tiếng anh"
                                rows="3"
                                :class="{ 'is-invalid': form.errors.has('procedure_select') }"
                            ></textarea>
                        </div>
                        <div
                            class="text-danger"
                            v-if="form.errors.has('procedure_select')"
                            v-html="form.errors.get('procedure_select')"
                        ></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tệp đÍnh kèm yêu cầu sinh viên nộp</label>
                        <div class="input-group mb-2">
                            <textarea
                                v-model="form.procedure_file"
                                class="form-control"
                                placeholder="Mội thông tin cách nhau bằng dấu chấm phẩy"
                                rows="3"
                                :class="{ 'is-invalid': form.errors.has('procedure_file') }"
                            ></textarea>
                        </div>
                        <div class="text-danger" v-if="form.errors.has('procedure_file')" v-html="form.errors.get('procedure_file')"></div>
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn-3d btn btn-lg btn-success mt-1">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- row end -->
    </div>
</template>

<script>
import { VueEditor } from 'vue2-editor'
export default {
    data() {
        return {
            procedures: [],
            procedure_id: this.$route.params.idProcedure,
            form: new Form({
                procedure_id: '',
                procedure_code: '',
                procedure_title: '',
                procedure_content: '',
                procedure_time: '',
                procedure_method: '',
                procedure_fee: '',
                procedure_category: '',
                procedure_status: '',
                procedure_input: '',
                procedure_area: '',
                procedure_select: '',
                procedure_file: ''
            }),
            customToolbar: [
                [{ header: [false, 1, 2, 3, 4, 5, 6] }],
                [{ size: ['small', false, 'large', 'huge'] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ align: '' }, { align: 'center' }, { align: 'right' }, { align: 'justify' }],
                [{ header: 1 }, { header: 2 }],
                ['blockquote', 'code-block'],
                [{ list: 'ordered' }, { list: 'bullet' }, { list: 'check' }],
                [{ script: 'sub' }, { script: 'super' }],
                [{ indent: '-1' }, { indent: '+1' }],
                [{ color: [] }, { background: [] }],
                ['link', 'image', 'video', 'formula'],
                [{ direction: 'rtl' }]
            ]
        }
    },
    components: {
        VueEditor
    },
    watch: {
        $route(to, from) {
            this.procedure_id = to.params.idProcedure
        }
    },
    mounted() {
        this.fetchProcedures()
    },
    methods: {
        fetchProcedures(procedure_id, page_url) {
            let vm = this
            procedure_id = this.procedure_id
            page_url = `../../api/admin/procedure/thu-tuc/procedure-one/${procedure_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.procedures = res.data
                    this.form.fill(this.procedures[0])
                })
                .catch(err => console.log(err))
        },
        update() {
            this.form
                .put(`../../api/admin/procedure/thu-tuc/${this.form.procedure_id}`)
                .then(res => {
                    if (this.form.successful) {
                        this.$snotify.confirm('Cập nhật thành công! Bạn có muốn đi đến danh sách không?', {
                            timeout: 5000,
                            showProgressBar: true,
                            closeOnClick: false,
                            pauseOnHover: true,
                            buttons: [
                                {
                                    text: 'Có',
                                    action: toast => {
                                        this.$snotify.remove(toast.id)
                                        this.$router.push({ name: 'procedureindex' })
                                    },
                                    bold: false
                                },
                                {
                                    text: 'Không',
                                    action: toast => {
                                        this.$snotify.remove(toast.id)
                                    },
                                    bold: true
                                }
                            ]
                        })
                    }
                })
                .catch(err => console.log(err))
        },
        back() {
            this.$router.push({ name: 'procedureindex' })
        }
    }
    // beforeRouteLeave(to, from, next) {
    // 	if (this.form.post_content == '' && this.form.post_title == '') {
    // 		next();
    // 	}else{
    // 		this.$snotify.confirm('Bạn có chắc muốn quay lại? Nội dung chưa lưu sẽ bị mất.', {
    // 			timeout: 5000,
    // 			showProgressBar: true,
    // 			closeOnClick: false,
    // 			pauseOnHover: true,
    // 			buttons: [{
    // 				text: 'Có',
    // 				action: toast =>{
    // 					this.$snotify.remove(toast.id);
    // 					next();
    // 				},
    // 				bold: false
    // 			},{
    // 				text: 'Không',
    // 				action: toast => {
    // 					this.$snotify.remove(toast.id);
    // 					next(false);
    // 				},
    // 				bold: true
    // 			}]
    // 		});
    // 	}
    // }
}
</script>

<style lang="css" scoped>
.styling {
    background-color: darkblue;
    color: white;
    border-left: 2px solid white;
}
.btn-3d {
    border-bottom: 3px solid #6c757db0;
    border-right: 3px solid #6c757db0;
}
.not-allow {
    cursor: not-allowed;
}
textarea {
    resize: none;
}
</style>
