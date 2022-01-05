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
                                            <img
                                                :src="
                                                    `../public/avatar/lecturer/${lecturer_avatar}`
                                                "
                                                class="avatar-xxl"
                                                alt="profile"
                                            />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3 class="mt-3 text-white">{{ lecturer_fullname }}</h3>
                        <p class="mb-2 text-white" v-if="lecturer_role == 1">
                            Ban chủ nhiệm khoa
                        </p>
                        <p
                            class="mb-2 text-white"
                            v-else-if="lecturer_role == 2"
                        >
                            Chủ nhiệm sinh viên
                        </p>

                        <div v-if="infos.length == 0">
                            <router-link
                                tag="button"
                                class="btn btn-lg btn-light"
                                :to="{ name: 'infoformteachercreate' }"
                            >
                                Tạo mới hồ sơ cá nhân
                            </router-link>
                        </div>
                        <div v-else>
                            <router-link
                                tag="button"
                                class="btn btn-lg btn-light"
                                :to="{
                                    name: 'infoformteacherupdate',
                                    params: { idLecturer: lecturer_info_id }
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
                                    <table
                                        class="table row table-borderless w-100 m-0 border"
                                        v-for="info in infos"
                                        :key="info.lecturer_id"
                                    >
                                        <tbody class="col-lg-6 p-0">
                                            <tr>
                                                <td>
                                                    <strong>
                                                        Họ và tên :
                                                    </strong>
                                                    {{ info.lecturer_fullname }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>
                                                        Địa chỉ email :
                                                    </strong>
                                                    {{ info.lecturer_email }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>
                                                        Ngày sinh :
                                                    </strong>
                                                    {{
                                                        info.lecturer_birthday
                                                            | formatDate
                                                    }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>
                                                        Giới tính :
                                                    </strong>
                                                    <span
                                                        v-if="
                                                            info.lecturer_gender ==
                                                                0
                                                        "
                                                    >
                                                        Nam
                                                    </span>
                                                    <span
                                                        v-else-if="
                                                            info.lecturer_gender ==
                                                                1
                                                        "
                                                    >
                                                        Nữ
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>
                                                        Dân tộc :
                                                    </strong>
                                                    {{ info.lecturer_ethnic }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>
                                                        Tôn giáo :
                                                    </strong>
                                                    {{ info.lecturer_religion }}
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody class="col-lg-6 p-0">
                                            <tr>
                                                <td>
                                                    <strong>
                                                        Số điện thoại :
                                                    </strong>
                                                    {{ info.lecturer_phone }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>
                                                        Địa chỉ :
                                                    </strong>
                                                    {{ info.lecturer_address }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>
                                                        Quốc gia :
                                                    </strong>
                                                    {{ info.lecturer_country }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>
                                                        CMND/CCCD :
                                                    </strong>
                                                    {{
                                                        info.lecturer_identify_card
                                                    }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>
                                                        Nơi sinh :
                                                    </strong>
                                                    {{
                                                        info.lecturer_birth_place
                                                    }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>
                                                        Địa chỉ email khác :
                                                    </strong>
                                                    {{
                                                        info.lecturer_other_email
                                                    }}
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
export default {
    data() {
        return {
            lecturer_id: this.$teacherId,
            lecturer_fullname: "",
            lecturer_avatar: "",
            lecturer_info_id: "",
            lecturer_role: "",
            infos: []
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
                    this.infos = res.data;
                    this.lecturer_avatar = res.data[0].lecturer_avatar;
                    this.lecturer_info_id = res.data[0].lecturer_info_id;
                    this.lecturer_fullname = res.data[0].lecturer_fullname;
                    this.lecturer_role = res.data[0].lecturer_role;
                })
                .catch(err => console.log(err));
        }
    }
};
</script>

<style></style>
