<template>
    <master-layout title="Team member dashboard">
        <div class="my-5 mx-auto">
            <Banner />
        </div>
        <div id="home">
            <!-- breadcrumb -->
            <nav class="text-sm font-semibold mb-6" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex">
                    <li class="flex items-center text-blue-500">
                        <a href="#" class="text-gray-700">Home</a>
                        <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                            <path
                                d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/>
                        </svg>
                    </li>
                    <li class="flex items-center">
                        <a href="#" class="text-gray-600">Dashboard</a>
                    </li>
                </ol>
            </nav>
            <!-- breadcrumb end -->

            <div class="lg:flex justify-between items-center mb-6">
                <p class="text-2xl font-semibold mb-2 lg:mb-0">Hello, {{ team_member.name }}</p>
                <button
                    class="basis-1/4 flex justify-between bg-blue-500 hover:bg-blue-600 focus:outline-none rounded-lg px-6 py-2 text-white font-semibold shadow"
                    v-on:click="toggleModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Upload Files
                </button>
            </div>
            <!-- Upload Files modal -->
            <div>
                <div v-if="showModal"
                     class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex">
                    <div class="relative w-auto my-6 mx-auto max-w-3xl">
                        <!--content-->
                        <div
                            class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                            <!--header-->
                            <div
                                class="flex items-start justify-between p-5 border-b border-solid border-blueGray-200 rounded-t">
                                <h3 class="text-xl font-semibold">
                                    Upload File
                                </h3>
                                <button
                                    class="p-1 ml-auto bg-transparent border-0 text-blue-600 opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none"
                                    v-on:click="toggleModal()">
                          <span
                              class="bg-transparent text-blue-600 opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
                            ×
                          </span>
                                </button>
                            </div>
                            <!--body-->
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <form @submit.prevent="" method="POST" enctype="multipart/form-data">
                                    {{ uploadFileForm?.errors }}
                                    <div class="shadow overflow-hidden sm:rounded-md">
                                        <div class="px-4 py-5 bg-white sm:p-6">
                                            <div class="grid grid-cols-4 gap-4 ">
                                                <div class="col-span-6 sm:col-span-4">
                                                    <label for="path"
                                                           class="block text-sm font-medium text-gray-700">File</label>
                                                    <input  @input="uploadFileForm.path = $event.target.files[0]" type="file" name="path" id="path"
                                                           autocomplete="given-name"
                                                           class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                </div>
                                                <div class="col-span-6 sm:col-span-4">
                                                    <input type="hidden" :value="project.id" name="project_id">
                                                </div>
                                                <div class="col-span-6 sm:col-span-4">
                                                    <label for="filetitle"
                                                           class="block text-sm font-medium text-gray-700">Title</label>
                                                    <input v-model="uploadFileForm.title" type="text" name="title" id="filetitle"
                                                           autocomplete="given-name"
                                                           class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                </div>

                                                <div class="col-span-6 sm:col-span-4">
                                                    <label for="fileDescription"
                                                           class="block text-sm font-medium text-gray-700">File
                                                        Discription</label>
                                                    <input v-model="uploadFileForm.description" type="text" name="description" id="fileDescription"
                                                           autocomplete="given-name"
                                                           class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--footer-->
                                    <div
                                        class="flex items-center justify-end p-6 border-t border-solid border-blueGray-200 rounded-b">
                                        <button
                                            class="bg-blue-500 hover:bg-blue-600 focus:outline-none rounded-lg px-6 py-2 text-white font-semibold shadow uppercase text-sm outline-none  mr-1 mb-1 ease-linear transition-all duration-150"
                                            type="submit" v-on:click="uploadFile()">
                                            Add
                                        </button>
                                        <button
                                            class="bg-blue-500 hover:bg-blue-600 focus:outline-none rounded-lg px-6 py-2 text-white font-semibold shadow uppercase text-sm outline-none  mr-1 mb-1 ease-linear transition-all duration-150"
                                            type="button" v-on:click="toggleModal()">
                                            Close
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="showModal" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
            </div>
            <!-- My Tasks Table -->
            <div class="col-span-full xl:col-span-8 bg-white shadow-lg rounded-sm border border-gray-200 mb-8">
                <header class="flex justify-between px-5 py-4 border-b border-gray-100">
                    <h2 class="basis-3/4 mr-5 font-semibold text-gray-800 uppercase">My Tasks</h2>
                </header>
                <!-- Table -->
                <div class="p-3">
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full">
                            <!-- Table navbar -->
                            <thead class="text-sm leading-normal uppercase text-gray-600 bg-gray-200 rounded-sm">
                            <tr>
                                <th class="p-2">
                                    <div class="font-semibold text-left">PROJECT NAME</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-center">TASK NAME</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-center">DURATION</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-center">STATUS</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-center">ACTIONS</div>
                                </th>
                            </tr>
                            </thead>
                            <!-- Table body -->
                            <tbody class="font-medium divide-y divide-gray-100 text-gray-600 text-sm">
                            <!-- Row1 -->
                            <tr class="border-b border-gray-200 hover:bg-gray-200">
                                <td class="p-2">
                                    <div class="flex">
                                        <div class="text-gray-800 py-3 text-left whitespace-nowrap">{{
                                                project.name
                                            }}
                                        </div>
                                    </div>
                                </td>
                                <td class="p-2">
                                    <div class="text-center">{{ team_member?.task?.name }}</div>
                                </td>
                                <td class="p-2">
                                    <div class="text-center">{{ team_member?.task?.duration }}</div>
                                </td>
                                <td class="p-2">
                                    <div class="text-center">
                                        <span class="bg-purple-200 text-purple-600 py-1 px-3 rounded-full text-xs">{{
                                                team_member?.task?.status
                                            }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex justify-center">
                                        <button
                                            class="w-4 mr-2 transform hover:text-yellow-500 hover:scale-110 cursor-pointer"
                                            v-on:click="toggleModal1()">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Task Change Status modal -->
                            <div>
                                <div v-if="showModal1"
                                     class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex">
                                    <div class="relative w-auto my-6 mx-auto max-w-3xl">
                                        <!--content-->
                                        <div
                                            class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                                            <!--header-->
                                            <div
                                                class="flex items-start justify-between p-5 border-b border-solid border-blueGray-200 rounded-t">
                                                <h3 class="text-xl font-semibold">
                                                    Task Status
                                                </h3>
                                                <button
                                                    class="p-1 ml-auto bg-transparent border-0 text-blue-600 opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none"
                                                    v-on:click="toggleModal1()">
                                  <span
                                      class="bg-transparent text-blue-600 opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
                                    ×
                                  </span>
                                                </button>
                                            </div>
                                            <!--body-->
                                            <div class="mt-5 md:mt-0 md:col-span-2">
                                                <form @submit.prevent="" method="POST">
                                                    <div class="shadow overflow-hidden sm:rounded-md">
                                                        <div class="px-4 py-5 bg-white sm:p-6">
                                                            <div class="grid grid-cols-4 gap-4 ">
                                                                <div class="col-span-6 sm:col-span-4">
                                                                    <label for="taskStatus"
                                                                           class="block text-sm font-medium text-gray-700">Status</label>
                                                                    <select v-model="updateTaskStatusForm.status" id="taskStatus" name="status"
                                                                            class="mt-1 h-8 bg-white focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                                        <option value="active">Active</option>
                                                                        <option value="completed">Completed</option>
                                                                        <option value="on-holding">On-holding</option>
                                                                        <option value="failed">Failed</option>
                                                                    </select>
                                                                    <span class="text-red-600 font-weight-bold" v-if="updateTaskStatusForm.errors.status">{{ updateTaskStatusForm.errors.status }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--footer-->
                                                    <div
                                                        class="flex items-center justify-end p-6 border-t border-solid border-blueGray-200 rounded-b">
                                                        <button
                                                            class="bg-blue-500 hover:bg-blue-600 focus:outline-none rounded-lg px-6 py-2 text-white font-semibold shadow uppercase text-sm outline-none  mr-1 mb-1 ease-linear transition-all duration-150"
                                                            type="submit" v-on:click="updateTaskStatus()">
                                                            Save
                                                        </button>
                                                        <button
                                                            class="bg-blue-500 hover:bg-blue-600 focus:outline-none rounded-lg px-6 py-2 text-white font-semibold shadow uppercase text-sm outline-none  mr-1 mb-1 ease-linear transition-all duration-150"
                                                            type="button" v-on:click="toggleModal1()">
                                                            Close
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="showModal1" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
                            </div>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Table -->
        </div>
    </master-layout>
</template>

<script>
import MasterLayout from "@/Layouts/MasterLayout"
import Banner from "@/Jetstream/Banner"

export default {
    name: "TeamMemberDashboard",
    components: {
        MasterLayout,
        Banner
    },
    props: {
        'team_member': Object,
        'project': Object
    },
    data() {
        return {
            showModal: false,
            showModal1: false,
            uploadFileForm: this.$inertia.form({
                title: '',
                description: '',
                path: '',
                project_id: this.project.id
            }),
            updateTaskStatusForm: this.$inertia.form({
                task_id: this.team_member?.task?.id,
                status: ''
            })
        }
    },
    methods: {
        toggleModal: function () {
            this.showModal = !this.showModal;
        },
        toggleModal1: function () {
            this.showModal1 = !this.showModal1;
        },
        uploadFile() {
            this.uploadFileForm.post(this.route('files.store'), {
                onSuccess: () => this.showModal = false
            });
        },
        updateTaskStatus() {
            this.updateTaskStatusForm.put(this.route('task.status.update'), {
                onSuccess: () => this.showModal1 = false
            });
        }
    }
}
</script>

<style scoped>

</style>
