<template>
    <div>
        <vue-snotify></vue-snotify>
        <div class="page-header">
            <ol class="breadcrumb">
                <!-- breadcrumb -->
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'dashboard' }">
                        Dashboard
                    </router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Lớp sinh viên
                </li>
            </ol>
            <!-- End breadcrumb -->
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-12">
                            <h3 class="card-title">
                                Các lớp học đang chủ nhiệm
                            </h3>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table
                            class="table card-table table-vcenter text-nowrap table-nowrap"
                        >
                            <thead class="blue-background text-white">
                                <tr>
                                    <th class="text-white text-center w-30">
                                        Tên lớp học
                                    </th>
                                    <th class="text-white text-center w-30">
                                        Khoa
                                    </th>
                                    <th class="text-white text-center w-30">
                                        Chuyên ngành
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="clas in classes"
                                    :key="clas.class_id"
                                >
                                    <td class="text-center td-table">
                                        <router-link
                                            tag="a"
                                            :to="{
                                                name: 'formteacherclassdetail',
                                                params: {
                                                    idFTClass: clas.class_id
                                                }
                                            }"
                                        >
                                            {{ clas.course_code }}
                                            -
                                            {{ clas.class_name }}
                                        </router-link>
                                    </td>
                                    <td class="td-table text-center">
                                        {{ clas.faculty_name }}
                                    </td>
                                    <td class="text-center td-table">
                                        {{ clas.major_name }}
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr v-show="!classes.length">
                                    <td colspan="9">
                                        <div class="alert alert-danger">
                                            Không tìm thấy kết quả phù hợp!
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
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
            classes: [],
            lecturer_id: this.$teacherId
        };
    },
    mounted() {
        this.fetchClasses();
    },
    methods: {
        fetchClasses(page_url) {
            let vm = this;
            page_url = `../../api/admin/class-sv/lop/class-formteacher/${this.lecturer_id}`;
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.classes = res.data;
                })
                .catch(err => console.log(err));
        }
    }
};
</script>

<style>
.td-styling {
    text-align: center;
}
.not-allowed {
    cursor: not-allowed;
}
.select-option {
    cursor: pointer;
}
.h3-strong {
    color: #1753fc;
}
.styling-modal-header-info {
    background-color: darkblue;
    color: white;
}
.styling-font-modal-header {
    font-size: 20px;
    font-weight: bold;
}
.styling-modal-header-update {
    background-color: darkblue;
    color: white;
}
.td-borderight {
    border-right: 2px solid black;
}
.td-borderbottom {
    border-bottom: 2px solid black;
}
.background-update {
    background-color: darkblue;
    border-color: darkblue;
}
.styling-strong {
    word-wrap: break-word;
    white-space: pre-line;
}
.btn-3d {
    border-bottom: 3px solid #6c757d;
    border-right: 3px solid #6c757d;
}
.detail-background {
    background-color: #2e384d;
}
.text-require {
    color: red;
    font-weight: bold;
}
</style>
