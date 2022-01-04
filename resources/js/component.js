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

//Users
Vue.component(
    "lecturer-manage-component",
    require("./components/admin/pages/users/LecturerManageComponent.vue")
        .default
);
Vue.component(
    "student-manage-component",
    require("./components/admin/pages/users/StudentManageComponent.vue").default
);

//Education
Vue.component(
    "faculty-component",
    require("./components/admin/pages/education/FacultyComponent.vue").default
);
Vue.component(
    "major-component",
    require("./components/admin/pages/education/MajorComponent.vue").default
);
Vue.component(
    "course-component",
    require("./components/admin/pages/education/CourseComponent.vue").default
);

//Posts
Vue.component(
    "post-component",
    require("./components/admin/pages/posts/PostComponent.vue").default
);
Vue.component(
    "post-index-component",
    require("./components/admin/pages/posts/PostIndexComponent.vue").default
);
Vue.component(
    "post-create-component",
    require("./components/admin/pages/posts/PostCreateComponent.vue").default
);

//Subjects
Vue.component(
    "subject-component",
    require("./components/admin/pages/subjects/SubjectComponent.vue").default
);
