import Vue from 'vue'

//----------------------------------- ADMIN - DEAN OF FACULTY - FORM TEACHER -------------------------------------------
//Dashboard
Vue.component('dashboard-component', require('./components/admin/pages/DashboardComponent.vue').default)

//Layouts
Vue.component('main-component', require('./components/admin/MainComponent.vue').default)
Vue.component('slidebar-admin-component', require('./components/admin/layouts/SlidebarAdminComponent.vue').default)
Vue.component('slidebar-lecturer-component', require('./components/admin/layouts/SlidebarLecturerComponent.vue').default)
Vue.component('slidebar-teacher-component', require('./components/admin/layouts/SlidebarTeacherComponent.vue').default)

//Pagination
Vue.component('pagination', require('./components/pagination/PaginationComponent.vue').default)

//Avatar
Vue.component('admin-avatar', require('./components/avatar/AdminAvatarComponent.vue').default)
Vue.component('deanfaculty-avatar', require('./components/avatar/DeanFacultyAvatarComponent.vue').default)
Vue.component('formteacher-avatar', require('./components/avatar/FormTeacherAvatarComponent.vue').default)
Vue.component('student-avatar', require('./components/avatar/StudentAvatarComponent.vue').default)

//----------------------------------- STUDENT -------------------------------------------
Vue.component('small-slidebar-component', require('./components/student/layouts/SmallSlidebarComponent.vue').default)
Vue.component('main-student-component', require('./components/student/MainStudentComponent.vue').default)
Vue.component('home-component', require('./components/student/pages/HomeComponent.vue').default)
