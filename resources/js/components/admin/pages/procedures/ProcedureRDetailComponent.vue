<template>
    <div>
        <div class="page-header">
            <ol class="breadcrumb">
                <!-- breadcrumb -->
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <router-link tag="a" :to="{ name: 'procedureindex' }">Danh sách thủ tục</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <router-link tag="a" :to="{ name: 'procedurerequire' }">Danh sách yêu cầu thủ tục</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Chi tiết yêu cầu</li>
            </ol>
            <!-- End breadcrumb -->
        </div>
        <div class="col-md-6">
            <router-link tag="button" class="btn btn-primary mb-3 btn-3d" :to="{ name: 'procedurerequire' }">
                <li class="fa fa-arrow-left"></li>
                Quay lại
            </router-link>
        </div>

        <div class="card">
            <div class="card-header styling">
                <h3 class="card-title">Chi tiết yêu cầu</h3>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-12">
                            <div
                                class="form-item mt-3"
                                v-for="(input, index) in procedures_input"
                                :key="'input_' + index"
                                v-show="procedures_input.length > 0"
                            >
                                <div class="form-input small active">
                                    <label for="profile-name">{{ input }}:</label>
                                    <input type="text" class="form-control" :value="valueInput(index)" disabled />
                                </div>
                            </div>

                            <div
                                class="form-item mt-3"
                                v-for="(area, index) in procedures_area"
                                :key="'area_' + index"
                                v-show="procedures_area.length > 0"
                            >
                                <div class="form-input small active">
                                    <label for="profile-name">{{ area }}:</label>
                                    <textarea class="form-control" rows="3" :value="valueArea(index)" disabled></textarea>
                                </div>
                            </div>

                            <div
                                class="form-item mt-3"
                                v-for="(select, index) in procedures_select"
                                :key="'select_' + index"
                                v-show="procedures_select.length > 0"
                            >
                                <div class="form-select">
                                    <label for="profile-name">{{ procedures_select_title(select) }}:</label>
                                    <input type="text" class="form-control" :value="valueSelect(index)" disabled />
                                </div>
                            </div>

                            <div
                                class="form-item mt-3"
                                v-for="(file, index) in procedures_file"
                                :key="'file_' + index"
                                v-show="procedures_file.length > 0"
                            >
                                <div class="form-input small active">
                                    <label for="profile-name">{{ file }}:</label>
                                    <a
                                        class="form-control"
                                        :href="`../public/attachments/requests/${valueFile(index)}`"
                                        v-text="valueFile(index)"
                                        @click.prevent="downloadItem(index)"
                                    ></a>
                                    <!-- <input type="text" class="form-control" :value="valueFile(index)" disabled /> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            procedure_require_id: this.$route.params.idRProcedure,
            details: [],
            procedures_input: [],
            procedures_area: [],
            procedures_select: [],
            procedures_file: [],

            procedures_require_input: [],
            procedures_require_area: [],
            procedures_require_select: [],
            procedures_require_file: []
        }
    },
    mounted() {
        this.fetchDetail()
    },
    watch: {
        $route(to, from) {
            this.procedure_require_id = to.params.idRProcedure
        }
    },
    methods: {
        fetchDetail(page_url) {
            let vm = this
            page_url = `../../api/admin/procedure-require/yeu-cau-thu-tuc/detail/${this.procedure_require_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    let input = res.data[0].procedure_input
                    let area = res.data[0].procedure_area
                    let select = res.data[0].procedure_select
                    let file = res.data[0].procedure_file

                    let requireInput = res.data[0].procedure_require_input
                    let requireArea = res.data[0].procedure_require_area
                    let requireSelect = res.data[0].procedure_require_select
                    let requireFile = res.data[0].procedure_require_file

                    this.procedures_input = input.split('; ')
                    this.procedures_require_input = requireInput.split('; ')

                    if (area == '' || area == null) {
                        this.procedures_area = []
                    } else {
                        this.procedures_area = area.split('; ')
                    }

                    if (requireArea == '' || requireArea == null) {
                        this.procedures_require_area = []
                    } else {
                        this.procedures_require_area = requireArea.split('; ')
                    }

                    if (select == '' || select == null) {
                        this.procedures_select = []
                    } else {
                        this.procedures_select = select.split('; ')
                    }

                    if (requireSelect == '' || requireSelect == null) {
                        this.procedures_require_select = []
                    } else {
                        this.procedures_require_select = requireSelect.split('; ')
                    }

                    if (file == '' || file == null) {
                        this.procedures_file = []
                    } else {
                        this.procedures_file = file.split('; ')
                    }

                    if (requireFile == '' || requireFile == null) {
                        this.procedures_require_file = []
                    } else {
                        this.procedures_require_file = requireFile.split('; ')
                    }

                    this.details = res.data
                })
                .catch(err => console.log(err))
        },
        procedures_select_title(select) {
            let titleSelect = select.split(': ')
            return titleSelect[0]
        },
        valueInput(index) {
            for (let i = 0; i < this.procedures_require_input.length; i++) {
                if (i == index) {
                    return this.procedures_require_input[i]
                }
            }
        },
        valueArea(index) {
            for (let i = 0; i < this.procedures_require_area.length; i++) {
                if (i == index) {
                    return this.procedures_require_area[i]
                }
            }
        },
        valueSelect(index) {
            for (let i = 0; i < this.procedures_require_select.length; i++) {
                if (i == index) {
                    return this.procedures_require_select[i]
                }
            }
        },
        valueFile(index) {
            for (let i = 0; i < this.procedures_require_file.length; i++) {
                if (i == index) {
                    return this.procedures_require_file[i]
                }
            }
        },
        downloadItem(index) {
            for (let i = 0; i < this.procedures_require_file.length; i++) {
                if (i == index) {
                    axios
                        .get(`../public/attachments/procedures/${this.procedures_require_file[i]}`, { responseType: 'blob' })
                        .then(response => {
                            const blob = new Blob([response.data], { type: 'application/pdf' })
                            const link = document.createElement('a')
                            link.href = URL.createObjectURL(blob)
                            link.download = this.procedures_require_file[i]
                            link.click()
                            URL.revokeObjectURL(link.href)
                        })
                        .catch(console.error)
                }
            }
        }
    }
}
</script>

<style scoped>
label,
input {
    font-size: 16px !important;
}
</style>
