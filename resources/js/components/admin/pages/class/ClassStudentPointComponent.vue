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
                <li class="breadcrumb-item">
                    <router-link tag="a" :to="{ name: 'classstudentindex' }">
                        Danh sách lớp học
                    </router-link>
                </li>
                <li class="breadcrumb-item">
                    <router-link
                        tag="a"
                        :to="{
                            name: 'classstudentdetail',
                            params: { idClass: class_id }
                        }"
                    >
                        Danh sách sinh viên
                    </router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Chấm điểm rèn luyện
                </li>
            </ol>
            <!-- End breadcrumb -->
        </div>

        <router-link
            class="btn btn-primary btn-lg mb-3 btn-3d"
            tag="button"
            :to="{
                name: 'classstudentdetail',
                params: { idClass: class_id }
            }"
        >
            <li class="fa fa-arrow-left"></li>
            Quay lại
        </router-link>

        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-12">
                            <h2 class="card-title text-center mb-2">
                                <b>
                                    Chấm điểm rèn luyện
                                </b>
                            </h2>
                        </div>
                    </div>
                    <table class="table">
                        <thead class="blue-background text-white">
                            <tr>
                                <th class="text-center w-5">
                                    STT
                                </th>
                                <th class="text-center w-45">
                                    Nội dung ý kiến đánh giá
                                </th>
                                <th class="text-center w-10">
                                    Mức điểm
                                </th>
                                <th class="text-center w-10">
                                    Điểm SV
                                </th>
                                <th class="text-center w-10">
                                    Điểm GVCN
                                </th>
                                <th class="text-center w-10">
                                    Điểm Khoa
                                </th>
                                <th class="w-10 text-center">
                                    Điểm cuối
                                </th>
                            </tr>
                        </thead>
                    </table>
                    <div class="panel-group" role="tablist">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" @click="showOne()">
                                <h4 class="panel-title">
                                    <a role="button" class="a-btn">
                                        <table class="table table-borderless table-heading">
                                            <tbody>
                                                <tr>
                                                    <td class="border-less text-center" width="3%">1</td>
                                                    <td class="border-less" width="50%">Đánh giá về ý thức tham gia học tập</td>
                                                    <td class="border-less">{{ score1 }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse" role="tabpanel" v-show="show1">
                                <table class="table table-bordered white-table">
                                    <tbody>
                                        <tr>
                                            <td colspan="7" class="td-title">
                                                1.1. Sinh viên có điểm trung bình học kỳ: ({{ deanfaculty.item_one.one_parent.header }} đ)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Từ 3,60 đến 4,00 (từ 9.0 trở lên theo thang điểm 10)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_one.one_parent.score.one }}</td>
                                            <td class="text-center" width="10%">
                                                {{ student.item_one.one_parent.input.one }}
                                            </td>
                                            <td class="text-center" width="10%">
                                                {{ formteacher.item_one.one_parent.input.one }}
                                            </td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    v-model="deanfaculty.item_one.one_parent.input.one"
                                                    class="input-point"
                                                    type="text"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_one.one_parent.input.one }}</td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Từ 3,20 đến 3,59 (từ 7.5 đến 8.9 theo thang điểm 10)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_one.one_parent.score.two }}</td>
                                            <td class="text-center" width="10%">{{ student.item_one.one_parent.input.two }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_one.one_parent.input.two }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_one.one_parent.input.two"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_one.one_parent.input.two }}</td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Từ 2,50 đến 3,19 (từ 6.0 đến 7.4 theo thang điểm 10
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_one.one_parent.score.three }}</td>
                                            <td class="text-center" width="10%">{{ student.item_one.one_parent.input.three }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_one.one_parent.input.three }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_one.one_parent.input.three"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_one.one_parent.input.three }}</td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Từ 2,00 đến 2,49 (từ 3.5 đến 5.9 theo thang điểm 10)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_one.one_parent.score.four }}</td>
                                            <td class="text-center" width="10%">{{ student.item_one.one_parent.input.four }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_one.one_parent.input.four }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_one.one_parent.input.four"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_one.one_parent.input.four }}</td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Dưới 2,00 (dưới 3.5 theo thang điểm 10)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_one.one_parent.score.five }}</td>
                                            <td class="text-center" width="10%">{{ student.item_one.one_parent.input.five }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_one.one_parent.input.five }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_one.one_parent.input.five"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_one.one_parent.input.five }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="td-title">
                                                1.2. Sinh viên có ý thức học tập: ({{ deanfaculty.item_one.two_parent.header }} đ)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Đi học chuyên cần, đúng giờ
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_one.two_parent.score.one }}</td>
                                            <td class="text-center" width="10%">{{ student.item_one.two_parent.input.one }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_one.two_parent.input.one }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_one.two_parent.input.one"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_one.two_parent.input.one }}</td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Có thái độ học tập, tích cực, đóng góp xây dựng bài trong giờ học
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_one.two_parent.score.two }}</td>
                                            <td class="text-center" width="10%">{{ student.item_one.two_parent.input.two }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_one.two_parent.input.two }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_one.two_parent.input.two"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_one.two_parent.input.two }}</td>
                                        </tr>
                                        <tr>
                                            <td width="7%" colspan="2" class="td-title">
                                                1.3. Sinh viên là thành viên CLB hoặc tham gia sinh hoạt thường xuyên vào CLB học thuật từ
                                                cấp Khoa trở lên. ({{ deanfaculty.item_one.three_parent.header }} đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_one.three_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_one.three_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_one.three_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_one.three_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_one.three_parent.input }}</td>
                                        </tr>
                                        <tr>
                                            <td width="7%" colspan="2" class="td-title">
                                                1.4. Sinh viên có tham dự ít nhất 01 chương trình tọa đàm, hội thảo về học thuật, kỹ năng
                                                mềm do các đơn vị trực thuộc Trường hoặc các đơn vị phối hợp với Trường tổ chức. ({{
                                                    deanfaculty.item_one.four_parent.header
                                                }}
                                                đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_one.four_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_one.four_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_one.four_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_one.four_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_one.four_parent.input }}</td>
                                        </tr>
                                        <tr>
                                            <td width="7%" colspan="2" class="td-title">
                                                1.5. Sinh viên có tham gia dự thi cuộc thi về học thuật từ cấp Khoa trở lên. ({{
                                                    deanfaculty.item_one.five_parent.header
                                                }}
                                                đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_one.five_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_one.five_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_one.five_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_one.five_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_one.five_parent.input }}</td>
                                        </tr>
                                        <tr>
                                            <td width="7%" colspan="2" class="td-title">
                                                1.6. Sinh viên có tham gia đề tài nghiên cứu khoa học từ cấp Khoa trở lên. ({{
                                                    deanfaculty.item_one.six_parent.header
                                                }}
                                                đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_one.six_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_one.six_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_one.six_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_one.six_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_one.six_parent.input }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" @click="showTwo()">
                                <h4 class="panel-title">
                                    <a role="button" class="a-btn">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td class="border-less text-center" width="3%">2</td>
                                                    <td class="border-less" width="50%">
                                                        Đánh giá về ý thức chấp hành nội quy, quy chế, quy định trong Nhà trường của sinh
                                                        viên
                                                    </td>
                                                    <td class="border-less">{{ score2 }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse" role="tabpanel" v-show="show2">
                                <table class="table table-bordered white-table">
                                    <tbody>
                                        <tr>
                                            <td width="49%" colspan="2" class="td-title">
                                                2.1. Sinh viên tuân thủ quy chế thi của Nhà trường. ({{
                                                    deanfaculty.item_two.one_parent.header
                                                }}
                                                đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_two.one_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_two.one_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_two.one_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_two.one_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_two.one_parent.input }}</td>
                                        </tr>
                                        <tr>
                                            <td width="49%" colspan="2" class="td-title">
                                                2.2. Hoàn thành học phí đúng thời hạn theo quy định của Nhà Trường. ({{
                                                    deanfaculty.item_two.two_parent.header
                                                }}
                                                đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_two.two_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_two.two_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_two.two_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_two.two_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_two.two_parent.input }}</td>
                                        </tr>
                                        <tr>
                                            <td width="49%" colspan="2" class="td-title">
                                                2.3. Trang phục chỉnh tề và đeo thẻ sinh viên khi đến Trường đúng quy định theo yêu cầu của
                                                Khoa, của Nhà trường. ({{ deanfaculty.item_two.three_parent.header }} đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_two.three_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_two.three_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_two.three_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_two.three_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_two.three_parent.input }}</td>
                                        </tr>
                                        <tr>
                                            <td width="49%" colspan="2" class="td-title">
                                                2.4. Sinh viên tự giác và nghiêm chỉnh chấp hành các quy định của Trường về nếp sống văn
                                                minh như không nói tục chửi thề, không tham gia và tổ chức đánh bài, không sử dụng và tàng
                                                trữ ma túy,… Sinh viên có ý thức bảo quản và sử dụng tài sản chung, thiết bị học tập; giữ
                                                gìn vệ sinh trường học, bỏ rác đúng nơi quy định; tiết kiệm điện nước và các quy định, quy
                                                chế khác của Nhà trường. ({{ deanfaculty.item_two.four_parent.header }}
                                                đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_two.four_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_two.four_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_two.four_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_two.four_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_two.four_parent.input }}</td>
                                        </tr>
                                        <tr>
                                            <td width="49%" colspan="2" class="td-title">
                                                2.5. Sinh viên thực hiện cung cấp hoặc cập nhật thông tin với Khoa về địa chỉ tạm trú, địa
                                                chỉ thường trú, thông tin liên lạc (số điện thoại, email,..), điều kiện sinh hoạt, khó khăn
                                                vướng mắc,… ({{ deanfaculty.item_two.five_parent.header }} đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_two.five_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_two.five_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_two.five_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_two.five_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_two.five_parent.input }}</td>
                                        </tr>
                                        <tr>
                                            <td width="49%" colspan="2" class="td-title">
                                                2.6. Sinh viên tham gia đầy đủ các buổi sinh hoạt trong “Tuần sinh hoạt công dân” định kỳ
                                                đầu năm học của Khoa, Trường. ({{ deanfaculty.item_two.six_parent.header }} đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_two.six_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_two.six_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_two.six_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_two.six_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_two.six_parent.input }}</td>
                                        </tr>
                                        <tr>
                                            <td width="49%" colspan="2" class="td-title">
                                                2.7. Chỉ áp dụng đối với sinh viên năm 01, sinh viên tham gia khám sức khỏe định kỳ đầu năm
                                                học của Khoa, Trường. ({{ deanfaculty.item_two.seven_parent.header }} đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_two.seven_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_two.seven_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_two.seven_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_two.seven_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_two.seven_parent.input }}</td>
                                        </tr>
                                        <tr>
                                            <td width="49%" colspan="2" class="td-title">
                                                2.8. Sinh viên tham gia đội hỗ trợ công tác của các đơn vị trực thuộc Nhà trường về ý thức
                                                chấp hành nội quy, quy chế, quy định Nhà trường. ({{
                                                    deanfaculty.item_two.eight_parent.header
                                                }}
                                                đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_two.eight_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_two.eight_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_two.eight_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_two.eight_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_two.eight_parent.input }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" @click="showThree()">
                                <h4 class="panel-title">
                                    <a role="button" class="a-btn">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td class="border-less text-center" width="3%">3</td>
                                                    <td class="border-less" width="50%">
                                                        Đánh giá về ý thức tham gia các hoạt động chính trị, xã hội, văn hóa, văn nghệ, thể
                                                        thao, phòng chống tội phạm và các tệ nạn xã hội
                                                    </td>
                                                    <td class="border-less">{{ score3 }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse" role="tabpanel" v-show="show3">
                                <table class="table table-bordered white-table">
                                    <tbody>
                                        <tr>
                                            <td colspan="7" class="td-title">
                                                3.1. Sinh viên tham gia đầy đủ các buổi sinh hoạt lớp, chi Hội / chi Đoàn ({{
                                                    deanfaculty.item_three.one_parent.header
                                                }}
                                                đ)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Sinh viên tham gia đầy đủ các buổi sinh hoạt lớp, chi Hội
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_three.one_parent.score.one }}</td>
                                            <td class="text-center" width="10%">{{ student.item_three.one_parent.input.one }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_three.one_parent.input.one }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_three.one_parent.input.one"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_three.one_parent.input.one }}</td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Sinh viên tham gia đầy đủ các buổi sinh hoạt chi Đoàn
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_three.one_parent.score.two }}</td>
                                            <td class="text-center" width="10%">{{ student.item_three.one_parent.input.two }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_three.one_parent.input.two }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_three.one_parent.input.two"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_three.one_parent.input.two }}</td>
                                        </tr>
                                        <tr>
                                            <td width="7%" colspan="2" class="td-title">
                                                3.2. Sinh viên có ý thức tuyên truyền, phòng chống và lên án các hành động tiêu cực, các tội
                                                phạm và các tệ nạn xã hội. ({{ deanfaculty.item_three.two_parent.header }} đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_three.two_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_three.two_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_three.two_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_three.two_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_three.two_parent.input }}</td>
                                        </tr>
                                        <tr>
                                            <td width="7%" colspan="2" class="td-title">
                                                3.3. Sinh viên tham gia ít nhất 02 hoạt động công ích, tình nguyện, công tác xã hội do các
                                                đơn vị trực thuộc nhà Trường tổ chức. ({{ deanfaculty.item_three.three_parent.header }} đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_three.three_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_three.three_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_three.three_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_three.three_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_three.three_parent.input }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="td-title">
                                                3.4. Sinh viên có tham gia ít nhất 01 hoạt động văn hóa, văn nghệ, thể thao cấp Khoa trở
                                                lên: ({{ deanfaculty.item_three.four_parent.header }}
                                                đ)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Sinh viên tham gia dự thi từ cấp Thành trở lên
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_three.four_parent.score.one }}</td>
                                            <td class="text-center" width="10%">{{ student.item_three.four_parent.input.one }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_three.four_parent.input.one }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_three.four_parent.input.one"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_three.four_parent.input.one }}</td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Sinh viên tham gia tổ chức, hỗ trợ, dự thi từ cấp Khoa trở lên
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_three.four_parent.score.two }}</td>
                                            <td class="text-center" width="10%">{{ student.item_three.four_parent.input.two }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_three.four_parent.input.two }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_three.four_parent.input.two"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_three.four_parent.input.two }}</td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Sinh viên tham gia cổ vũ từ cấp Khoa
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_three.four_parent.score.three }}</td>
                                            <td class="text-center" width="10%">{{ student.item_three.four_parent.input.three }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_three.four_parent.input.three }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_three.four_parent.input.three"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_three.four_parent.input.three }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="td-title">
                                                3.5. Sinh viên tham gia sinh hoạt thường xuyên ít nhất 01 CLB – Đội – Nhóm về hoạt động tình
                                                nguyện, cộng đồng, công tác xã hội; văn hóa; văn nghệ; thể thao từ cấp Khoa trở lên: ({{
                                                    deanfaculty.item_three.five_parent.header
                                                }}
                                                đ)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Sinh viên là thành viên ban chủ nhiệm
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_three.five_parent.score.one }}</td>
                                            <td class="text-center" width="10%">{{ student.item_three.five_parent.input.one }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_three.five_parent.input.one }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_three.five_parent.input.one"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_three.five_parent.input.one }}</td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Sinh viên là thành viên tham gia sinh hoạt thường xuyên
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_three.five_parent.score.two }}</td>
                                            <td class="text-center" width="10%">{{ student.item_three.five_parent.input.two }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_three.five_parent.input.two }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_three.five_parent.input.two"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_three.five_parent.input.two }}</td>
                                        </tr>
                                        <tr>
                                            <td width="7%" colspan="2" class="td-title">
                                                3.6. Sinh viên tham gia ít nhất 01 hoạt động phòng chống các hiện tượng tiêu cực; PCCC; cứu
                                                hộ cứu nạn; phòng chống tội phạm và các tệ nạn xã hội do Nhà trường tổ chức hoặc phối hợp tổ
                                                chức. ({{ deanfaculty.item_three.six_parent.header }}
                                                đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_three.six_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_three.six_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_three.six_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_three.six_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_three.six_parent.input }}</td>
                                        </tr>
                                        <tr>
                                            <td width="7%" colspan="2" class="td-title">
                                                3.7. Sinh viên có tham gia dự thi các cuộc thi về chính trị, xã hội, các môn khoa học Mác –
                                                Lênin, Tư tưởng Hồ Chí Minh từ cấp Khoa trở lên. ({{
                                                    deanfaculty.item_three.seven_parent.header
                                                }}
                                                đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_three.seven_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_three.seven_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_three.seven_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_three.seven_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_three.seven_parent.input }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="td-title">
                                                3.8. Sinh viên được khen thưởng trong các hoạt động về chính trị, xã hội, văn hóa, văn nghệ,
                                                thể thao, phòng chống tội phạm và các tệ nạn xã hội từ cấp trường trở lên: ({{
                                                    deanfaculty.item_three.eight_parent.header
                                                }}
                                                đ)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Cấp thành
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_three.eight_parent.score.one }}</td>
                                            <td class="text-center" width="10%">{{ student.item_three.eight_parent.input.one }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_three.eight_parent.input.one }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_three.eight_parent.input.one"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_three.eight_parent.input.one }}</td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Cấp trường
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_three.eight_parent.score.two }}</td>
                                            <td class="text-center" width="10%">{{ student.item_three.eight_parent.input.two }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_three.eight_parent.input.two }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_three.eight_parent.input.two"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_three.eight_parent.input.two }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" @click="showFour()">
                                <h4 class="panel-title">
                                    <a role="button" class="a-btn">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td class="border-less text-center" width="3%">4</td>
                                                    <td class="border-less" width="50%">
                                                        Đánh giá về ý thức công dân trong quan hệ cộng đồng
                                                    </td>
                                                    <td class="border-less">{{ score4 }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse" role="tabpanel" v-show="show4">
                                <table class="table table-bordered white-table">
                                    <tbody>
                                        <tr>
                                            <td width="49%" colspan="2" class="td-title">
                                                4.1. Sinh viên có ý thức chấp hành các chủ trương của Đảng, chính sách và pháp luật của Nhà
                                                nước trong cộng đồng. ({{ deanfaculty.item_four.one_parent.header }} đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_four.one_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_four.one_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_four.one_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_four.one_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_four.one_parent.input }}</td>
                                        </tr>
                                        <tr>
                                            <td width="49%" colspan="2" class="td-title">
                                                4.2. Sinh viên có thái độ hòa động, nhiệt tình giúp đỡ người dân địa phương; thầy cô, nhân
                                                viên Nhà trường và bạn bè xung quanh. ({{ deanfaculty.item_four.two_parent.header }} đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_four.two_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_four.two_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_four.two_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_four.two_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_four.two_parent.input }}</td>
                                        </tr>
                                        <tr>
                                            <td width="49%" colspan="2" class="td-title">
                                                4.3. Sinh viên tuân thủ quy định về việc tham gia bảo hiểm y tế. ({{
                                                    deanfaculty.item_four.three_parent.header
                                                }}
                                                đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_four.three_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_four.three_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_four.three_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_four.three_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_four.three_parent.input }}</td>
                                        </tr>
                                        <tr>
                                            <td width="49%" colspan="2" class="td-title">
                                                4.4. Sinh viên tham gia đóng góp hỗ trợ các trường hợp có hoàn cảnh khó khăn như đóng góp
                                                quỹ Gia đình Văn Lang, tặng sách đồng môn, hỗ trợ đồng bào bị ảnh hưởng thiên tai,… ({{
                                                    deanfaculty.item_four.four_parent.header
                                                }}
                                                đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_four.four_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_four.four_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_four.four_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_four.four_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_four.four_parent.input }}</td>
                                        </tr>
                                        <tr>
                                            <td width="49%" colspan="2" class="td-title">
                                                4.5. Sinh viên tham gia hỗ trợ các đơn vị trực thuộc Nhà trường tổ chức các hoạt động, sự
                                                kiện. ({{ deanfaculty.item_four.five_parent.header }}
                                                đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_four.five_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_four.five_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_four.five_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_four.five_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_four.five_parent.input }}</td>
                                        </tr>
                                        <tr>
                                            <td width="49%" colspan="2" class="td-title">
                                                4.6. Sinh viên tham gia hiến máu tình nguyện tại Trường. ({{
                                                    deanfaculty.item_four.six_parent.header
                                                }}
                                                đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_four.six_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_four.six_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_four.six_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_four.six_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_four.six_parent.input }}</td>
                                        </tr>
                                        <tr>
                                            <td width="49%" colspan="2" class="td-title">
                                                4.7. Sinh viên tham gia các chiến dịch tình nguyện như chiến dịch mùa hè xanh, chiến dịch
                                                xuân tình nguyện,… ({{ deanfaculty.item_four.seven_parent.header }} đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_four.seven_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_four.seven_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_four.seven_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_four.seven_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_four.seven_parent.input }}</td>
                                        </tr>
                                        <tr>
                                            <td width="49%" colspan="2" class="td-title">
                                                4.8. Sinh viên có tham gia các hoạt động vì cộng đồng tại địa phương. ({{
                                                    deanfaculty.item_four.eight_parent.header
                                                }}
                                                đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_four.eight_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_four.eight_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_four.eight_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_four.eight_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_four.eight_parent.input }}</td>
                                        </tr>
                                        <tr>
                                            <td width="49%" colspan="2" class="td-title">
                                                4.9. Sinh viên được khen thưởng đã có hoạt động vì cộng đồng tại địa phương. ({{
                                                    deanfaculty.item_four.nine_parent.header
                                                }}
                                                đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_four.nine_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_four.nine_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_four.nine_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_four.nine_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_four.nine_parent.input }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" @click="showFive()">
                                <h4 class="panel-title">
                                    <a role="button" class="a-btn">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td class="border-less text-center" width="3%">5</td>
                                                    <td class="border-less" width="50%">
                                                        Đánh giá về ý thức và kết quả tham gia công tác cán bộ lớp, các Đoàn thể, tổ chức
                                                        trong nhà trường hoặc đạt thành tích đặc biệt
                                                    </td>
                                                    <td class="border-less">{{ score5 }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse" role="tabpanel" v-show="show5">
                                <table class="table table-bordered white-table">
                                    <tbody>
                                        <tr>
                                            <td width="7%" colspan="2" class="td-title">
                                                5.1. Đối với sinh viên không phải là thành viên Ban cán sự lớp, Cán bộ chi Đoàn – chi Hội
                                                hoàn thành nhiệm vụ và tập thể công nhận. ({{ deanfaculty.item_five.one_parent.header }} đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_five.one_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_five.one_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_five.one_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_five.one_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_five.one_parent.input }}</td>
                                        </tr>
                                        <tr>
                                            <td width="7%" colspan="2" class="td-title">
                                                5.2. Đối với sinh viên là thành viên Ban cán sự lớp, Cán bộ chi Đoàn – chi Hội hoàn thành
                                                nhiệm vụ và tập thể lớp công nhận. ({{ deanfaculty.item_five.two_parent.header }} đ)
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_five.two_parent.score }}</td>
                                            <td class="text-center" width="10%">{{ student.item_five.two_parent.input }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_five.two_parent.input }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_five.two_parent.input"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_five.two_parent.input }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="td-title">
                                                5.3. Xếp loại Tập thể lớp được Ban Chủ nhiệm Khoa đánh giá: ({{
                                                    deanfaculty.item_five.three_parent.header
                                                }}
                                                đ)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Tập thể lớp Xuất sắc
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_five.three_parent.score.one }}</td>
                                            <td class="text-center" width="10%">{{ student.item_five.three_parent.input.one }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_five.three_parent.input.one }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_five.three_parent.input.one"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_five.three_parent.input.one }}</td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Tập thể lớp Khá
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_five.three_parent.score.two }}</td>
                                            <td class="text-center" width="10%">{{ student.item_five.three_parent.input.two }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_five.three_parent.input.two }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_five.three_parent.input.two"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_five.three_parent.input.two }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="td-title">
                                                5.4. Xếp loại Chi Đoàn/Chi Hội được Đoàn/Hội cấp trên công nhận: ({{
                                                    deanfaculty.item_five.four_parent.header
                                                }}
                                                đ)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Chi Đoàn/Chi Hội Mạnh
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_five.four_parent.score.one }}</td>
                                            <td class="text-center" width="10%">{{ student.item_five.four_parent.input.one }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_five.four_parent.input.one }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_five.four_parent.input.one"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_five.four_parent.input.one }}</td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Chi Đoàn/Chi Hội Khá
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_five.four_parent.score.two }}</td>
                                            <td class="text-center" width="10%">{{ student.item_five.four_parent.input.two }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_five.four_parent.input.two }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_five.four_parent.input.two"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_five.four_parent.input.two }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="td-title">
                                                5.5. Sinh viên là cán bộ Đoàn Hội được Đoàn – Hội trường công nhận: ({{
                                                    deanfaculty.item_five.five_parent.header
                                                }}
                                                đ)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Hoàn thành tốt nhiệm vụ
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_five.five_parent.score.one }}</td>
                                            <td class="text-center" width="10%">{{ student.item_five.five_parent.input.one }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_five.five_parent.input.one }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_five.five_parent.input.one"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_five.five_parent.input.one }}</td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Hoàn thành nhiệm vụ
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_five.five_parent.score.two }}</td>
                                            <td class="text-center" width="10%">{{ student.item_five.five_parent.input.two }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_five.five_parent.input.two }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_five.five_parent.input.two"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_five.five_parent.input.two }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="td-title">
                                                5.6. Sinh viên có giải thưởng trong học tập và rèn luyện: ({{
                                                    deanfaculty.item_five.six_parent.header
                                                }}
                                                đ)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Cấp thành
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_five.six_parent.score.one }}</td>
                                            <td class="text-center" width="10%">{{ student.item_five.six_parent.input.one }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_five.six_parent.input.one }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_five.six_parent.input.one"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_five.six_parent.input.one }}</td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Cấp trường
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_five.six_parent.score.two }}</td>
                                            <td class="text-center" width="10%">{{ student.item_five.six_parent.input.two }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_five.six_parent.input.two }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_five.six_parent.input.two"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_five.six_parent.input.two }}</td>
                                        </tr>
                                        <tr>
                                            <td width="3%"></td>
                                            <td width="46%">
                                                - Cấp khoa
                                            </td>
                                            <td class="text-center" width="10%">{{ deanfaculty.item_five.six_parent.score.three }}</td>
                                            <td class="text-center" width="10%">{{ student.item_five.six_parent.input.three }}</td>
                                            <td class="text-center" width="10%">{{ formteacher.item_five.six_parent.input.three }}</td>
                                            <td class="text-center" width="10%">
                                                <input
                                                    :class="{ 'disable-input': registers.length == 0 }"
                                                    :disabled="registers.length == 0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    class="input-point"
                                                    type="text"
                                                    v-model="deanfaculty.item_five.six_parent.input.three"
                                                />
                                            </td>
                                            <td class="text-center">{{ deanfaculty.item_five.six_parent.input.three }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="text-center td-title" width="59%" colspan="3">
                                    Tổng điểm đánh giá
                                </td>
                                <td class="text-center" width="10%">
                                    {{ student.sum }}
                                </td>
                                <td class="text-center" width="10%">
                                    {{ formteacher.sum }}
                                </td>
                                <td class="text-center" width="10%">
                                    {{ deanfaculty.sum }}
                                </td>
                                <td class="text-center">
                                    {{ deanfaculty.sum }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center w-60 td-title" colspan="3">
                                    Xếp loại
                                </td>
                                <td class="text-center w-10">
                                    <div v-if="student.sum < 35">Kém</div>
                                    <div v-else-if="student.sum < 50">Yếu</div>
                                    <div v-else-if="student.sum < 65">Trung bình</div>
                                    <div v-else-if="student.sum < 80">Khá</div>
                                    <div v-else-if="student.sum < 90">Tốt</div>
                                    <div v-else-if="student.sum <= 100">Xuất sắc</div>
                                </td>
                                <td class="text-center w-10">
                                    <div v-if="formteacher.sum < 35">Kém</div>
                                    <div v-else-if="formteacher.sum < 50">Yếu</div>
                                    <div v-else-if="formteacher.sum < 65">Trung bình</div>
                                    <div v-else-if="formteacher.sum < 80">Khá</div>
                                    <div v-else-if="formteacher.sum < 90">Tốt</div>
                                    <div v-else-if="formteacher.sum <= 100">Xuất sắc</div>
                                </td>
                                <td class="text-center w-10">
                                    <div v-if="deanfaculty.sum < 35">Kém</div>
                                    <div v-else-if="deanfaculty.sum < 50">Yếu</div>
                                    <div v-else-if="deanfaculty.sum < 65">Trung bình</div>
                                    <div v-else-if="deanfaculty.sum < 80">Khá</div>
                                    <div v-else-if="deanfaculty.sum < 90">Tốt</div>
                                    <div v-else-if="deanfaculty.sum <= 100">Xuất sắc</div>
                                </td>
                                <td class="w-10 text-center">
                                    <div v-if="deanfaculty.sum < 35">Kém</div>
                                    <div v-else-if="deanfaculty.sum < 50">Yếu</div>
                                    <div v-else-if="deanfaculty.sum < 65">Trung bình</div>
                                    <div v-else-if="deanfaculty.sum < 80">Khá</div>
                                    <div v-else-if="deanfaculty.sum < 90">Tốt</div>
                                    <div v-else-if="deanfaculty.sum <= 100">Xuất sắc</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <button class="btn btn-primary btn-styling" :disabled="registers.length == 0" @click="store()">
                                {{ registers.length == 0 ? 'Chưa tới thời gian đánh giá' : 'Đánh giá' }}
                            </button>
                        </div>
                    </div>
                    <!-- table-responsive -->
                </div>
            </div>
            <!-- col end -->
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            class_id: this.$route.params.idClass,
            student_id: this.$route.params.idStudent,
            semester: '',
            type: '',
            registers: [],
            show1: false,
            show2: false,
            show3: false,
            show4: false,
            show5: false,
            score1: 20,
            score2: 25,
            score3: 20,
            score4: 25,
            score5: 10,
            deanfaculty: {
                item_one: {
                    one_parent: {
                        header: 10,
                        score: {
                            one: 10,
                            two: 9,
                            three: 8,
                            four: 7,
                            five: 0
                        },
                        input: {
                            one: 0,
                            two: 0,
                            three: 0,
                            four: 0,
                            five: 0
                        }
                    },
                    two_parent: {
                        header: 6,
                        score: {
                            one: 3,
                            two: 3
                        },
                        input: {
                            one: 0,
                            two: 0
                        }
                    },
                    three_parent: {
                        header: 2,
                        score: 2,
                        input: 0
                    },
                    four_parent: {
                        header: 2,
                        score: 2,
                        input: 0
                    },
                    five_parent: {
                        header: 3,
                        score: 3,
                        input: 0
                    },
                    six_parent: {
                        header: 5,
                        score: 5,
                        input: 0
                    }
                },
                item_two: {
                    one_parent: {
                        header: 5,
                        score: 5,
                        input: 0
                    },
                    two_parent: {
                        header: 8,
                        score: 8,
                        input: 0
                    },
                    three_parent: {
                        header: 3,
                        score: 3,
                        input: 0
                    },
                    four_parent: {
                        header: 2,
                        score: 2,
                        input: 0
                    },
                    five_parent: {
                        header: 2,
                        score: 2,
                        input: 0
                    },
                    six_parent: {
                        header: 5,
                        score: 5,
                        input: 0
                    },
                    seven_parent: {
                        header: 2,
                        score: 2,
                        input: 0
                    },
                    eight_parent: {
                        header: 4,
                        score: 4,
                        input: 0
                    }
                },
                item_three: {
                    one_parent: {
                        header: 6,
                        score: {
                            one: 3,
                            two: 3
                        },
                        input: {
                            one: 0,
                            two: 0
                        }
                    },
                    two_parent: {
                        header: 2,
                        score: 2,
                        input: 0
                    },
                    three_parent: {
                        header: 3,
                        score: 3,
                        input: 0
                    },
                    four_parent: {
                        header: 7,
                        score: {
                            one: 7,
                            two: 5,
                            three: 2
                        },
                        input: {
                            one: 0,
                            two: 0,
                            three: 0
                        }
                    },
                    five_parent: {
                        header: 3,
                        score: {
                            one: 3,
                            two: 2
                        },
                        input: {
                            one: 0,
                            two: 0
                        }
                    },
                    six_parent: {
                        header: 2,
                        score: 2,
                        input: 0
                    },
                    seven_parent: {
                        header: 2,
                        score: 2,
                        input: 0
                    },
                    eight_parent: {
                        header: 10,
                        score: {
                            one: 10,
                            two: 5
                        },
                        input: {
                            one: 0,
                            two: 0
                        }
                    }
                },
                item_four: {
                    one_parent: {
                        header: 6,
                        score: 6,
                        input: 0
                    },
                    two_parent: {
                        header: 5,
                        score: 5,
                        input: 0
                    },
                    three_parent: {
                        header: 7,
                        score: 7,
                        input: 0
                    },
                    four_parent: {
                        header: 3,
                        score: 3,
                        input: 0
                    },
                    five_parent: {
                        header: 5,
                        score: 5,
                        input: 0
                    },
                    six_parent: {
                        header: 5,
                        score: 5,
                        input: 0
                    },
                    seven_parent: {
                        header: 5,
                        score: 5,
                        input: 0
                    },
                    eight_parent: {
                        header: 3,
                        score: 3,
                        input: 0
                    },
                    nine_parent: {
                        header: 5,
                        score: 5,
                        input: 0
                    }
                },
                item_five: {
                    one_parent: {
                        header: 3,
                        score: 3,
                        input: 0
                    },
                    two_parent: {
                        header: 5,
                        score: 5,
                        input: 0
                    },
                    three_parent: {
                        header: 2,
                        score: {
                            one: 2,
                            two: 1
                        },
                        input: {
                            one: 0,
                            two: 0
                        }
                    },
                    four_parent: {
                        header: 2,
                        score: {
                            one: 2,
                            two: 1
                        },
                        input: {
                            one: 0,
                            two: 0
                        }
                    },
                    five_parent: {
                        header: 5,
                        score: {
                            one: 5,
                            two: 3
                        },
                        input: {
                            one: 0,
                            two: 0
                        }
                    },
                    six_parent: {
                        header: 10,
                        score: {
                            one: 10,
                            two: 5,
                            three: 3
                        },
                        input: {
                            one: 0,
                            two: 0,
                            three: 0
                        }
                    }
                },
                sum: 0
            },
            student: {
                item_one: {
                    one_parent: {
                        input: {
                            one: 0,
                            two: 0,
                            three: 0,
                            four: 0,
                            five: 0
                        }
                    },
                    two_parent: {
                        input: {
                            one: 0,
                            two: 0
                        }
                    },
                    three_parent: {
                        input: 0
                    },
                    four_parent: {
                        input: 0
                    },
                    five_parent: {
                        input: 0
                    },
                    six_parent: {
                        input: 0
                    }
                },
                item_two: {
                    one_parent: {
                        input: 0
                    },
                    two_parent: {
                        input: 0
                    },
                    three_parent: {
                        input: 0
                    },
                    four_parent: {
                        input: 0
                    },
                    five_parent: {
                        input: 0
                    },
                    six_parent: {
                        input: 0
                    },
                    seven_parent: {
                        input: 0
                    },
                    eight_parent: {
                        input: 0
                    }
                },
                item_three: {
                    one_parent: {
                        input: {
                            one: 0,
                            two: 0
                        }
                    },
                    two_parent: {
                        input: 0
                    },
                    three_parent: {
                        input: 0
                    },
                    four_parent: {
                        input: {
                            one: 0,
                            two: 0,
                            three: 0
                        }
                    },
                    five_parent: {
                        input: {
                            one: 0,
                            two: 0
                        }
                    },
                    six_parent: {
                        input: 0
                    },
                    seven_parent: {
                        input: 0
                    },
                    eight_parent: {
                        input: {
                            one: 0,
                            two: 0
                        }
                    }
                },
                item_four: {
                    one_parent: {
                        input: 0
                    },
                    two_parent: {
                        input: 0
                    },
                    three_parent: {
                        input: 0
                    },
                    four_parent: {
                        input: 0
                    },
                    five_parent: {
                        input: 0
                    },
                    six_parent: {
                        input: 0
                    },
                    seven_parent: {
                        input: 0
                    },
                    eight_parent: {
                        input: 0
                    },
                    nine_parent: {
                        input: 0
                    }
                },
                item_five: {
                    one_parent: {
                        input: 0
                    },
                    two_parent: {
                        input: 0
                    },
                    three_parent: {
                        input: {
                            one: 0,
                            two: 0
                        }
                    },
                    four_parent: {
                        input: {
                            one: 0,
                            two: 0
                        }
                    },
                    five_parent: {
                        input: {
                            one: 0,
                            two: 0
                        }
                    },
                    six_parent: {
                        input: {
                            one: 0,
                            two: 0,
                            three: 0
                        }
                    }
                },
                sum: 0
            },
            formteacher: {
                item_one: {
                    one_parent: {
                        input: {
                            one: 0,
                            two: 0,
                            three: 0,
                            four: 0,
                            five: 0
                        }
                    },
                    two_parent: {
                        input: {
                            one: 0,
                            two: 0
                        }
                    },
                    three_parent: {
                        input: 0
                    },
                    four_parent: {
                        input: 0
                    },
                    five_parent: {
                        input: 0
                    },
                    six_parent: {
                        input: 0
                    }
                },
                item_two: {
                    one_parent: {
                        input: 0
                    },
                    two_parent: {
                        input: 0
                    },
                    three_parent: {
                        input: 0
                    },
                    four_parent: {
                        input: 0
                    },
                    five_parent: {
                        input: 0
                    },
                    six_parent: {
                        input: 0
                    },
                    seven_parent: {
                        input: 0
                    },
                    eight_parent: {
                        input: 0
                    }
                },
                item_three: {
                    one_parent: {
                        input: {
                            one: 0,
                            two: 0
                        }
                    },
                    two_parent: {
                        input: 0
                    },
                    three_parent: {
                        input: 0
                    },
                    four_parent: {
                        input: {
                            one: 0,
                            two: 0,
                            three: 0
                        }
                    },
                    five_parent: {
                        input: {
                            one: 0,
                            two: 0
                        }
                    },
                    six_parent: {
                        input: 0
                    },
                    seven_parent: {
                        input: 0
                    },
                    eight_parent: {
                        input: {
                            one: 0,
                            two: 0
                        }
                    }
                },
                item_four: {
                    one_parent: {
                        input: 0
                    },
                    two_parent: {
                        input: 0
                    },
                    three_parent: {
                        input: 0
                    },
                    four_parent: {
                        input: 0
                    },
                    five_parent: {
                        input: 0
                    },
                    six_parent: {
                        input: 0
                    },
                    seven_parent: {
                        input: 0
                    },
                    eight_parent: {
                        input: 0
                    },
                    nine_parent: {
                        input: 0
                    }
                },
                item_five: {
                    one_parent: {
                        input: 0
                    },
                    two_parent: {
                        input: 0
                    },
                    three_parent: {
                        input: {
                            one: 0,
                            two: 0
                        }
                    },
                    four_parent: {
                        input: {
                            one: 0,
                            two: 0
                        }
                    },
                    five_parent: {
                        input: {
                            one: 0,
                            two: 0
                        }
                    },
                    six_parent: {
                        input: {
                            one: 0,
                            two: 0,
                            three: 0
                        }
                    }
                },
                sum: 0
            }
        }
    },
    mounted() {
        this.fetchCalendarRegister()
    },
    watch: {
        $route(to, from) {
            this.class_id = to.params.idClass
            this.student_id = to.params.idStudent
        },
        semester(value) {
            if (value != '') {
                this.fetchPointStudent()
                this.fetchPointFormTeacher()
                this.fetchPointDeanFaculty()
            }
        }
    },
    methods: {
        showOne() {
            this.show1 = !this.show1
            this.show2 = false
            this.show3 = false
            this.show4 = false
            this.show5 = false
        },
        showTwo() {
            this.show2 = !this.show2
            this.show1 = false
            this.show3 = false
            this.show4 = false
            this.show5 = false
        },
        showThree() {
            this.show3 = !this.show3
            this.show1 = false
            this.show2 = false
            this.show4 = false
            this.show5 = false
        },
        showFour() {
            this.show4 = !this.show4
            this.show1 = false
            this.show3 = false
            this.show2 = false
            this.show5 = false
        },
        showFive() {
            this.show5 = !this.show5
            this.show1 = false
            this.show3 = false
            this.show4 = false
            this.show2 = false
        },
        fetchCalendarRegister(page_url) {
            page_url = `../../api/student/train-point/danh-gia-diem-ren-luyen/thoi-gian-danh-gia-khoa/${this.student_id}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    const today = new Date()
                    let register = res.data.filter(el => {
                        const start = new Date(el.start)
                        const end = new Date(el.end)
                        if (today >= start && today <= end) {
                            return el
                        }
                    })
                    this.registers = register
                    this.semester = register[0].location
                    this.type = register[0].recurrenceRule
                })
                .catch(err => console.log(err))
        },
        fetchPointStudent(page_url) {
            page_url = `../../api/student/train-point/danh-gia-diem-ren-luyen/tu-danh-gia/${this.student_id}/${this.semester}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    if (res.data.length > 0) {
                        let split_one = res.data[0].train_point_one
                        let split_two = res.data[0].train_point_two
                        let split_three = res.data[0].train_point_three
                        let split_four = res.data[0].train_point_four
                        let split_five = res.data[0].train_point_five

                        const train_point_one = split_one.split(',')
                        const train_point_two = split_two.split(',')
                        const train_point_three = split_three.split(',')
                        const train_point_four = split_four.split(',')
                        const train_point_five = split_five.split(',')

                        this.student.item_one.one_parent.input.one = train_point_one[0]
                        this.student.item_one.one_parent.input.two = train_point_one[1]
                        this.student.item_one.one_parent.input.three = train_point_one[2]
                        this.student.item_one.one_parent.input.four = train_point_one[3]
                        this.student.item_one.one_parent.input.five = train_point_one[4]
                        this.student.item_one.two_parent.input.one = train_point_one[5]
                        this.student.item_one.two_parent.input.two = train_point_one[6]
                        this.student.item_one.three_parent.input = train_point_one[7]
                        this.student.item_one.four_parent.input = train_point_one[8]
                        this.student.item_one.five_parent.input = train_point_one[9]
                        this.student.item_one.six_parent.input = train_point_one[10]

                        this.student.item_two.one_parent.input = train_point_two[0]
                        this.student.item_two.two_parent.input = train_point_two[1]
                        this.student.item_two.three_parent.input = train_point_two[2]
                        this.student.item_two.four_parent.input = train_point_two[3]
                        this.student.item_two.five_parent.input = train_point_two[4]
                        this.student.item_two.six_parent.input = train_point_two[5]
                        this.student.item_two.seven_parent.input = train_point_two[6]
                        this.student.item_two.eight_parent.input = train_point_two[7]

                        this.student.item_three.one_parent.input.one = train_point_three[0]
                        this.student.item_three.one_parent.input.one = train_point_three[1]
                        this.student.item_three.two_parent.input = train_point_three[2]
                        this.student.item_three.three_parent.input = train_point_three[3]
                        this.student.item_three.four_parent.input.one = train_point_three[4]
                        this.student.item_three.four_parent.input.two = train_point_three[5]
                        this.student.item_three.four_parent.input.three = train_point_three[6]
                        this.student.item_three.five_parent.input.one = train_point_three[7]
                        this.student.item_three.five_parent.input.two = train_point_three[8]
                        this.student.item_three.six_parent.input = train_point_three[9]
                        this.student.item_three.seven_parent.input = train_point_three[10]
                        this.student.item_three.eight_parent.input.one = train_point_three[11]
                        this.student.item_three.eight_parent.input.two = train_point_three[12]

                        this.student.item_four.one_parent.input = train_point_four[0]
                        this.student.item_four.two_parent.input = train_point_four[1]
                        this.student.item_four.three_parent.input = train_point_four[2]
                        this.student.item_four.four_parent.input = train_point_four[3]
                        this.student.item_four.five_parent.input = train_point_four[4]
                        this.student.item_four.six_parent.input = train_point_four[5]
                        this.student.item_four.seven_parent.input = train_point_four[6]
                        this.student.item_four.eight_parent.input = train_point_four[7]
                        this.student.item_four.nine_parent.input = train_point_four[8]

                        this.student.item_five.one_parent.input = train_point_five[0]
                        this.student.item_five.two_parent.input = train_point_five[1]
                        this.student.item_five.three_parent.input.one = train_point_five[2]
                        this.student.item_five.three_parent.input.two = train_point_five[3]
                        this.student.item_five.four_parent.input.one = train_point_five[4]
                        this.student.item_five.four_parent.input.two = train_point_five[5]
                        this.student.item_five.five_parent.input.one = train_point_five[6]
                        this.student.item_five.five_parent.input.two = train_point_five[7]
                        this.student.item_five.six_parent.input.one = train_point_five[8]
                        this.student.item_five.six_parent.input.two = train_point_five[9]
                        this.student.item_five.six_parent.input.three = train_point_five[10]

                        this.student.sum = res.data[0].train_point_sum
                    } else {
                        this.student.item_one.one_parent.input.one = 0
                        this.student.item_one.one_parent.input.two = 0
                        this.student.item_one.one_parent.input.three = 0
                        this.student.item_one.one_parent.input.four = 0
                        this.student.item_one.one_parent.input.five = 0
                        this.student.item_one.two_parent.input.one = 0
                        this.student.item_one.two_parent.input.two = 0
                        this.student.item_one.three_parent.input = 0
                        this.student.item_one.four_parent.input = 0
                        this.student.item_one.five_parent.input = 0
                        this.student.item_one.six_parent.input = 0

                        this.student.item_two.one_parent.input = 0
                        this.student.item_two.two_parent.input = 0
                        this.student.item_two.three_parent.input = 0
                        this.student.item_two.four_parent.input = 0
                        this.student.item_two.five_parent.input = 0
                        this.student.item_two.six_parent.input = 0
                        this.student.item_two.seven_parent.input = 0
                        this.student.item_two.eight_parent.input = 0

                        this.student.item_three.one_parent.input.one = 0
                        this.student.item_three.one_parent.input.one = 0
                        this.student.item_three.two_parent.input = 0
                        this.student.item_three.three_parent.input = 0
                        this.student.item_three.four_parent.input.one = 0
                        this.student.item_three.four_parent.input.two = 0
                        this.student.item_three.four_parent.input.three = 0
                        this.student.item_three.five_parent.input.one = 0
                        this.student.item_three.five_parent.input.two = 0
                        this.student.item_three.six_parent.input = 0
                        this.student.item_three.seven_parent.input = 0
                        this.student.item_three.eight_parent.input.one = 0
                        this.student.item_three.eight_parent.input.two = 0

                        this.student.item_four.one_parent.input = 0
                        this.student.item_four.two_parent.input = 0
                        this.student.item_four.three_parent.input = 0
                        this.student.item_four.four_parent.input = 0
                        this.student.item_four.five_parent.input = 0
                        this.student.item_four.six_parent.input = 0
                        this.student.item_four.seven_parent.input = 0
                        this.student.item_four.eight_parent.input = 0
                        this.student.item_four.nine_parent.input = 0

                        this.student.item_five.one_parent.input = 0
                        this.student.item_five.two_parent.input = 0
                        this.student.item_five.three_parent.input.one = 0
                        this.student.item_five.three_parent.input.two = 0
                        this.student.item_five.four_parent.input.one = 0
                        this.student.item_five.four_parent.input.two = 0
                        this.student.item_five.five_parent.input.one = 0
                        this.student.item_five.five_parent.input.two = 0
                        this.student.item_five.six_parent.input.one = 0
                        this.student.item_five.six_parent.input.two = 0
                        this.student.item_five.six_parent.input.three = 0

                        this.student.sum = 0
                    }
                })
                .catch(err => console.log(err))
        },
        fetchPointFormTeacher(page_url) {
            page_url = `../../api/student/train-point/danh-gia-diem-ren-luyen/chu-nhiem-danh-gia/${this.student_id}/${this.semester}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    if (res.data.length > 0) {
                        let split_one = res.data[0].train_point_one
                        let split_two = res.data[0].train_point_two
                        let split_three = res.data[0].train_point_three
                        let split_four = res.data[0].train_point_four
                        let split_five = res.data[0].train_point_five

                        const train_point_one = split_one.split(',')
                        const train_point_two = split_two.split(',')
                        const train_point_three = split_three.split(',')
                        const train_point_four = split_four.split(',')
                        const train_point_five = split_five.split(',')

                        this.formteacher.item_one.one_parent.input.one = train_point_one[0]
                        this.formteacher.item_one.one_parent.input.two = train_point_one[1]
                        this.formteacher.item_one.one_parent.input.three = train_point_one[2]
                        this.formteacher.item_one.one_parent.input.four = train_point_one[3]
                        this.formteacher.item_one.one_parent.input.five = train_point_one[4]
                        this.formteacher.item_one.two_parent.input.one = train_point_one[5]
                        this.formteacher.item_one.two_parent.input.two = train_point_one[6]
                        this.formteacher.item_one.three_parent.input = train_point_one[7]
                        this.formteacher.item_one.four_parent.input = train_point_one[8]
                        this.formteacher.item_one.five_parent.input = train_point_one[9]
                        this.formteacher.item_one.six_parent.input = train_point_one[10]

                        this.formteacher.item_two.one_parent.input = train_point_two[0]
                        this.formteacher.item_two.two_parent.input = train_point_two[1]
                        this.formteacher.item_two.three_parent.input = train_point_two[2]
                        this.formteacher.item_two.four_parent.input = train_point_two[3]
                        this.formteacher.item_two.five_parent.input = train_point_two[4]
                        this.formteacher.item_two.six_parent.input = train_point_two[5]
                        this.formteacher.item_two.seven_parent.input = train_point_two[6]
                        this.formteacher.item_two.eight_parent.input = train_point_two[7]

                        this.formteacher.item_three.one_parent.input.one = train_point_three[0]
                        this.formteacher.item_three.one_parent.input.one = train_point_three[1]
                        this.formteacher.item_three.two_parent.input = train_point_three[2]
                        this.formteacher.item_three.three_parent.input = train_point_three[3]
                        this.formteacher.item_three.four_parent.input.one = train_point_three[4]
                        this.formteacher.item_three.four_parent.input.two = train_point_three[5]
                        this.formteacher.item_three.four_parent.input.three = train_point_three[6]
                        this.formteacher.item_three.five_parent.input.one = train_point_three[7]
                        this.formteacher.item_three.five_parent.input.two = train_point_three[8]
                        this.formteacher.item_three.six_parent.input = train_point_three[9]
                        this.formteacher.item_three.seven_parent.input = train_point_three[10]
                        this.formteacher.item_three.eight_parent.input.one = train_point_three[11]
                        this.formteacher.item_three.eight_parent.input.two = train_point_three[12]

                        this.formteacher.item_four.one_parent.input = train_point_four[0]
                        this.formteacher.item_four.two_parent.input = train_point_four[1]
                        this.formteacher.item_four.three_parent.input = train_point_four[2]
                        this.formteacher.item_four.four_parent.input = train_point_four[3]
                        this.formteacher.item_four.five_parent.input = train_point_four[4]
                        this.formteacher.item_four.six_parent.input = train_point_four[5]
                        this.formteacher.item_four.seven_parent.input = train_point_four[6]
                        this.formteacher.item_four.eight_parent.input = train_point_four[7]
                        this.formteacher.item_four.nine_parent.input = train_point_four[8]

                        this.formteacher.item_five.one_parent.input = train_point_five[0]
                        this.formteacher.item_five.two_parent.input = train_point_five[1]
                        this.formteacher.item_five.three_parent.input.one = train_point_five[2]
                        this.formteacher.item_five.three_parent.input.two = train_point_five[3]
                        this.formteacher.item_five.four_parent.input.one = train_point_five[4]
                        this.formteacher.item_five.four_parent.input.two = train_point_five[5]
                        this.formteacher.item_five.five_parent.input.one = train_point_five[6]
                        this.formteacher.item_five.five_parent.input.two = train_point_five[7]
                        this.formteacher.item_five.six_parent.input.one = train_point_five[8]
                        this.formteacher.item_five.six_parent.input.two = train_point_five[9]
                        this.formteacher.item_five.six_parent.input.three = train_point_five[10]

                        this.formteacher.sum = res.data[0].train_point_sum
                    } else {
                        this.formteacher.item_one.one_parent.input.one = 0
                        this.formteacher.item_one.one_parent.input.two = 0
                        this.formteacher.item_one.one_parent.input.three = 0
                        this.formteacher.item_one.one_parent.input.four = 0
                        this.formteacher.item_one.one_parent.input.five = 0
                        this.formteacher.item_one.two_parent.input.one = 0
                        this.formteacher.item_one.two_parent.input.two = 0
                        this.formteacher.item_one.three_parent.input = 0
                        this.formteacher.item_one.four_parent.input = 0
                        this.formteacher.item_one.five_parent.input = 0
                        this.formteacher.item_one.six_parent.input = 0

                        this.formteacher.item_two.one_parent.input = 0
                        this.formteacher.item_two.two_parent.input = 0
                        this.formteacher.item_two.three_parent.input = 0
                        this.formteacher.item_two.four_parent.input = 0
                        this.formteacher.item_two.five_parent.input = 0
                        this.formteacher.item_two.six_parent.input = 0
                        this.formteacher.item_two.seven_parent.input = 0
                        this.formteacher.item_two.eight_parent.input = 0

                        this.formteacher.item_three.one_parent.input.one = 0
                        this.formteacher.item_three.one_parent.input.one = 0
                        this.formteacher.item_three.two_parent.input = 0
                        this.formteacher.item_three.three_parent.input = 0
                        this.formteacher.item_three.four_parent.input.one = 0
                        this.formteacher.item_three.four_parent.input.two = 0
                        this.formteacher.item_three.four_parent.input.three = 0
                        this.formteacher.item_three.five_parent.input.one = 0
                        this.formteacher.item_three.five_parent.input.two = 0
                        this.formteacher.item_three.six_parent.input = 0
                        this.formteacher.item_three.seven_parent.input = 0
                        this.formteacher.item_three.eight_parent.input.one = 0
                        this.formteacher.item_three.eight_parent.input.two = 0

                        this.formteacher.item_four.one_parent.input = 0
                        this.formteacher.item_four.two_parent.input = 0
                        this.formteacher.item_four.three_parent.input = 0
                        this.formteacher.item_four.four_parent.input = 0
                        this.formteacher.item_four.five_parent.input = 0
                        this.formteacher.item_four.six_parent.input = 0
                        this.formteacher.item_four.seven_parent.input = 0
                        this.formteacher.item_four.eight_parent.input = 0
                        this.formteacher.item_four.nine_parent.input = 0

                        this.formteacher.item_five.one_parent.input = 0
                        this.formteacher.item_five.two_parent.input = 0
                        this.formteacher.item_five.three_parent.input.one = 0
                        this.formteacher.item_five.three_parent.input.two = 0
                        this.formteacher.item_five.four_parent.input.one = 0
                        this.formteacher.item_five.four_parent.input.two = 0
                        this.formteacher.item_five.five_parent.input.one = 0
                        this.formteacher.item_five.five_parent.input.two = 0
                        this.formteacher.item_five.six_parent.input.one = 0
                        this.formteacher.item_five.six_parent.input.two = 0
                        this.formteacher.item_five.six_parent.input.three = 0

                        this.formteacher.sum = 0
                    }
                })
                .catch(err => console.log(err))
        },
        fetchPointDeanFaculty(page_url) {
            page_url = `../../api/student/train-point/danh-gia-diem-ren-luyen/bcn-khoa-danh-gia/${this.student_id}/${this.semester}`
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    if (res.data.length > 0) {
                        let split_one = res.data[0].train_point_one
                        let split_two = res.data[0].train_point_two
                        let split_three = res.data[0].train_point_three
                        let split_four = res.data[0].train_point_four
                        let split_five = res.data[0].train_point_five

                        const train_point_one = split_one.split(',')
                        const train_point_two = split_two.split(',')
                        const train_point_three = split_three.split(',')
                        const train_point_four = split_four.split(',')
                        const train_point_five = split_five.split(',')

                        this.deanfaculty.item_one.one_parent.input.one = train_point_one[0]
                        this.deanfaculty.item_one.one_parent.input.two = train_point_one[1]
                        this.deanfaculty.item_one.one_parent.input.three = train_point_one[2]
                        this.deanfaculty.item_one.one_parent.input.four = train_point_one[3]
                        this.deanfaculty.item_one.one_parent.input.five = train_point_one[4]
                        this.deanfaculty.item_one.two_parent.input.one = train_point_one[5]
                        this.deanfaculty.item_one.two_parent.input.two = train_point_one[6]
                        this.deanfaculty.item_one.three_parent.input = train_point_one[7]
                        this.deanfaculty.item_one.four_parent.input = train_point_one[8]
                        this.deanfaculty.item_one.five_parent.input = train_point_one[9]
                        this.deanfaculty.item_one.six_parent.input = train_point_one[10]

                        this.deanfaculty.item_two.one_parent.input = train_point_two[0]
                        this.deanfaculty.item_two.two_parent.input = train_point_two[1]
                        this.deanfaculty.item_two.three_parent.input = train_point_two[2]
                        this.deanfaculty.item_two.four_parent.input = train_point_two[3]
                        this.deanfaculty.item_two.five_parent.input = train_point_two[4]
                        this.deanfaculty.item_two.six_parent.input = train_point_two[5]
                        this.deanfaculty.item_two.seven_parent.input = train_point_two[6]
                        this.deanfaculty.item_two.eight_parent.input = train_point_two[7]

                        this.deanfaculty.item_three.one_parent.input.one = train_point_three[0]
                        this.deanfaculty.item_three.one_parent.input.one = train_point_three[1]
                        this.deanfaculty.item_three.two_parent.input = train_point_three[2]
                        this.deanfaculty.item_three.three_parent.input = train_point_three[3]
                        this.deanfaculty.item_three.four_parent.input.one = train_point_three[4]
                        this.deanfaculty.item_three.four_parent.input.two = train_point_three[5]
                        this.deanfaculty.item_three.four_parent.input.three = train_point_three[6]
                        this.deanfaculty.item_three.five_parent.input.one = train_point_three[7]
                        this.deanfaculty.item_three.five_parent.input.two = train_point_three[8]
                        this.deanfaculty.item_three.six_parent.input = train_point_three[9]
                        this.deanfaculty.item_three.seven_parent.input = train_point_three[10]
                        this.deanfaculty.item_three.eight_parent.input.one = train_point_three[11]
                        this.deanfaculty.item_three.eight_parent.input.two = train_point_three[12]

                        this.deanfaculty.item_four.one_parent.input = train_point_four[0]
                        this.deanfaculty.item_four.two_parent.input = train_point_four[1]
                        this.deanfaculty.item_four.three_parent.input = train_point_four[2]
                        this.deanfaculty.item_four.four_parent.input = train_point_four[3]
                        this.deanfaculty.item_four.five_parent.input = train_point_four[4]
                        this.deanfaculty.item_four.six_parent.input = train_point_four[5]
                        this.deanfaculty.item_four.seven_parent.input = train_point_four[6]
                        this.deanfaculty.item_four.eight_parent.input = train_point_four[7]
                        this.deanfaculty.item_four.nine_parent.input = train_point_four[8]

                        this.deanfaculty.item_five.one_parent.input = train_point_five[0]
                        this.deanfaculty.item_five.two_parent.input = train_point_five[1]
                        this.deanfaculty.item_five.three_parent.input.one = train_point_five[2]
                        this.deanfaculty.item_five.three_parent.input.two = train_point_five[3]
                        this.deanfaculty.item_five.four_parent.input.one = train_point_five[4]
                        this.deanfaculty.item_five.four_parent.input.two = train_point_five[5]
                        this.deanfaculty.item_five.five_parent.input.one = train_point_five[6]
                        this.deanfaculty.item_five.five_parent.input.two = train_point_five[7]
                        this.deanfaculty.item_five.six_parent.input.one = train_point_five[8]
                        this.deanfaculty.item_five.six_parent.input.two = train_point_five[9]
                        this.deanfaculty.item_five.six_parent.input.three = train_point_five[10]

                        this.deanfaculty.sum = res.data[0].train_point_sum
                    } else {
                        this.deanfaculty.item_one.one_parent.input.one = 0
                        this.deanfaculty.item_one.one_parent.input.two = 0
                        this.deanfaculty.item_one.one_parent.input.three = 0
                        this.deanfaculty.item_one.one_parent.input.four = 0
                        this.deanfaculty.item_one.one_parent.input.five = 0
                        this.deanfaculty.item_one.two_parent.input.one = 0
                        this.deanfaculty.item_one.two_parent.input.two = 0
                        this.deanfaculty.item_one.three_parent.input = 0
                        this.deanfaculty.item_one.four_parent.input = 0
                        this.deanfaculty.item_one.five_parent.input = 0
                        this.deanfaculty.item_one.six_parent.input = 0

                        this.deanfaculty.item_two.one_parent.input = 0
                        this.deanfaculty.item_two.two_parent.input = 0
                        this.deanfaculty.item_two.three_parent.input = 0
                        this.deanfaculty.item_two.four_parent.input = 0
                        this.deanfaculty.item_two.five_parent.input = 0
                        this.deanfaculty.item_two.six_parent.input = 0
                        this.deanfaculty.item_two.seven_parent.input = 0
                        this.deanfaculty.item_two.eight_parent.input = 0

                        this.deanfaculty.item_three.one_parent.input.one = 0
                        this.deanfaculty.item_three.one_parent.input.one = 0
                        this.deanfaculty.item_three.two_parent.input = 0
                        this.deanfaculty.item_three.three_parent.input = 0
                        this.deanfaculty.item_three.four_parent.input.one = 0
                        this.deanfaculty.item_three.four_parent.input.two = 0
                        this.deanfaculty.item_three.four_parent.input.three = 0
                        this.deanfaculty.item_three.five_parent.input.one = 0
                        this.deanfaculty.item_three.five_parent.input.two = 0
                        this.deanfaculty.item_three.six_parent.input = 0
                        this.deanfaculty.item_three.seven_parent.input = 0
                        this.deanfaculty.item_three.eight_parent.input.one = 0
                        this.deanfaculty.item_three.eight_parent.input.two = 0

                        this.deanfaculty.item_four.one_parent.input = 0
                        this.deanfaculty.item_four.two_parent.input = 0
                        this.deanfaculty.item_four.three_parent.input = 0
                        this.deanfaculty.item_four.four_parent.input = 0
                        this.deanfaculty.item_four.five_parent.input = 0
                        this.deanfaculty.item_four.six_parent.input = 0
                        this.deanfaculty.item_four.seven_parent.input = 0
                        this.deanfaculty.item_four.eight_parent.input = 0
                        this.deanfaculty.item_four.nine_parent.input = 0

                        this.deanfaculty.item_five.one_parent.input = 0
                        this.deanfaculty.item_five.two_parent.input = 0
                        this.deanfaculty.item_five.three_parent.input.one = 0
                        this.deanfaculty.item_five.three_parent.input.two = 0
                        this.deanfaculty.item_five.four_parent.input.one = 0
                        this.deanfaculty.item_five.four_parent.input.two = 0
                        this.deanfaculty.item_five.five_parent.input.one = 0
                        this.deanfaculty.item_five.five_parent.input.two = 0
                        this.deanfaculty.item_five.six_parent.input.one = 0
                        this.deanfaculty.item_five.six_parent.input.two = 0
                        this.deanfaculty.item_five.six_parent.input.three = 0

                        this.deanfaculty.sum = 0
                    }
                })
                .catch(err => console.log(err))
        },
        store() {
            // item one
            let sum_itemOne_oneParent =
                Number(this.deanfaculty.item_one.one_parent.input.one) +
                Number(this.deanfaculty.item_one.one_parent.input.two) +
                Number(this.deanfaculty.item_one.one_parent.input.three) +
                Number(this.deanfaculty.item_one.one_parent.input.four) +
                Number(this.deanfaculty.item_one.one_parent.input.five)
            if (sum_itemOne_oneParent > this.deanfaculty.item_one.one_parent.header) {
                sum_itemOne_oneParent = this.deanfaculty.item_one.one_parent.header
            }

            let sum_itemOne_twoParent =
                Number(this.deanfaculty.item_one.two_parent.input.one) + Number(this.deanfaculty.item_one.two_parent.input.two)
            if (sum_itemOne_twoParent > this.deanfaculty.item_one.two_parent.header) {
                sum_itemOne_twoParent = this.deanfaculty.item_one.two_parent.header
            }

            let sum_itemOne =
                sum_itemOne_oneParent +
                sum_itemOne_twoParent +
                Number(this.deanfaculty.item_one.three_parent.input) +
                Number(this.deanfaculty.item_one.four_parent.input) +
                Number(this.deanfaculty.item_one.five_parent.input) +
                Number(this.deanfaculty.item_one.six_parent.input)
            if (sum_itemOne > this.score1) {
                sum_itemOne = this.score1
            }

            // item two
            let sum_itemTwo =
                Number(this.deanfaculty.item_two.one_parent.input) +
                Number(this.deanfaculty.item_two.two_parent.input) +
                Number(this.deanfaculty.item_two.three_parent.input) +
                Number(this.deanfaculty.item_two.four_parent.input) +
                Number(this.deanfaculty.item_two.five_parent.input) +
                Number(this.deanfaculty.item_two.six_parent.input) +
                Number(this.deanfaculty.item_two.seven_parent.input) +
                Number(this.deanfaculty.item_two.eight_parent.input)
            if (sum_itemTwo > this.score2) {
                sum_itemTwo = this.score2
            }

            // item three
            let sum_itemThree_oneParent =
                Number(this.deanfaculty.item_three.one_parent.input.one) + Number(this.deanfaculty.item_three.one_parent.input.one)
            if (sum_itemThree_oneParent > this.deanfaculty.item_three.one_parent.header) {
                sum_itemThree_oneParent = this.deanfaculty.item_three.one_parent.header
            }

            let sum_itemThree_fourParent =
                Number(this.deanfaculty.item_three.four_parent.input.one) +
                Number(this.deanfaculty.item_three.four_parent.input.two) +
                Number(this.deanfaculty.item_three.four_parent.input.three)
            if (sum_itemThree_fourParent > this.deanfaculty.item_three.four_parent.header) {
                sum_itemThree_fourParent = this.deanfaculty.item_three.four_parent.header
            }

            let sum_itemThree_fiveParent =
                Number(this.deanfaculty.item_three.five_parent.input.one) + Number(this.deanfaculty.item_three.five_parent.input.two)
            if (sum_itemThree_fiveParent > this.deanfaculty.item_three.five_parent.header) {
                sum_itemThree_fiveParent = this.deanfaculty.item_three.five_parent.header
            }

            let sum_itemThree_eightParent =
                Number(this.deanfaculty.item_three.eight_parent.input.one) + Number(this.deanfaculty.item_three.eight_parent.input.two)
            if (sum_itemThree_eightParent > this.deanfaculty.item_three.eight_parent.header) {
                sum_itemThree_eightParent = this.deanfaculty.item_three.eight_parent.header
            }

            let sum_itemThree =
                sum_itemThree_oneParent +
                Number(this.deanfaculty.item_three.two_parent.input) +
                Number(this.deanfaculty.item_three.three_parent.input) +
                sum_itemThree_fourParent +
                sum_itemThree_fiveParent +
                Number(this.deanfaculty.item_three.six_parent.input) +
                Number(this.deanfaculty.item_three.seven_parent.input) +
                sum_itemThree_eightParent
            if (sum_itemThree > this.score3) {
                sum_itemThree = this.score3
            }

            // item four
            let sum_itemFour =
                Number(this.deanfaculty.item_four.one_parent.input) +
                Number(this.deanfaculty.item_four.two_parent.input) +
                Number(this.deanfaculty.item_four.three_parent.input) +
                Number(this.deanfaculty.item_four.four_parent.input) +
                Number(this.deanfaculty.item_four.five_parent.input) +
                Number(this.deanfaculty.item_four.six_parent.input) +
                Number(this.deanfaculty.item_four.seven_parent.input) +
                Number(this.deanfaculty.item_four.eight_parent.input) +
                Number(this.deanfaculty.item_four.nine_parent.input)
            if (sum_itemFour > this.score4) {
                sum_itemFour = this.score4
            }

            // item five
            let sum_itemFive_threeParent =
                Number(this.deanfaculty.item_five.three_parent.input.one) + Number(this.deanfaculty.item_five.three_parent.input.two)
            if (sum_itemFive_threeParent > this.deanfaculty.item_five.three_parent.header) {
                sum_itemFive_threeParent = this.deanfaculty.item_five.three_parent.header
            }

            let sum_itemFive_fourParent =
                Number(this.deanfaculty.item_five.four_parent.input.one) + Number(this.deanfaculty.item_five.four_parent.input.two)
            if (sum_itemFive_fourParent > this.deanfaculty.item_five.four_parent.header) {
                sum_itemFive_fourParent = this.deanfaculty.item_five.four_parent.header
            }

            let sum_itemFive_fiveParent =
                Number(this.deanfaculty.item_five.five_parent.input.one) + Number(this.deanfaculty.item_five.five_parent.input.two)
            if (sum_itemFive_fiveParent > this.deanfaculty.item_five.five_parent.header) {
                sum_itemFive_fiveParent = this.deanfaculty.item_five.five_parent.header
            }

            let sum_itemFive_sixParent =
                Number(this.deanfaculty.item_five.six_parent.input.one) +
                Number(this.deanfaculty.item_five.six_parent.input.two) +
                Number(this.deanfaculty.item_five.six_parent.input.three)
            if (sum_itemFive_sixParent > this.deanfaculty.item_five.six_parent.header) {
                sum_itemFive_sixParent = this.deanfaculty.item_five.six_parent.header
            }

            let sum_itemFive =
                Number(this.deanfaculty.item_five.one_parent.input) +
                Number(this.deanfaculty.item_five.two_parent.input) +
                sum_itemFive_threeParent +
                sum_itemFive_fourParent +
                sum_itemFive_fiveParent +
                sum_itemFive_sixParent
            if (sum_itemFive > this.score5) {
                sum_itemFive = this.score5
            }

            this.deanfaculty.sum = sum_itemOne + sum_itemTwo + sum_itemThree + sum_itemFour + sum_itemFive

            let formData = new FormData()
            formData.append('student_id', this.student_id)
            formData.append('semester', this.semester)

            formData.append('itemOne_oneParent_inputOne', this.deanfaculty.item_one.one_parent.input.one)
            formData.append('itemOne_oneParent_inputTwo', this.deanfaculty.item_one.one_parent.input.two)
            formData.append('itemOne_oneParent_inputThree', this.deanfaculty.item_one.one_parent.input.three)
            formData.append('itemOne_oneParent_inputFour', this.deanfaculty.item_one.one_parent.input.four)
            formData.append('itemOne_oneParent_inputFive', this.deanfaculty.item_one.one_parent.input.five)
            formData.append('itemOne_twoParent_inputOne', this.deanfaculty.item_one.two_parent.input.one)
            formData.append('itemOne_twoParent_inputTwo', this.deanfaculty.item_one.two_parent.input.two)
            formData.append('itemOne_threeParent_inputOne', this.deanfaculty.item_one.three_parent.input)
            formData.append('itemOne_fourParent_inputOne', this.deanfaculty.item_one.four_parent.input)
            formData.append('itemOne_fiveParent_inputOne', this.deanfaculty.item_one.five_parent.input)
            formData.append('itemOne_sixParent_inputOne', this.deanfaculty.item_one.six_parent.input)

            formData.append('itemTwo_oneParent_inputOne', this.deanfaculty.item_two.one_parent.input)
            formData.append('itemTwo_twoParent_inputOne', this.deanfaculty.item_two.two_parent.input)
            formData.append('itemTwo_threeParent_inputOne', this.deanfaculty.item_two.three_parent.input)
            formData.append('itemTwo_fourParent_inputOne', this.deanfaculty.item_two.four_parent.input)
            formData.append('itemTwo_fiveParent_inputOne', this.deanfaculty.item_two.five_parent.input)
            formData.append('itemTwo_sixParent_inputOne', this.deanfaculty.item_two.six_parent.input)
            formData.append('itemTwo_sevenParent_inputOne', this.deanfaculty.item_two.seven_parent.input)
            formData.append('itemTwo_eightParent_inputOne', this.deanfaculty.item_two.eight_parent.input)

            formData.append('itemThree_oneParent_inputOne', this.deanfaculty.item_three.one_parent.input.one)
            formData.append('itemThree_oneParent_inputTwo', this.deanfaculty.item_three.one_parent.input.one)
            formData.append('itemThree_twoParent_inputOne', this.deanfaculty.item_three.two_parent.input)
            formData.append('itemThree_threeParent_inputOne', this.deanfaculty.item_three.three_parent.input)
            formData.append('itemThree_fourParent_inputOne', this.deanfaculty.item_three.four_parent.input.one)
            formData.append('itemThree_fourParent_inputTwo', this.deanfaculty.item_three.four_parent.input.two)
            formData.append('itemThree_fourParent_inputThree', this.deanfaculty.item_three.four_parent.input.three)
            formData.append('itemThree_fiveParent_inputOne', this.deanfaculty.item_three.five_parent.input.one)
            formData.append('itemThree_fiveParent_inputTwo', this.deanfaculty.item_three.five_parent.input.two)
            formData.append('itemThree_sixParent_inputOne', this.deanfaculty.item_three.six_parent.input)
            formData.append('itemThree_sevenParent_inputOne', this.deanfaculty.item_three.seven_parent.input)
            formData.append('itemThree_eightParent_inputOne', this.deanfaculty.item_three.eight_parent.input.one)
            formData.append('itemThree_eightParent_inputTwo', this.deanfaculty.item_three.eight_parent.input.two)

            formData.append('itemFour_oneParent_inputOne', this.deanfaculty.item_four.one_parent.input)
            formData.append('itemFour_twoParent_inputOne', this.deanfaculty.item_four.two_parent.input)
            formData.append('itemFour_threeParent_inputOne', this.deanfaculty.item_four.three_parent.input)
            formData.append('itemFour_fourParent_inputOne', this.deanfaculty.item_four.four_parent.input)
            formData.append('itemFour_fiveParent_inputOne', this.deanfaculty.item_four.five_parent.input)
            formData.append('itemFour_sixParent_inputOne', this.deanfaculty.item_four.six_parent.input)
            formData.append('itemFour_sevenParent_inputOne', this.deanfaculty.item_four.seven_parent.input)
            formData.append('itemFour_eightParent_inputOne', this.deanfaculty.item_four.eight_parent.input)
            formData.append('itemFour_nineParent_inputOne', this.deanfaculty.item_four.nine_parent.input)

            formData.append('itemFive_oneParent_inputOne', this.deanfaculty.item_five.one_parent.input)
            formData.append('itemFive_twoParent_inputOne', this.deanfaculty.item_five.two_parent.input)
            formData.append('itemFive_threeParent_inputOne', this.deanfaculty.item_five.three_parent.input.one)
            formData.append('itemFive_threeParent_inputTwo', this.deanfaculty.item_five.three_parent.input.two)
            formData.append('itemFive_fourParent_inputOne', this.deanfaculty.item_five.four_parent.input.one)
            formData.append('itemFive_fourParent_inputTwo', this.deanfaculty.item_five.four_parent.input.two)
            formData.append('itemFive_fiveParent_inputOne', this.deanfaculty.item_five.five_parent.input.one)
            formData.append('itemFive_fiveParent_inputTwo', this.deanfaculty.item_five.five_parent.input.two)
            formData.append('itemSix_sixParent_inputOne', this.deanfaculty.item_five.six_parent.input.one)
            formData.append('itemSix_sixParent_inputTwo', this.deanfaculty.item_five.six_parent.input.two)
            formData.append('itemSix_sixParent_inputThree', this.deanfaculty.item_five.six_parent.input.three)

            formData.append('sum_item', this.deanfaculty.sum)
            formData.append('type', this.type)

            axios
                .post(`../../api/student/train-point/danh-gia-diem-ren-luyen`, formData)
                .then(res => {
                    this.$snotify.success('Đánh giá thành công!')
                })
                .catch(err => {
                    this.$snotify.error(err.response.data.errors)
                })
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
    background-color: #fbd9d9 !important;
}
.panel-default {
    margin-top: -13px;
}
.a-btn {
    cursor: pointer;
}
.panel-heading:hover {
    background-color: bisque !important;
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
.btn-styling {
    border-bottom: 3px solid #6c757db0;
    border-right: 3px solid #6c757db0;
    width: 90%;
    margin-bottom: 20px;
}
</style>
