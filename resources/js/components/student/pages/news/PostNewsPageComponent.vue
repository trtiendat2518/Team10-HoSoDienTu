<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Bản tin Văn Lang</p>
        </div>

        <div class="grid">
            <div class="notification-box-list">
                <div class="notification-box" v-for="post in posts" :key="post.post_id">
                    <div class="user-status notification">
                        <router-link tag="a" :to="{ name: 'postnewsdetail', params: { idPostNews: post.post_id } }">
                            <p class="user-status-title">
                                <i class="fa fa-hand-o-right"></i>
                                {{ post.post_title }}
                            </p>
                        </router-link>
                        <p class="user-status-timestamp">{{ post.post_date | formatFullTime }}</p>

                        <div class="user-status-icon">
                            <svg class="icon-minus-small">
                                <use xlink:href="#svg-minus-small"></use>
                            </svg>
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
            posts: []
        }
    },
    mounted() {
        this.fetchPostNoti()
    },
    methods: {
        fetchPostNoti(page_url) {
            page_url = `../../api/admin/post-news/bai-viet/post-news-all`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.posts = res.data
                })
                .catch(err => console.log(err))
        }
    }
}
</script>

<style scoped>
.user-status-title {
    font-weight: bold !important;
    font-size: 16px !important;
}
.user-status {
    padding: 0px !important;
}
.notification-box {
    border-bottom: 3px solid #6c757d;
    border-right: 3px solid #6c757d;
    cursor: pointer;
    background: linear-gradient(360deg, #faa8af63 0%, #fcfcfd 40%);
}
</style>
