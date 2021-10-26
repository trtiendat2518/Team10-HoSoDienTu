// import Vue from 'vue';
// import VueRouter from 'vue-router'

// Vue.use(VueRouter)

// import Dashboard from './components/admin/pages/DashboardComponent.vue';
// import Slidebar from './components/admin/panels/SlidebarComponent.vue';
// import Lecturer from './components/admin/pages/lecturer/LecturerComponent.vue';
// import LecturerManage from './components/admin/pages/lecturer/LecturerManageComponent.vue';
// import LecturerDetail from './components/admin/pages/lecturer/LecturerDetailComponent.vue';

// export default new VueRouter({
// 	routes: [
// 		{
// 			path: '/admin/dashboard', 
// 			name: 'dashboard', 
// 			components: Dashboard
// 		},
// 		{ 	
// 			path: '/giang-vien', 
// 			name: 'lecturer', 
// 			component: Lecturer, 
// 			children: [
// 				{	path: '', 
// 					name: 'lecturerManage', 
// 					component: LecturerManage 
// 				},
// 				{ 	path: ':idLecturer', 
// 					name: 'lecturerDetail', 
// 					component: LecturerDetail,
// 					beforeEnter: (to, from, next) => {
// 						console.log('Action Router');
// 						next();
// 					}
// 				},
// 			] 
// 		},
// 	],
// 	//mode:'history'
// })