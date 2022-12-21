import { createRouter, createWebHistory } from 'vue-router'

import student from '../Components/Students/Student.vue'
import studentNew from '../Components/Students/NewStudent.vue'
import studentEdit from '../Components/Students/EditStudent.vue'

import notFound from '../Components/NotFound.vue'

const routes = [
    {
        path:'/',
        component: student
    },
    {
        path:'/new-student',
        component: studentNew
    },
    {
        path:'/edit-student/:id',
        component: studentEdit,
        props: true
    },
    {
        path: '/:pathMatch(.*)**',
        component : notFound
    }
]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
})

export default router;
