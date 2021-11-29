import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
import Dashboard from './components/admin/pages/DashboardComponent.vue';
import SlidebarAdmin from './components/layouts/SlidebarAdminComponent.vue';
import SlidebarLecturer from './components/layouts/SlidebarLecturerComponent.vue';

import Lecturer from './components/admin/pages/users/LecturerManageComponent.vue';
import Student from './components/admin/pages/users/StudentManageComponent.vue';

import Faculty from './components/admin/pages/education/FacultyComponent.vue';
import Major from './components/admin/pages/education/MajorComponent.vue';
import Course from './components/admin/pages/education/CourseComponent.vue';

import Post from './components/admin/pages/posts/PostComponent.vue';
import PostIndex from './components/admin/pages/posts/PostIndexComponent.vue';
import PostCreate from './components/admin/pages/posts/PostCreateComponent.vue';
import PostUpdate from './components/admin/pages/posts/PostUpdateComponent.vue';

import Subject from './components/admin/pages/subjects/SubjectComponent.vue';
import SubjectIndex from './components/admin/pages/subjects/SubjectIndexComponent.vue';
import SubjectOther from './components/admin/pages/subjects/SubjectOtherComponent.vue';

import EducationProgram from './components/admin/pages/education_program/EducationProgramComponent.vue';
import EducationProgramIndex from './components/admin/pages/education_program/EducationProgramIndexComponent.vue';

import Error404 from './components/layouts/ErrorComponent.vue';

if (document.querySelector("meta[name='admin-fullname']")) {
    Vue.prototype.$adminId = document.querySelector("meta[name='admin-fullname']").getAttribute('content');
} else if (document.querySelector("meta[name='deanfaculty-id']")) {
    Vue.prototype.$facultyId = document.querySelector("meta[name='deanfaculty-id']").getAttribute('content');
} else if (document.querySelector("meta[name='formteacher-id']")) {
    Vue.prototype.$teacherId = document.querySelector("meta[name='formteacher-id']").getAttribute('content');
}

export default new VueRouter({
	routes: [
		{
			path: '/',
			name: 'dashboard',
			components: {
				default: Dashboard
			}
		},

		{
			path: '/giang-vien',
			name: 'lecturer',
			components: {
				default: Lecturer
			},
			beforeEnter: (to, from, next) => {
				if (Vue.prototype.$adminId != null) {	
					next();
				}else {
					next(false);
				}
			} 
		},

		{
			path: '/sinh-vien',
			name: 'student',
			components: {
				default: Student
			},
			beforeEnter: (to, from, next) => {
				if (Vue.prototype.$adminId != null) {	
					next();
				}else {
					next(false);
				}
			}
		},

		{
			path: '/khoa',
			name: 'faculty',
			components: {
				default: Faculty
			},
			beforeEnter: (to, from, next) => {
				if (Vue.prototype.$adminId != null) {	
					next();
				}else {
					next(false);
				}
			} 
		},

		{
			path: '/chuyen-nganh',
			name: 'major',
			components: {
				default: Major
			},
			beforeEnter: (to, from, next) => {
				if (Vue.prototype.$adminId != null) {	
					next();
				}else {
					next(false);
				}
			}
		},

		{
			path: '/khoa-hoc',
			name: 'course',
			components: {
				default: Course
			},
			beforeEnter: (to, from, next) => {
				if (Vue.prototype.$adminId != null) {	
					next();
				}else {
					next(false);
				}
			}
		},

		{
			path: '/bai-viet',
			name: 'post',
			component: Post,
			children: [
				{
					path: '',
					name: 'postindex',
					component: PostIndex
				},

				{
					path: 'tao-moi',
					name: 'postcreate',
					component: PostCreate
				},

				{
					path: 'cap-nhat/:idPost',
					name: 'postupdate',
					component: PostUpdate
				}
			],
			beforeEnter: (to, from, next) => {
				if (Vue.prototype.$adminId != null) {	
					next();
				}else {
					next(false);
				}
			}
		},

		{
			path: '/mon-hoc',
			name: 'subject',
			component: Subject,
			children: [
				{
					path: '',
					name: 'subjectindex',
					component: SubjectIndex
				},

				{
					path: 'khoa-khac',
					name: 'subjectother',
					component: SubjectOther
				}
			],
			beforeEnter: (to, from, next) => {
				if (Vue.prototype.$facultyId != null) {	
					next();
				}else {
					next(false);
				}
			}
		},

		{
			path: '/chuong-trinh-dao-tao',
			name: 'educationprogram',
			component: EducationProgram,
			children: [
				{
					path: '',
					name: 'educationprogramindex',
					component: EducationProgramIndex
				},
			],
			beforeEnter: (to, from, next) => {
				if (Vue.prototype.$facultyId != null) {	
					next();
				}else {
					next(false);
				}
			}
		},

		{ 	
			path: '/404', 
			name: 'error404', 
			component: Error404 
		},
		
		{	
			path: '*',
			redirect: { name: 'error404' }
		},
	],
	//mode:'history'
})