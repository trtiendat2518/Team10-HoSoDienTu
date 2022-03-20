<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Chi tiết thủ tục</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            procedures: [],
            procedure_id: this.$route.params.idProcedureStudent
        }
    },
    watch: {
        $route(to, from) {
            this.procedure_id = to.params.idProcedureStudent
        }
    }
}
</script>

<style></style>
