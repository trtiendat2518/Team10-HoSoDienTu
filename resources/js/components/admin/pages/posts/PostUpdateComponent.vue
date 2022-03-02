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
                <li class="breadcrumb-item active" aria-current="page">Danh sách bài viết</li>
                <li class="breadcrumb-item active" aria-current="page">Cập nhật</li>
            </ol>
            <!-- End breadcrumb -->
        </div>
        <button class="btn btn-primary mb-3 btn-3d" @click="back()"><i class="fa fa-arrow-left" aria-hidden="true"></i> Quay lại</button>
        <div class="card">
            <div class="card-header styling">
                <h3 class="card-title">Cập nhật bài viết</h3>
            </div>
            <div class="card-body">
                <form @submit.prevent="update()" @keydown="form.onKeydown($event)">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Tiêu đề <span class="text-danger">(*)</span></label>
                                <input v-model="form.post_title" type="text" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nội dung <span class="text-danger">(*)</span></label>
                        <vue-editor v-model="form.post_content" :editorToolbar="customToolbar"></vue-editor>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Danh mục <span class="text-danger">(*)</span></label>
                        <select class="form-control" v-model="form.post_type">
                            <option value="0">Thông báo chung</option>
                            <option value="1">Bản tin Văn Lang</option>
                        </select>
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
            posts: [],
            post_id: this.$route.params.idPost,
            form: new Form({
                post_id: '',
                post_title: '',
                post_content: '',
                post_type: '',
                post_author: this.$adminId
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
    mounted() {
        this.fetchPosts()
    },
    watch: {
        $route(to, from) {
            this.post_id = to.params.idPost
        }
    },
    methods: {
        fetchPosts(post_id, page_url) {
            let vm = this
            post_id = this.post_id
            page_url = `../../api/admin/post-news/bai-viet/post/${post_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.posts = res.data
                    this.form.fill(this.posts[0])
                })
                .catch(err => console.log(err))
        },
        update() {
            this.form
                .put(`../../api/admin/post-news/bai-viet/${this.form.post_id}`)
                .then(res => {
                    if (this.form.successful) {
                        this.$snotify.success('Cập nhật thành công!')
                        this.$snotify.confirm('Bạn có muốn đi đến danh sách không?', {
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

                    if (null_title > 0 && null_content > 0) {
                        this.$snotify.error('Vui lòng không để trống!')
                    } else if (null_title > 0) {
                        this.$snotify.error(err.response.data.errors.post_title[0])
                    } else if (null_content > 0) {
                        this.$snotify.error(err.response.data.errors.post_content[0])
                    } else {
                        this.$snotify.error('Lỗi định dạng!')
                    }
                })
        },
        back() {
            this.$router.push('/bai-viet')
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
</style>
