<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { useToast } from "vue-toastification";
import { useRouter } from "vue-router";

onMounted(async () => {
    getSingleStudent()
})

const router = useRouter()
const toast = useToast()
const loading = ref(false)
const fileName = ref("")

let form = ref({
    id: '',
    first_name: '',
    last_name: '',
    address: '',
    student_registration_number: '',
    contact_number: '',
    photo: ''
})

const props = defineProps({
    id: {
        type: String
    }
})

const getSingleStudent = async () => {
    let response = await axios.get(`/api/edit-student/${props.id}`)

    form.value = response.data.student
}

const getPhoto = () => {
    let photo = "/upload/no-image.png"
    if(form.value.photo) {
        if(form.value.photo.indexOf('base64') != -1) {
            photo = form.value.photo
        } else {
            let result = form.value.photo.substring(0, 4);
            if(result == "http") {
                return form.value.photo
            }
            photo = '/upload/' + form.value.photo
        }
    }

    return photo
}

const updatePhoto = (e) => {
    let file = e.target.files[0]
    let reader = new FileReader()
    let limit = 1024 * 1024 * 2

    if(file['size'] > limit) {
        return false
    }

    reader.onloadend = (file) => {
        form.value.photo = reader.result
    }

    reader.readAsDataURL(file)

    fileName.value = file
}

const update = () => {
    loading.value = true
    const formData = new FormData()

    formData.append('first_name', form.value.first_name)
    formData.append('last_name', form.value.last_name)
    formData.append('address', form.value.address)
    formData.append('student_registration_number', form.value.student_registration_number)
    formData.append('contact_number', form.value.contact_number)
    formData.append('photo', fileName.value)

    axios.post(`/api/update-student/${form.value.id}`, formData)
    .then((response) => {
        toast.success(response.data.message, {
            timeout: 2000
        });

        router.push('/')
    })
    .catch((error) => {
        toast.error(error.response.data.message, {
            timeout: 2000
        });
    })
    .finally(() => {
        loading.value = false
    })

}

</script>

<template>
    <div class="max-w-xl mx-auto py-10">
        <div class="text-center font-semibold text-black">
            Edit student
        </div>
        <form class="mt-8">
            <div class="mx-auto w-full">
                <div class="mt-8 text-center">
                    <img :src="getPhoto()" alt="" class="cursor-pointer m-auto rounded-full object-cover w-28 h-28 overflow-hidden">
                    <input type="file" id="myfile" @change="updatePhoto">
                </div>
                <div class="py-1 space-y-2">
                    <div>
                        <span class="px-1 text-sm text-gray-600">First Name</span>
                        <input v-model="form.first_name" placeholder="First Name" type="text" class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none">
                    </div>
                    <div>
                        <span class="px-1 text-sm text-gray-600">Last Name</span>
                        <input v-model="form.last_name" placeholder="Last Name" type="text" class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none">
                    </div>
                    <div>
                        <span class="px-1 text-sm text-gray-600">Address</span>
                        <input v-model="form.address" placeholder="Address" type="text" class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none">
                    </div>
                    <div>
                        <span class="px-1 text-sm text-gray-600">Registration No</span>
                        <input v-model="form.student_registration_number" placeholder="Registration No" type="text" class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none">
                    </div>
                    <div>
                        <span class="px-1 text-sm text-gray-600">Contact No</span>
                        <input v-model="form.contact_number" placeholder="Contact No" type="text" class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none">
                    </div>
                </div>
                <div class="flex justify-start mt-3 ml-4 p-1">
                    <ul>
                        <li class="flex items-center py-1">
                        </li>
                    </ul>
                </div>
                <button @click="update()" :disabled="loading" type="button" class="flex justify-center items-center rounded-lg bg-green-700 px-4 py-2 text-white disabled:opacity-70 disabled:cursor-not-allowed">
                    <span v-if="loading" class="flex">
                        <svg class="mr-3 h-5 w-5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="font-medium"> Processing... </span>
                    </span>
                    <span v-else class="flex">
                        <span class="font-medium"> Edit Student </span>
                    </span>
                </button>
            </div>
        </form>
    </div>
</template>
