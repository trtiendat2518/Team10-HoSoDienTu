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
                    <router-link tag="a" :to="{ name: 'postindex' }">Danh sách bài viết</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tạo mới</li>
            </ol>
            <!-- End breadcrumb -->
        </div>
        <button class="btn btn-primary mb-3 btn-3d" @click="back()"><i class="fa fa-arrow-left" aria-hidden="true"></i> Quay lại</button>
        <div class="card">
            <div class="card-header styling">
                <h3 class="card-title">Tạo mới bài viết</h3>
            </div>
            <div class="card-body">
                <form @submit.prevent="store()" @keydown="form.onKeydown($event)">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Tiêu đề <span class="text-danger">(*)</span></label>
                                <input v-model="form.post_title" type="text" class="form-control" placeholder="Nhập tiêu đề bài viết" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Hình đại diện <span class="text-danger">(*)</span></label>
                        <input
                            type="file"
                            class="form-control"
                            ref="fileupload"
                            id="post_avatar"
                            name="post_avatar"
                            @change="onAvatarChange"
                        />
                        <img class="styling-img-post center" v-if="form.post_avatar" :src="form.post_avatar" alt="profile" />
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nội dung <span class="text-danger">(*)</span></label>
                        <vue-editor v-model="form.post_content" :editorToolbar="customToolbar"></vue-editor>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Danh mục <span class="text-danger">(*)</span></label>
                                <select class="form-control" v-model="form.post_type">
                                    <option value="" selected disabled>Chọn trạng thái</option>
                                    <option disabled>--------------------</option>
                                    <option value="0">Thông báo chung</option>
                                    <option value="1">Bản tin Văn Lang</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Trạng thái <span class="text-danger">(*)</span></label>
                                <select class="form-control" v-model="form.post_status">
                                    <option value="" selected disabled>Chọn trạng thái</option>
                                    <option disabled>--------------------</option>
                                    <option value="0">Hiển thị</option>
                                    <option value="1">Ẩn</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-lg btn-success mt-1 btn-3d">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { VueEditor } from 'vue2-editor'
export default {
    data() {
        return {
            posts: [],
            form: new Form({
                post_id: '',
                post_title: '',
                post_content: '',
                post_author: this.$adminId,
                post_status: '',
                post_type: '',
                post_avatar: ''
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
    methods: {
        store() {
            this.form.post_avatar = document.getElementById('post_avatar').files[0]
            this.form
                .post('../../api/admin/post-news/bai-viet')
                .then(res => {
                    if (this.form.successful) {
                        this.form.reset()
                        this.form.clear()
                        this.$refs.fileupload.value = ''
                        this.$snotify.confirm('Thêm mới thành công! Bạn có muốn đi đến danh sách không?', {
                            timeout: 5000,
                            showProgressBar: true,
                            closeOnClick: false,
                            pauseOnHover: true,
                            buttons: [
                                {
                                    text: 'Có',
                                    action: toast => {
                                        this.$snotify.remove(toast.id)
                                        this.$router.push({ name: 'postindex' })
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
                .catch(err => {
                    const null_content = err.response.data.errors?.post_content?.length
                    const null_title = err.response.data.errors?.post_title?.length
                    const null_status = err.response.data.errors?.post_status?.length
                    const null_type = err.response.data.errors?.post_type?.length
                    const null_avatar = err.response.data.errors?.post_avatar?.length

                    if (null_title > 0 && null_content > 0 && null_status > 0 && null_type > 0 && null_avatar > 0) {
                        this.$snotify.error('Vui lòng không để trống!')
                    } else if (null_title > 0) {
                        this.$snotify.error(err.response.data.errors.post_title[0])
                    } else if (null_content > 0) {
                        this.$snotify.error(err.response.data.errors.post_content[0])
                    } else if (null_status > 0) {
                        this.$snotify.error(err.response.data.errors.post_status[0])
                    } else if (null_type > 0) {
                        this.$snotify.error(err.response.data.errors.post_type[0])
                    } else {
                        this.$snotify.error('Lỗi định dạng!')
                    }
                })
        },
        back() {
            this.$router.push({ name: 'postindex' })
        },
        onAvatarChange(e) {
            const file = e.target.files[0]
            this.form.post_avatar = URL.createObjectURL(file)
        }
    },
    beforeRouteLeave(to, from, next) {
        if (this.form.post_content == '' && this.form.post_title == '') {
            next()
        } else {
            this.$snotify.confirm('Bạn có chắc muốn quay lại? Nội dung chưa lưu sẽ bị mất.', {
                timeout: 5000,
                showProgressBar: true,
                closeOnClick: false,
                pauseOnHover: true,
                buttons: [
                    {
                        text: 'Có',
                        action: toast => {
                            this.$snotify.remove(toast.id)
                            next()
                        },
                        bold: false
                    },
                    {
                        text: 'Không',
                        action: toast => {
                            this.$snotify.remove(toast.id)
                            next(false)
                        },
                        bold: true
                    }
                ]
            })
        }
    }
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
.styling-img-post {
    display: block;
    width: 50vw;
    height: 40vh;
    margin-left: auto;
    margin-right: auto;
}
</style>
