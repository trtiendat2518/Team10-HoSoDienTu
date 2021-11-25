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

import Error404 from './components/layouts/ErrorComponent.vue';

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
			}
		},

		{
			path: '/sinh-vien',
			name: 'student',
			components: {
				default: Student
			}
		},

		{
			path: '/khoa',
			name: 'faculty',
			components: {
				default: Faculty
			}
		},

		{
			path: '/chuyen-nganh',
			name: 'major',
			components: {
				default: Major
			}
		},

		{
			path: '/khoa-hoc',
			name: 'course',
			components: {
				default: Course
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
			]
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
			]
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