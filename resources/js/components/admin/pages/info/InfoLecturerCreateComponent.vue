<template>
    <div>
        <vue-snotify></vue-snotify>
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
                    <router-link tag="a" :to="{ name: 'infolecturerindex' }">
                        Thông tin cá nhân
                    </router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Nhập thông tin
                </li>
            </ol>
        </div>
        <!-- End page-header -->

        <form @submit.prevent="store()" @keydown="form.onKeydown($event)">
            <div class="row">
                <div class="col-lg-12 col-xl-4 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Cập nhật hình ảnh</h3>
                            <div class="card-options">
                                <router-link
                                    tag="a"
                                    class="btn btn-primary btn-sm"
                                    :to="{ name: 'infolecturerindex' }"
                                >
                                    <i class="si si-eye mr-1"></i>Xem hồ sơ
                                </router-link>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <div class="row">
                                    <div
                                        class="col-xl-12 col-lg-12 col-md-12 userprofile"
                                    >
                                        <div class="text-center mb-2">
                                            <img
                                                class="avatar-xxl"
                                                v-if="lecturer_avatar"
                                                :src="lecturer_avatar"
                                                alt="profile"
                                            />
                                        </div>
                                        <p class="text-center">
                                            Ảnh hồ sơ
                                            <span class="text-danger">
                                                (*)
                                            </span>
                                        </p>
                                        <div class="form-group">
                                            <input
                                                class="form-control"
                                                type="file"
                                                id="lecturer_avatar"
                                                name="lecturer_avatar"
                                                ref="fileupload"
                                                @change="onAvatarChange"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xl-8 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Cập nhật hồ sơ</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">Họ và tên</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    :value="lecturer_fullname"
                                    disabled
                                />
                                <div
                                    class="text-danger mb-3"
                                    v-if="form.errors.has('lecturer_fullname')"
                                    v-html="
                                        form.errors.get('lecturer_fullname')
                                    "
                                ></div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">
                                            Dân tộc
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Nhập dân tộc"
                                            name="lecturer_religion"
                                            v-model="form.lecturer_religion"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'lecturer_religion'
                                                )
                                            }"
                                        />
                                        <div
                                            class="text-danger mb-3"
                                            v-if="
                                                form.errors.has(
                                                    'lecturer_religion'
                                                )
                                            "
                                            v-html="
                                                form.errors.get(
                                                    'lecturer_religion'
                                                )
                                            "
                                        ></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">
                                            Tôn giáo
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Nhập tôn giáo"
                                            name="lecturer_ethnic"
                                            v-model="form.lecturer_ethnic"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'lecturer_ethnic'
                                                )
                                            }"
                                        />
                                        <div
                                            class="text-danger mb-3"
                                            v-if="
                                                form.errors.has(
                                                    'lecturer_ethnic'
                                                )
                                            "
                                            v-html="
                                                form.errors.get(
                                                    'lecturer_ethnic'
                                                )
                                            "
                                        ></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">
                                            Ngày sinh
                                            <span class="text-danger">
                                                (*)
                                            </span>
                                        </label>
                                        <input
                                            type="date"
                                            class="form-control"
                                            name="lecturer_birthday"
                                            v-model="form.lecturer_birthday"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'lecturer_birthday'
                                                )
                                            }"
                                        />
                                        <div
                                            class="text-danger mb-3"
                                            v-if="
                                                form.errors.has(
                                                    'lecturer_birthday'
                                                )
                                            "
                                            v-html="
                                                form.errors.get(
                                                    'lecturer_birthday'
                                                )
                                            "
                                        ></div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">
                                            Giới tính
                                            <span class="text-danger">
                                                (*)
                                            </span>
                                        </label>
                                        <select
                                            class="form-control"
                                            v-model="form.lecturer_gender"
                                            name="lecturer_gender"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'lecturer_gender'
                                                )
                                            }"
                                        >
                                            <option
                                                value=""
                                                disabled
                                                selected=""
                                            >
                                                ---
                                            </option>
                                            <option value="0">Nam</option>
                                            <option value="1">Nữ</option>
                                        </select>
                                        <div
                                            class="text-danger mb-3"
                                            v-if="
                                                form.errors.has(
                                                    'lecturer_gender'
                                                )
                                            "
                                            v-html="
                                                form.errors.get(
                                                    'lecturer_gender'
                                                )
                                            "
                                        ></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">
                                            Nơi sinh
                                            <span class="text-danger">
                                                (*)
                                            </span>
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Nhập nơi sinh"
                                            name="lecturer_birth_place"
                                            v-model="form.lecturer_birth_place"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'lecturer_birth_place'
                                                )
                                            }"
                                        />
                                        <div
                                            class="text-danger mb-3"
                                            v-if="
                                                form.errors.has(
                                                    'lecturer_birth_place'
                                                )
                                            "
                                            v-html="
                                                form.errors.get(
                                                    'lecturer_birth_place'
                                                )
                                            "
                                        ></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">
                                            CMND/CCCD
                                            <span class="text-danger">
                                                (*)
                                            </span>
                                        </label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            placeholder="Nhập CMND hoặc CCCD"
                                            name="lecturer_identify_card"
                                            v-model="
                                                form.lecturer_identify_card
                                            "
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'lecturer_identify_card'
                                                )
                                            }"
                                        />
                                        <div
                                            class="text-danger mb-3"
                                            v-if="
                                                form.errors.has(
                                                    'lecturer_identify_card'
                                                )
                                            "
                                            v-html="
                                                form.errors.get(
                                                    'lecturer_identify_card'
                                                )
                                            "
                                        ></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">
                                            Quốc gia
                                            <span class="text-danger">
                                                (*)
                                            </span>
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Nhập quốc tịch hiện tại"
                                            name="lecturer_country"
                                            v-model="form.lecturer_country"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'lecturer_country'
                                                )
                                            }"
                                        />
                                        <div
                                            class="text-danger mb-3"
                                            v-if="
                                                form.errors.has(
                                                    'lecturer_country'
                                                )
                                            "
                                            v-html="
                                                form.errors.get(
                                                    'lecturer_country'
                                                )
                                            "
                                        ></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">
                                            Số điện thoại
                                            <span class="text-danger">
                                                (*)
                                            </span>
                                        </label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            placeholder="Nhập số điện thoại liên lạc"
                                            v-model="form.lecturer_phone"
                                            name="lecturer_phone"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'lecturer_phone'
                                                )
                                            }"
                                        />
                                        <div
                                            class="text-danger mb-3"
                                            v-if="
                                                form.errors.has(
                                                    'lecturer_phone'
                                                )
                                            "
                                            v-html="
                                                form.errors.get(
                                                    'lecturer_phone'
                                                )
                                            "
                                        ></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">
                                            Địa chỉ Email cá nhân
                                            <span class="text-danger">
                                                (*)
                                            </span>
                                        </label>
                                        <input
                                            type="email"
                                            class="form-control"
                                            placeholder="Nhập địa chỉ email cá nhân"
                                            v-model="form.lecturer_other_email"
                                            name="lecturer_other_email"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'lecturer_other_email'
                                                )
                                            }"
                                        />
                                        <div
                                            class="text-danger mb-3"
                                            v-if="
                                                form.errors.has(
                                                    'lecturer_other_email'
                                                )
                                            "
                                            v-html="
                                                form.errors.get(
                                                    'lecturer_other_email'
                                                )
                                            "
                                        ></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Địa chỉ
                                    <span class="text-danger">
                                        (*)
                                    </span>
                                </label>
                                <textarea
                                    class="form-control non-resize"
                                    rows="3"
                                    placeholder="Địa chỉ thường trú"
                                    v-model="form.lecturer_address"
                                    name="lecturer_address"
                                    :class="{
                                        'is-invalid': form.errors.has(
                                            'lecturer_address'
                                        )
                                    }"
                                ></textarea>
                                <div
                                    class="text-danger mb-3"
                                    v-if="form.errors.has('lecturer_address')"
                                    v-html="form.errors.get('lecturer_address')"
                                ></div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button
                                :disabled="form.busy"
                                type="submit"
                                class="btn btn-success btn-block mt-1"
                            >
                                Lưu
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            lecturer_id: this.$facultyId,
            lecturer_fullname: "",
            form: new Form({
                lecturer_info_id: "",
                lecturer_id_ref: "",
                lecturer_birthday: "",
                lecturer_gender: "",
                lecturer_ethnic: "",
                lecturer_religion: "",
                lecturer_phone: "",
                lecturer_address: "",
                lecturer_country: "",
                lecturer_identify_card: "",
                lecturer_birth_place: "",
                lecturer_other_email: "",
                lecturer_avatar: ""
            }),
            lecturer_avatar: ""
        };
    },
    mounted() {
        this.fetchDeanFaculty();
    },
    methods: {
        fetchDeanFaculty(page_url) {
            page_url = `../../api/admin/user-gv/giang-vien/bcnk/${this.lecturer_id}`;
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.lecturer_fullname = res.data[0].lecturer_fullname;
                })
                .catch(err => console.log(err));
        },
        onAvatarChange(e) {
            const file = e.target.files[0];
            this.lecturer_avatar = URL.createObjectURL(file);
        },
        store() {
            this.form.busy = true;
            this.form.lecturer_avatar = document.getElementById(
                "lecturer_avatar"
            ).files[0];
            this.form.lecturer_id_ref = this.lecturer_id;
            this.form
                .post(
                    `../../api/admin/user-gv/giang-vien/tao-thong-tin-ca-nhan-bcnk`
                )
                .then(res => {
                    if (this.form.successful) {
                        this.$router.push({ name: "infolecturerindex" });
                    } else {
                        this.$snotify.error("Không thể thêm", "Lỗi");
                    }
                })
                .catch(err => console.log(err));
        }
    }
};
</script>

<style lang="css" scoped>
.non-resize {
    resize: none;
}
</style>
