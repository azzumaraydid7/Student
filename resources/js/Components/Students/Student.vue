<script setup>
import axios from "axios";
import { onMounted, ref } from "vue"
import { useRouter } from "vue-router"
import { useToast } from "vue-toastification";

const router = useRouter()
const toast = useToast()

let students = ref([])
let show = ref(false)

onMounted(async() => {
    getStudents()
})

const getStudents = async() => {
    let response = await axios.get("/api/students")
    students.value = response.data.students
}

const profileImage = (img) => {
    let result = img.substring(0, 4);
    if(result == "http") {
        return img
    }
    return "/upload/" + img
}

const newStudent = () => {
    router.push('/new-student')
}

const onEdit = (id) => {
    router.push('/edit-student/' + id)
}


const deleteStudent = (id) => {
    sweetAlert.fire({
        title: 'Error!',
        text: 'Do you want to delete ?',
        icon: 'error',
        confirmButtonText: 'Confirm',
        showCancelButton: true,
    })
    .then((result) => {
        if(result.value) {
            axios.post('/api/delete-student/' + id)
            .then((response) => {
                toast.success(response.data.message, {
                    timeout: 2000
                });

                getStudents()
            })
            .catch((error) => {
                toast.success(error.response.data.message, {
                    timeout: 2000
                });
            })
        }
    })
}

</script>

<template>
    <div class="max-w-2xl mx-auto rounded my-6 space-y-4">
        <button @click="newStudent" type="button" class="flex items-center rounded-lg bg-green-700 px-4 py-2 text-white">
            <span class="font-medium">Add Student</span>
        </button>
        <table class="min-w-max w-full table-auto shadow-md">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Student</th>
                    <th class="py-3 px-6 text-left">Registration No</th>
                    <th class="py-3 px-6 text-left">Contact No</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody v-if="students.length > 0" class="text-gray-600 text-sm font-light">
                <tr v-for="student in students" :key="student.id" class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="mr-2">
                                <img class="w-6 h-6 rounded-full" :src="profileImage(student.photo)"/>
                            </div>
                            <span class="font-medium">{{ student.first_name }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-6 text-left">
                        <div class="flex items-center">
                            <span>{{ student.student_registration_number }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-6 text-left">
                        <span>{{ student.contact_number }}</span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center">
                            <div @click="onEdit(student.id)" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </div>
                            <div @click="deleteStudent(student.id)" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </div>
                            <div v-if="show" class="fixed top-0 left-0 w-full h-screen bg-black/50">
                                <div class="h-40">
                                    <button>
                                        Confirm
                                    </button>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<style>
body.swal2-toast-shown .swal2-container {
    background-color: #00000066 !important;
    width: 100% !important;
}

.swal2-container.swal2-center > .swal2-popup {
    width: unset !important;
}

</style>
