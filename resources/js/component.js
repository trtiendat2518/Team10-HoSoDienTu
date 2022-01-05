import Vue from "vue";

//Dashboard
Vue.component(
    "dashboard-component",
    require("./components/admin/pages/DashboardComponent.vue").default
);

//Layouts
Vue.component(
    "main-component",
    require("./components/MainComponent.vue").default
);
Vue.component(
    "slidebar-admin-component",
    require("./components/layouts/SlidebarAdminComponent.vue").default
);
Vue.component(
    "slidebar-lecturer-component",
    require("./components/layouts/SlidebarLecturerComponent.vue").default
);
Vue.component(
    "slidebar-teacher-component",
    require("./components/layouts/SlidebarTeacherComponent.vue").default
);

//Pagination
Vue.component(
    "pagination",
    require("./components/pagination/PaginationComponent.vue").default
);

//Avatar
Vue.component(
    "admin-avatar",
    require("./components/avatar/AdminAvatarComponent.vue").default
);
Vue.component(
    "deanfaculty-avatar",
    require("./components/avatar/DeanFacultyAvatarComponent.vue").default
);
Vue.component(
    "formteacher-avatar",
    require("./components/avatar/FormTeacherAvatarComponent.vue").default
);
