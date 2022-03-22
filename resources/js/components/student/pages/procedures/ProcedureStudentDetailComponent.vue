<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">{{ title }}</p>
        </div>

        <div class="grid">
            <div v-for="procedure in procedures" :key="procedure.procedure_id">
                <div class="widget-box">
                    <div class="widget-box-content">
                        <div v-html="procedure.procedure_content"></div>
                    </div>
                </div>

                <div class="widget-box mt-3 backgound-footer">
                    <div class="row">
                        <div class="col-md-4">Thời gian xử lý: {{ procedure.procedure_time }} ngày</div>
                        <div class="col-md-3">
                            <div v-if="procedure.procedure_fee == 0">Phí thủ tục: Miễn phí</div>
                            <div v-else>Phí thủ tục: {{ procedure.procedure_fee | formatNumber }} VNĐ</div>
                        </div>
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-3">Số lượng:</div>
                                <div class="col-md-3">
                                    <button class="btn btn-info" @click="down()">-</button>
                                </div>
                                <div class="col-md-3">
                                    <input class="w-100 form-control" type="number" min="1" v-model="quantity" />
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-info" @click="up()">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-md-4">
                            <router-link class=" btn btn-warning w-50" tag="button" :to="{ name: 'procedurestudentindex' }">
                                Quay lại
                            </router-link>
                        </div>
                        <div class="col-md-4">
                            <div v-if="procedure.procedure_fee == 0">Tổng tiền: Miễn phí</div>
                            <div v-else>Tổng tiền: {{ (procedure.procedure_fee * quantity) | formatNumber }} VNĐ</div>
                        </div>
                        <div class="col-md-4">
                            <router-link
                                class=" btn btn-danger w-50 float-right"
                                tag="button"
                                :to="{
                                    name: 'procedurestudentrequire',
                                    params: { idProcedureStudent: procedure.procedure_id, totalQuantity: quantity }
                                }"
                            >
                                Tiếp tục
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
            procedures: [],
            procedure_id: this.$route.params.idProcedureStudent,
            quantity: 1,
            title: ''
        }
    },
    mounted() {
        this.fetchProcedures()
    },
    watch: {
        $route(to, from) {
            this.procedure_id = to.params.idProcedureStudent
        }
    },
    methods: {
        fetchProcedures(page_url) {
            page_url = `../../api/student/procedure/yeu-cau-thuc-tuc-sv/${this.procedure_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.procedures = res.data
                    this.title = res.data[0].procedure_title
                })
                .catch(err => console.log(err))
        },
        up() {
            this.quantity++
        },
        down() {
            if (this.quantity == 1) {
                return this.quantity
            } else {
                this.quantity--
            }
        }
    }
}
</script>

<style scoped>
div >>> p img {
    width: 100%;
}
.backgound-footer {
    font-weight: bold;
    color: white;
    background-color: #495057;
}
</style>
