<template>
    <div>
        <div>
            <img
                :src="`../public/avatar/lecturer/${lecturer_avatar}`"
                class="avatar-xxl avatar-styling"
                alt="profile"
            />
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            lecturer_id: this.$teacherId,
            lecturer_avatar: ""
        };
    },
    mounted() {
        this.fetchInfo();
    },
    methods: {
        fetchInfo(page_url) {
            page_url = `../../api/admin/user-gv/giang-vien/thong-tin-ca-nhan-bcnk/${this.lecturer_id}`;
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.lecturer_avatar = res.data[0].lecturer_avatar;
                })
                .catch(err => console.log(err));
        }
    }
};
</script>

<style scoped>
.avatar-styling {
    border-radius: 50%;
    width: 6rem;
    height: 6rem;
}
</style>
