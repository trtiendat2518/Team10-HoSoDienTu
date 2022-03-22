<template>
    <div class="container">
        <div class="section-banner">
            <img class="section-banner-icon" :src="`../public/student/img/banner/newsfeed-icon.png`" alt="newsfeed-icon" />
            <p class="section-banner-title">Danh sách thủ tục đã yêu cầu</p>
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
                        - Mỗi thủ tục sẽ có một mã số, vui lòng cung cấp mã số cho nhà trường trong trường hợp nhận thủ tục tại trường.
                    </div>
                </div>
            </div>

            <div class="widget-box">
                <div class="table-responsive">
                    <table class="table card-table ">
                        <thead class="blue-background text-white">
                            <tr>
                                <th class="text-center text-white" width="10%">
                                    Mã thủ tục
                                </th>
                                <th class="text-center text-white">
                                    Thủ tục
                                </th>
                                <th class="text-center text-white" width="15%">
                                    Ngày gửi
                                </th>
                                <th class="text-center text-white" width="15%">
                                    Ngày nhận
                                </th>
                                <th class="text-center text-white" width="10%">
                                    Tình trạng
                                </th>
                                <th class="text-center text-white" width="15%">
                                    Người tiếp nhận
                                </th>
                                <th class="text-center text-white" width="10%">
                                    Thao tác
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-show="procedures.length" v-for="procedure in procedures" :key="procedure.procedure_require_id">
                                <td class="text-center">
                                    {{ procedure.procedure_require_code }}
                                </td>
                                <td class="text-center">
                                    {{ procedure.procedure_title }}
                                </td>
                                <td class="text-center">
                                    {{ procedure.procedure_require_datesend | formatDate }}
                                </td>
                                <td class="text-center">
                                    <div v-if="procedure.procedure_require_dateget == null || procedure.procedure_require_dateget == ''">
                                        Chưa nhận
                                    </div>
                                    <div v-else>
                                        {{ procedure.procedure_require_dateget | formatDate }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div v-if="procedure.procedure_require_status == 0">
                                        Chờ xác nhận
                                    </div>
                                    <div v-else-if="procedure.procedure_require_status == 1">
                                        Đang xử lý
                                    </div>
                                    <div v-else-if="procedure.procedure_require_status == 2">
                                        Hoàn tất
                                    </div>
                                    <div v-else-if="procedure.procedure_require_status == 3">
                                        Đã bị huỷ
                                    </div>
                                </td>
                                <td class="text-center">
                                    {{ procedure.procedure_require_admin }}
                                </td>
                                <td>
                                    <button
                                        class="btn-3d btn btn-danger btn-lg fa fa-trash"
                                        :disabled="procedure.procedure_require_status != 0"
                                        @click="destroy(procedure.procedure_require_id)"
                                    ></button>
                                </td>
                            </tr>
                            <tr v-show="!procedures.length">
                                <td colspan="8">
                                    <div class="alert alert-danger">
                                        Không tìm thấy kết quả phù hợp!
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <router-link class=" btn btn-primary mt-3 btn-back" tag="button" :to="{ name: 'procedurestudentindex' }">
                    Quay lại
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            student_id: this.$studentId,
            procedures: []
        }
    },
    mounted() {
        this.fetchProcedures()
    },
    methods: {
        fetchProcedures(page_url) {
            page_url = `../../api/student/procedure/yeu-cau-thuc-tuc-sv/my-procedures/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.procedures = res.data
                })
                .catch(err => console.log(err))
        },
        destroy(procedure_require_id) {
            this.$swal({
                title: 'Bạn có chắc chắn xoá?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xoá !',
                cancelButtonText: 'Quay lại !'
            }).then(result => {
                if (result.isConfirmed) {
                    axios
                        .delete(`../../api/student/procedure/yeu-cau-thuc-tuc-sv/${procedure_require_id}`)
                        .then(res => {
                            this.fetchProcedures()
                            this.$swal({
                                title: 'Xoá thành công!',
                                icon: 'success',
                                confirmButtonText: 'OK!',
                                timer: 3500
                            })
                        })
                        .catch(err => console.log(err))
                }
            })
        }
    }
}
</script>

<style scoped>
.btn-back {
    width: 20%;
}
</style>
