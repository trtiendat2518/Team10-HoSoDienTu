import Vue from 'vue';

//Dashboard
Vue.component('dashboard-component', require('./components/admin/pages/DashboardComponent.vue').default);

//Pagination
Vue.component('pagination', require('./components/pagination/PaginationComponent.vue').default);

//Information
Vue.component('update-info-component', require('./components/admin/pages/info/UpdateInfoComponent.vue').default);

//Users
Vue.component('lecturer-manage-component', require('./components/admin/pages/users/LecturerManageComponent.vue').default);
Vue.component('student-manage-component', require('./components/admin/pages/users/StudentManageComponent.vue').default);

//Education
Vue.component('faculty-component', require('./components/admin/pages/education/FacultyComponent.vue').default);
Vue.component('major-component', require('./components/admin/pages/education/MajorComponent.vue').default);
Vue.component('course-component', require('./components/admin/pages/education/CourseComponent.vue').default);

//Posts
Vue.component('post-component', require('./components/admin/pages/posts/PostComponent.vue').default);