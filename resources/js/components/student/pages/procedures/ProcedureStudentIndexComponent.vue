<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Danh sách các thủ tục</p>
        </div>

        <div class="grid">
            <div class="alert alert-info">
                <div class="mb-2">
                    <p>
                        <i>
                            <u><b>Lưu ý:</b> </u>
                        </i>
                    </p>
                    <div class="mt-2">
                        - Sinh viên chỉ được đăng ký mới thủ tục khi chưa đăng ký thủ tục đó hoặc đã đăng ký mà thủ tục đó đã hoàn thành
                    </div>
                </div>
                <div>
                    <div>
                        - Từ ngày 01/05/2021, SV đăng ký hồ sơ, SV đăng ký trả hồ sơ qua bưu điện. Bưu điện sẽ trực tiếp thu phí chuyển phát
                        từ 10 - 20k/ hồ sơ tuỳ thu vực và trọng lượng
                    </div>
                </div>
            </div>

            <router-link class=" btn btn-info mt-3" tag="button" :to="{ name: 'procedurestudentlist' }">
                Xem danh sách đã yêu cầu
            </router-link>

            <div class="panel-group" role="tablist">
                <div class="panel panel-default mt-3" v-for="i in categories" :key="i">
                    <div class="panel-heading" role="tab">
                        <h4 class="panel-title">
                            <a role="button" class="a-btn">
                                <table class="table table-borderless table-heading">
                                    <tbody>
                                        <tr>
                                            <td class="border-less text-white" width="32%">
                                                <div v-if="i == 0">Phòng đào tạo</div>
                                                <div v-else-if="i == 1">Phòng hành chính</div>
                                                <div v-else-if="i == 2">Trung tâm hỗ trợ sinh viên</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </a>
                        </h4>
                    </div>
                    <div
                        class="panel-collapse"
                        role="tabpanel"
                        v-show="procedures[i].length"
                        v-for="(procedure, index) in procedures[i]"
                        :key="procedure.procedure_id"
                    >
                        <table class="table table-bordered white-table">
                            <tbody>
                                <tr>
                                    <td class="text-center" width="5%">{{ (index += 1) }}</td>
                                    <td width="50%">
                                        <router-link
                                            tag="a"
                                            :to="{ name: 'procedurestudentdetail', params: { idProcedureStudent: procedure.procedure_id } }"
                                        >
                                            {{ procedure.procedure_title }}
                                        </router-link>
                                    </td>
                                    <td class="text-center" width="15%">Thời gian: {{ procedure.procedure_time }} ngày</td>
                                    <td class="text-center" width="15%">
                                        <div v-if="procedure.procedure_method == 0">Nộp online</div>
                                        <div v-else-if="procedure.procedure_method == 1">Nộp tại trường</div>
                                    </td>
                                    <td class="text-center">
                                        <div class="background-text" v-if="procedure.procedure_fee == 0">Miễn phí</div>
                                        <div class="background-text" v-else>{{ procedure.procedure_fee | formatNumber }} đ</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
            categories: []
        }
    },
    mounted() {
        this.fetchProcedures()
    },
    methods: {
        fetchProcedures(page_url) {
            page_url = `../../api/student/procedure/yeu-cau-thuc-tuc-sv`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    const procedures = res.data.reduce((procedures, item) => {
                        const procedure = procedures[item.procedure_category] || []
                        procedure.push(item)
                        procedures[item.procedure_category] = procedure
                        return procedures
                    }, {})

                    this.categories = Object.keys(procedures)
                    this.procedures = procedures
                })
                .catch(err => console.log(err))
        }
    }
}
</script>

<style scoped>
.border-less {
    font-weight: bold;
    border: none !important;
}
.panel-heading {
    background-color: darkblue;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
}
.panel-default {
    margin-top: -13px;
}
.a-btn {
    cursor: pointer;
}
.panel-heading:hover {
    background-color: #1c3372;
}
.white-table {
    background-color: #fff;
    margin-top: 0px !important;
}
.input-point {
    height: 30px;
    padding: 5px;
    text-align: center;
    width: 50px;
    background-color: #e8c79c5e;
}
.disable-input {
    background-color: #b4dcfa;
}
.td-title {
    font-weight: bold;
}
.table td,
.table th {
    vertical-align: middle !important;
}
.background-text {
    background-color: #a5282b;
    color: #fff;
    border-radius: 4px;
}
a {
    color: #a5282b;
}
</style>
