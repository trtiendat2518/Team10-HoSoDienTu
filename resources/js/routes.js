import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
import Dashboard from './components/admin/pages/DashboardComponent.vue'

import Lecturer from './components/admin/pages/users/LecturerManageComponent.vue'
import Student from './components/admin/pages/users/StudentManageComponent.vue'
import FormTeacher from './components/admin/pages/users/FormTeacherComponent.vue'

import Faculty from './components/admin/pages/education/FacultyComponent.vue'
import Major from './components/admin/pages/education/MajorComponent.vue'
import Course from './components/admin/pages/education/CourseComponent.vue'

import Post from './components/admin/pages/posts/PostComponent.vue'
import PostIndex from './components/admin/pages/posts/PostIndexComponent.vue'
import PostCreate from './components/admin/pages/posts/PostCreateComponent.vue'
import PostUpdate from './components/admin/pages/posts/PostUpdateComponent.vue'

import Subject from './components/admin/pages/subjects/SubjectComponent.vue'
import SubjectIndex from './components/admin/pages/subjects/SubjectIndexComponent.vue'
import SubjectOther from './components/admin/pages/subjects/SubjectOtherComponent.vue'

import EducationProgram from './components/admin/pages/education_program/EducationProgramComponent.vue'
import EducationProgramIndex from './components/admin/pages/education_program/EducationProgramIndexComponent.vue'
import EducationProgramCreate from './components/admin/pages/education_program/EducationProgramCreateComponent.vue'
import EducationProgramUpdate from './components/admin/pages/education_program/EducationProgramUpdateComponent.vue'
import EducationProgramDetail from './components/admin/pages/education_program/EducationProgramDetailComponent.vue'
import ProgramType from './components/admin/pages/education_program/ProgramTypeComponent.vue'

import Procedure from './components/admin/pages/procedures/ProcedureComponent.vue'
import ProcedureIndex from './components/admin/pages/procedures/ProcedureIndexComponent.vue'
import ProcedureCreate from './components/admin/pages/procedures/ProcedureCreateComponent.vue'
import ProcedureUpdate from './components/admin/pages/procedures/ProcedureUpdateComponent.vue'
import ProcedureRequire from './components/admin/pages/procedures/ProcedureRequireComponent.vue'

import Calendar from './components/admin/pages/calendar/CalendarComponent.vue'
import CalendarIndex from './components/admin/pages/calendar/CalendarIndexComponent.vue'
import CalendarReference from './components/admin/pages/calendar/CalendarReferenceComponent.vue'

import ClassStudent from './components/admin/pages/class/ClassStudentComponent.vue'
import ClassStudentIndex from './components/admin/pages/class/ClassStudentIndexComponent.vue'
import ClassStudentDetail from './components/admin/pages/class/ClassStudentDetailComponent.vue'
import ClassStudentScore from './components/admin/pages/class/ClassStudentScoreComponent.vue'
import ClassStudentPlan from './components/admin/pages/class/ClassStudentPlanComponent.vue'

import EducationProgramStudent from './components/admin/pages/education_program_student/EducationProgramStudentComponent.vue'
import EducationProgramStudentIndex from './components/admin/pages/education_program_student/EducationProgramStudentIndexComponent.vue'
import EducationProgramStudentDetail from './components/admin/pages/education_program_student/EducationProgramStudentDetailComponent.vue'

import Info from './components/admin/pages/info/InfoComponent.vue'
import InfoIndex from './components/admin/pages/info/InfoIndexComponent.vue'
import InfoUpdate from './components/admin/pages/info/InfoUpdateComponent.vue'
import InfoCreate from './components/admin/pages/info/InfoCreateComponent.vue'

import InfoLecturer from './components/admin/pages/info/InfoLecturerComponent.vue'
import InfoLecturerIndex from './components/admin/pages/info/InfoLecturerIndexComponent.vue'
import InfoLecturerUpdate from './components/admin/pages/info/InfoLecturerUpdateComponent.vue'
import InfoLecturerCreate from './components/admin/pages/info/InfoLecturerCreateComponent.vue'

import InfoFormTeacher from './components/admin/pages/info/InfoFormTeacherComponent.vue'
import InfoFormTeacherIndex from './components/admin/pages/info/InfoFormTeacherIndexComponent.vue'
import InfoFormTeacherUpdate from './components/admin/pages/info/InfoFormTeacherUpdateComponent.vue'
import InfoFormTeacherCreate from './components/admin/pages/info/InfoFormTeacherCreateComponent.vue'

import RequestStudent from './components/admin/pages/request/RequestStudentComponent.vue'
import RequestStudentIndex from './components/admin/pages/request/RequestStudentIndexComponent.vue'

import FormTeacherClass from './components/admin/pages/formteacher_class/FormTeacherClassComponent.vue'
import FormTeacherClassIndex from './components/admin/pages/formteacher_class/FormTeacherClassIndexComponent.vue'
import FormTeacherClassDetail from './components/admin/pages/formteacher_class/FormTeacherClassDetailComponent.vue'
import FormTeacherClassScore from './components/admin/pages/formteacher_class/FormTeacherClassScoreComponent.vue'
import FormTeacherClassPlan from './components/admin/pages/formteacher_class/FormTeacherClassPlanComponent.vue'

import StudyPlanSuggest from './components/admin/pages/suggest/StudyPlanSuggestComponent.vue'
import StudyPlanSuggestIndex from './components/admin/pages/suggest/StudyPlanSuggestIndexComponent.vue'

import Error404 from './components/layouts/ErrorComponent.vue'

if (document.querySelector("meta[name='admin-fullname']") && document.querySelector("meta[name='admin-id']")) {
    Vue.prototype.$adminId = document.querySelector("meta[name='admin-fullname']").getAttribute('content')
    Vue.prototype.$adminCode = document.querySelector("meta[name='admin-id']").getAttribute('content')
} else if (document.querySelector("meta[name='deanfaculty-id']")) {
    Vue.prototype.$facultyId = document.querySelector("meta[name='deanfaculty-id']").getAttribute('content')
} else if (document.querySelector("meta[name='formteacher-id']")) {
    Vue.prototype.$teacherId = document.querySelector("meta[name='formteacher-id']").getAttribute('content')
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
                    next()
                } else {
                    next(false)
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
                    next()
                } else {
                    next(false)
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
                    next()
                } else {
                    next(false)
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
                    next()
                } else {
                    next(false)
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
                    next()
                } else {
                    next(false)
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
                    next()
                } else {
                    next(false)
                }
            }
        },

        {
            path: '/he-dao-tao',
            name: 'programtype',
            components: {
                default: ProgramType
            },
            beforeEnter: (to, from, next) => {
                if (Vue.prototype.$adminId != null) {
                    next()
                } else {
                    next(false)
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
                    next()
                } else {
                    next(false)
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

                {
                    path: 'tao-moi',
                    name: 'educationprogramcreate',
                    component: EducationProgramCreate
                },

                {
                    path: 'cap-nhat/:idProgram',
                    name: 'educationprogramupdate',
                    component: EducationProgramUpdate
                },

                {
                    path: 'chi-tiet/:idProgram',
                    name: 'educationprogramdetail',
                    component: EducationProgramDetail
                }
            ],
            beforeEnter: (to, from, next) => {
                if (Vue.prototype.$facultyId != null) {
                    next()
                } else {
                    next(false)
                }
            }
        },

        {
            path: '/thu-tuc',
            name: 'procedure',
            component: Procedure,
            children: [
                {
                    path: '',
                    name: 'procedureindex',
                    component: ProcedureIndex
                },

                {
                    path: 'tao-moi',
                    name: 'procedurecreate',
                    component: ProcedureCreate
                },

                {
                    path: 'cap-nhat/:idProcedure',
                    name: 'procedureupdate',
                    component: ProcedureUpdate
                },

                {
                    path: 'yeu-cau-cua-sinh-vien',
                    name: 'procedurerequire',
                    component: ProcedureRequire
                }
            ],
            beforeEnter: (to, from, next) => {
                if (Vue.prototype.$adminId != null) {
                    next()
                } else {
                    next(false)
                }
            }
        },

        {
            path: '/chu-nhiem-sinh-vien',
            name: 'formteacher',
            components: {
                default: FormTeacher
            },
            beforeEnter: (to, from, next) => {
                if (Vue.prototype.$facultyId != null) {
                    next()
                } else {
                    next(false)
                }
            }
        },

        {
            path: '/lich-bieu',
            name: 'calendar',
            component: Calendar,
            children: [
                {
                    path: '',
                    name: 'calendarindex',
                    component: CalendarIndex
                },
                {
                    path: 'rang-buoc-lich-bieu',
                    name: 'calendarreference',
                    component: CalendarReference
                }
            ],
            beforeEnter: (to, from, next) => {
                if (Vue.prototype.$facultyId != null) {
                    next()
                } else {
                    next(false)
                }
            }
        },

        {
            path: '/lop-hoc',
            name: 'classstudent',
            component: ClassStudent,
            children: [
                {
                    path: '',
                    name: 'classstudentindex',
                    component: ClassStudentIndex
                },
                {
                    path: 'sinh-vien/:idClass',
                    name: 'classstudentdetail',
                    component: ClassStudentDetail
                },
                {
                    path: 'xem-diem/:idClass/:idStudent',
                    name: 'classstudentscore',
                    component: ClassStudentScore
                },
                {
                    path: 'ke-hoach-hoc-tap/:idClass/:idStudent',
                    name: 'classstudentplan',
                    component: ClassStudentPlan
                }
            ],
            beforeEnter: (to, from, next) => {
                if (Vue.prototype.$facultyId != null) {
                    next()
                } else {
                    next(false)
                }
            }
        },

        {
            path: '/chuong-trinh-dao-tao-sinh-vien',
            name: 'educationprogramstudent',
            component: EducationProgramStudent,
            children: [
                {
                    path: '',
                    name: 'educationprogramstudentindex',
                    component: EducationProgramStudentIndex
                },
                {
                    path: ':idEPStudent',
                    name: 'educationprogramstudentdetail',
                    component: EducationProgramStudentDetail
                }
            ],
            beforeEnter: (to, from, next) => {
                if (Vue.prototype.$teacherId != null) {
                    next()
                } else {
                    next(false)
                }
            }
        },

        {
            path: '/thong-tin-ca-nhan',
            name: 'info',
            component: Info,
            children: [
                {
                    path: '',
                    name: 'infoindex',
                    component: InfoIndex
                },
                {
                    path: 'nhap-thong-tin',
                    name: 'infocreate',
                    component: InfoCreate
                },
                {
                    path: 'cap-nhat/:idAdmin',
                    name: 'infoupdate',
                    component: InfoUpdate
                }
            ],
            beforeEnter: (to, from, next) => {
                if (Vue.prototype.$adminId != null) {
                    next()
                } else {
                    next(false)
                }
            }
        },

        {
            path: '/thong-tin-ca-nhan-cua-ban-chu-nhiem-khoa',
            name: 'infolecturer',
            component: InfoLecturer,
            children: [
                {
                    path: '',
                    name: 'infolecturerindex',
                    component: InfoLecturerIndex
                },
                {
                    path: 'nhap-thong-tin',
                    name: 'infolecturercreate',
                    component: InfoLecturerCreate
                },
                {
                    path: 'cap-nhat/:idLecturer',
                    name: 'infolecturerupdate',
                    component: InfoLecturerUpdate
                }
            ],
            beforeEnter: (to, from, next) => {
                if (Vue.prototype.$facultyId != null) {
                    next()
                } else {
                    next(false)
                }
            }
        },

        {
            path: '/thong-tin-ca-nhan-cua-chu-nhiem-sinh-vien',
            name: 'infoformteacher',
            component: InfoFormTeacher,
            children: [
                {
                    path: '',
                    name: 'infoformteacherindex',
                    component: InfoFormTeacherIndex
                },
                {
                    path: 'nhap-thong-tin',
                    name: 'infoformteachercreate',
                    component: InfoFormTeacherCreate
                },
                {
                    path: 'cap-nhat/:idLecturer',
                    name: 'infoformteacherupdate',
                    component: InfoFormTeacherUpdate
                }
            ],
            beforeEnter: (to, from, next) => {
                if (Vue.prototype.$teacherId != null) {
                    next()
                } else {
                    next(false)
                }
            }
        },

        {
            path: '/yeu-cau-sinh-vien',
            name: 'requeststudent',
            component: RequestStudent,
            children: [
                {
                    path: '',
                    name: 'requeststudentindex',
                    component: RequestStudentIndex
                }
            ],
            beforeEnter: (to, from, next) => {
                if (Vue.prototype.$teacherId != null) {
                    next()
                } else {
                    next(false)
                }
            }
        },

        {
            path: '/lop-sinh-vien',
            name: 'formteacherclass',
            component: FormTeacherClass,
            children: [
                {
                    path: '',
                    name: 'formteacherclassindex',
                    component: FormTeacherClassIndex
                },
                {
                    path: ':idFTClass',
                    name: 'formteacherclassdetail',
                    component: FormTeacherClassDetail
                },
                {
                    path: 'xem-diem/:idFTClass/:idStudent',
                    name: 'formteacherclassscore',
                    component: FormTeacherClassScore
                },
                {
                    path: 'ke-hoach-hoc-tap/:idFTClass/:idStudent',
                    name: 'formteacherclassplan',
                    component: FormTeacherClassPlan
                }
            ],
            beforeEnter: (to, from, next) => {
                if (Vue.prototype.$teacherId != null) {
                    next()
                } else {
                    next(false)
                }
            }
        },

        {
            path: '/goi-y-ke-hoach-hoc-tap-sinh-vien',
            name: 'studyplansuggest',
            component: StudyPlanSuggest,
            children: [
                {
                    path: '',
                    name: 'studyplansuggestindex',
                    component: StudyPlanSuggestIndex
                }
            ],
            beforeEnter: (to, from, next) => {
                if (Vue.prototype.$teacherId != null) {
                    next()
                } else {
                    next(false)
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
        }
    ]
    //mode:'history'
})
