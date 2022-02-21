<template>
    <div>
        <!-- page-header -->
        <div class="page-header">
            <ol class="breadcrumb">
                <!-- breadcrumb -->
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'dashboard' }">
                        Dashboard
                    </router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Thông tin cá nhân
                </li>
            </ol>
        </div>
        <!-- End page-header -->

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile  overflow-hidden">
                    <div class="card-body text-center profile-bg">
                        <div class=" card-profile">
                            <div class="row justify-content-center">
                                <div class="">
                                    <div class="">
                                        <a href="#">
                                            <img :src="`../public/avatar/admin/${admin_avatar}`" class="avatar-xxl" alt="profile" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h3 class="mt-3 text-white">{{ admin_fullname }}</h3>
                        <p class="mb-2 text-white">Quản trị viên</p>
                        <div v-if="infos.length == 0">
                            <router-link tag="button" class="btn btn-lg btn-light" :to="{ name: 'infocreate' }">
                                Tạo mới hồ sơ cá nhân
                            </router-link>
                        </div>
                        <div v-else>
                            <router-link
                                tag="button"
                                class="btn btn-lg btn-light"
                                :to="{
                                    name: 'infoupdate',
                                    params: { idAdmin: admin_info_id }
                                }"
                            >
                                Cập nhật hồ sơ cá nhân
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="tab-content" id="myTabContent">
                            <div
                                class="tab-pane fade active show"
                                id="tabs-icons-text-1"
                                role="tabpanel"
                                aria-labelledby="tabs-icons-text-1-tab"
                            >
                                <div class="table-responsive mb-3">
                                    <table class="table row table-borderless w-100 m-0 border" v-for="info in infos" :key="info.admin_id">
                                        <tbody class="col-lg-6 p-0">
                                            <tr>
                                                <td>
                                                    <strong>
                                                        Họ và tên :
                                                    </strong>
                                                    {{ info.admin_fullname }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>
                                                        Địa chỉ email :
                                                    </strong>
                                                    {{ info.admin_email }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>
                                                        Ngày sinh :
                                                    </strong>
                                                    {{ info.admin_birthday | formatDate }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>
                                                        Giới tính :
                                                    </strong>
                                                    <span v-if="info.admin_gender == 0">
                                                        Nam
                                                    </span>
                                                    <span v-else-if="info.admin_gender == 1">
                                                        Nữ
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>
                                                        Dân tộc :
                                                    </strong>
                                                    {{ info.admin_ethnic }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>
                                                        Tôn giáo :
                                                    </strong>
                                                    {{ info.admin_religion }}
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody class="col-lg-6 p-0">
                                            <tr>
                                                <td>
                                                    <strong>
                                                        Số điện thoại :
                                                    </strong>
                                                    {{ info.admin_phone }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>
                                                        Địa chỉ :
                                                    </strong>
                                                    {{ info.admin_address }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>
                                                        Quốc gia :
                                                    </strong>
                                                    {{ info.admin_country }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>
                                                        CMND/CCCD :
                                                    </strong>
                                                    {{ info.admin_identify_card }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>
                                                        Nơi sinh :
                                                    </strong>
                                                    {{ info.admin_birth_place }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>
                                                        Địa chỉ email khác :
                                                    </strong>
                                                    {{ info.admin_other_email }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div v-show="!infos.length">
                                        <div class="alert alert-danger">
                                            Không tìm thấy kết quả phù hợp!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row end -->
    </div>
</template>

<script>
import { eventBus } from '../../../../app.js'
export default {
    data() {
        return {
            admin_id: this.$adminCode,
            admin_fullname: this.$adminId,
            admin_avatar: '',
            admin_info_id: '',
            infos: []
        }
    },
    mounted() {
        this.fetchInfo()
    },
    methods: {
        fetchInfo(page_url) {
            page_url = `../../api/admin/user-gv/giang-vien/thong-tin-ca-nhan/${this.admin_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.infos = res.data
                    this.admin_avatar = res.data[0].admin_avatar
                    this.admin_info_id = res.data[0].admin_info_id
                    eventBus.changeAvatar(res.data[0].admin_avatar)
                })
                .catch(err => console.log(err))
        }
    }
}
</script>

<style></style>
