<template>
    <div>
        <img
            :src="`../public/avatar/admin/${admin_avatar}`"
            class="avatar-xxl avatar-styling"
            alt="profile"
        />
    </div>
</template>

<script>
export default {
    data() {
        return {
            admin_id: this.$adminCode,
            admin_avatar: ""
        };
    },
    mounted() {
        this.fetchInfo();
    },
    methods: {
        fetchInfo(page_url) {
            page_url = `../../api/admin/user-gv/giang-vien/thong-tin-ca-nhan/${this.admin_id}`;
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.admin_avatar = res.data[0].admin_avatar;
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
