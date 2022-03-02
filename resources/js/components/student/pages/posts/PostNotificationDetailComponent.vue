<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Thông báo chung</p>
        </div>

        <div class="grid">
            <div class="widget-box">
                <h3>{{ form.post_title }}</h3>
                <div class="widget-box-content">
                    <p v-html="form.post_content"></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            posts: [],
            post_id: this.$route.params.idPostNoti,
            form: new Form({
                post_id: '',
                post_title: '',
                post_content: '',
                post_type: ''
            })
        }
    },
    mounted() {
        this.fetchPosts()
    },
    methods: {
        fetchPosts(page_url) {
            page_url = `../../api/admin/post-news/bai-viet/post/${this.post_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.posts = res.data
                    this.form.fill(this.posts[0])
                })
                .catch(err => console.log(err))
        }
    }
}
</script>

<style></style>
