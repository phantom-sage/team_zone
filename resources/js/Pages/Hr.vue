<template>
    <master-layout title="Hr">
        <slot name="sidebar">
            <div
                class="w-1/2 md:w-1/3 lg:w-64 fixed md:top-0 md:left-0 h-screen lg:block bg-gray-100 border-r"
                :class="sideBarOpen ? '' : 'hidden'"
                id="main-nav"
            >
                <div class="w-full h-20 border-b flex px-4 items-center mb-8">
                    <p class="font-semibold text-3xl text-blue-400 pl-4">TEAM ZONE</p>
                </div>

                <div class="mb-4 px-4">
                    <p class="pl-4 text-sm font-semibold mb-1">MAIN</p>
                    <div
                        class="w-full flex items-center text-blue-400 h-10 pl-4 bg-gray-200 hover:bg-gray-200 rounded-lg cursor-pointer"
                    >
                        <jet-nav-link :href="route('hr.manager.dashboard')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span class="text-gray-700">Dashboard</span>
                        </jet-nav-link>
                    </div>
                </div>
            </div>
        </slot>
        <div id="home">
            <div class="my-5 mx-auto">
                <Banner />
            </div>
            <div class="float-right my-4">
                <form @submit.prevent="logout">
                    <button type="submit" class="flex justify-between">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 d-inline" fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
            <div class="clearfix"></div>
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
                        <a href="#" class="text-gray-600">HR Manager</a>
                    </li>
                </ol>
            </nav>
            <!-- breadcrumb end -->
            <div class="lg:flex justify-between items-center mb-6">
                <p class="text-2xl font-semibold mb-2 lg:mb-0">Hello, {{ hr_manager_name }}</p>
            </div>
            <div class="flex flex-wrap -mx-3 mb-20">

                <div class="w-1/2 xl:w-1/4 px-3">
                    <div class="w-full bg-white border text-blue-400 rounded-lg flex items-center p-6 mb-6 xl:mb-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mr-4 lg:block" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                        </svg>

                        <div class="text-gray-700">
                            <p class="font-semibold text-3xl">10</p>
                            <p>Projects</p>
                        </div>

                    </div>
                </div>

                <div class="w-1/2 xl:w-1/4 px-3">
                    <div class="w-full bg-white border text-blue-400 rounded-lg flex items-center p-6 mb-6 xl:mb-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mr-4 hidden lg:block" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>

                        <div class="text-gray-700">
                            <p class="font-semibold text-3xl">20</p>
                            <p>Members</p>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Team Member Table header -->
            <div class="col-span-full xl:col-span-8 bg-white shadow-lg rounded-sm border border-gray-200 mb-8">
                <header class="flex justify-between px-5 py-4 border-b border-gray-100">
                    <h2 class="basis-3/4 mr-5 font-semibold text-gray-800 uppercase">Team Members</h2>
                    <button
                        class="basis-1/4 bg-blue-500 hover:bg-blue-600 focus:outline-none rounded-lg px-6 py-2 text-white font-semibold shadow"
                        type="button" v-on:click="toggleModal()">
                        Add New Member
                    </button>
                </header>
                <!-- Add New Member modal -->
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
                                        Add New Member
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
                                    <form action="#" method="POST">
                                        <div class="shadow overflow-hidden sm:rounded-md">
                                            <div class="px-4 py-5 bg-white sm:p-6">
                                                <div class="grid grid-cols-4 gap-4 ">
                                                    <div class="col-span-6 sm:col-span-4">
                                                        <label for="teamMemberName"
                                                               class="block text-sm font-medium text-gray-700">Name</label>
                                                        <input type="text" v-model="addTeamMemberForm.name" name="name" id="teamMemberName"
                                                               autocomplete="given-name"
                                                               class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                        <span class="text-red-600 font-weight-bold" v-if="addTeamMemberForm.errors.name">{{ addTeamMemberForm.errors.name }}</span>
                                                    </div>

                                                    <div class="col-span-6 sm:col-span-4">
                                                        <label for="teamMemberUserName"
                                                               class="block text-sm font-medium text-gray-700">Username</label>
                                                        <input type="text" v-model="addTeamMemberForm.username" name="username" id="teamMemberUserName"
                                                               autocomplete="given-name"
                                                               class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                        <span class="text-red-600 font-weight-bold" v-if="addTeamMemberForm.errors.username">{{ addTeamMemberForm.errors.username }}</span>
                                                    </div>

                                                    <div class="col-span-6 sm:col-span-4">
                                                        <label for="teamMemberEmail"
                                                               class="block text-sm font-medium text-gray-700">E-mail</label>
                                                        <input type="email" v-model="addTeamMemberForm.email" name="email" id="teamMemberEmail"
                                                               autocomplete="given-name"
                                                               class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                        <span class="text-red-600 font-weight-bold" v-if="addTeamMemberForm.errors.email">{{ addTeamMemberForm.errors.email }}</span>
                                                    </div>

                                                    <div class="col-span-6 sm:col-span-4">
                                                        <label for="teamMemberPassword"
                                                               class="block text-sm font-medium text-gray-700">Password</label>
                                                        <input type="password" v-model="addTeamMemberForm.password" name="password" id="teamMemberPassword"
                                                               autocomplete="given-name"
                                                               class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                        <span class="text-red-600 font-weight-bold" v-if="addTeamMemberForm.errors.password">{{ addTeamMemberForm.errors.password }}</span>
                                                    </div>


                                                    <div class="col-span-6 sm:col-span-4">
                                                        <label for="type"
                                                               class="block text-sm font-medium text-gray-700">Type</label>
                                                        <select v-model="addTeamMemberForm.type" id="type" name="type"
                                                                class="block w-full h-8 mt-1 bg-white border-2 border-gray-300 border-solid rounded-md shadow-sm focus:outline-none sm:text-sm">
                                                            <option value="project_manager">Project Manager</option>
                                                            <option value="team_member">Team Member</option>
                                                        </select>
                                                        <span class="text-red-600 font-weight-bold" v-if="addTeamMemberForm.errors.type">{{ addTeamMemberForm.errors.type }}</span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div><div
                                        class="flex items-center justify-end p-6 border-t border-solid border-blueGray-200 rounded-b">
                                        <button
                                            class="bg-blue-500 hover:bg-blue-600 focus:outline-none rounded-lg px-6 py-2 text-white font-semibold shadow uppercase text-sm outline-none  mr-1 mb-1 ease-linear transition-all duration-150"
                                            type="button" v-on:click="addTeamMember()">
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
                <!-- Table -->
                <div class="p-3">
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full">
                            <!-- Table navbar -->
                            <thead class="text-sm leading-normal uppercase text-gray-600 bg-gray-200 rounded-sm">
                            <tr>
                                <th class="p-2">
                                    <div class="font-semibold text-left">NAME</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-center">E-MAIL</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-center">TYPE</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-center">ACTIONS</div>
                                </th>
                            </tr>
                            </thead>
                            <!-- Table body -->
                            <tbody class="font-medium divide-y divide-gray-100 text-gray-600 text-sm">
                            <!-- Row1 -->
                            <tr v-for="team_member in team_members" class="border-b border-gray-200 hover:bg-gray-200">
                                <td class="p-2">
                                    <div class="flex">
                                        <div class="text-gray-800 py-3 text-left whitespace-nowrap">{{ team_member.name }}</div>
                                    </div>
                                </td>
                                <td class="p-2">
                                    <div class="text-center">{{ team_member.email }}</div>
                                </td>
                                <td class="p-2">
                                    <div class="text-center">{{ team_member.type }}</div>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        <div
                                            class="w-4 mr-2 transform hover:text-yellow-500 hover:scale-110 cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </div>
                                        <div
                                            class="w-4 mr-2 transform hover:text-red-500 hover:scale-110 cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </div>
                                    </div>
                                </td>
                            </tr>
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
import Banner from "@/Jetstream/Banner";
import MasterLayout from "@/Layouts/MasterLayout";
import {mapState} from "vuex";
import JetNavLink from '@/Jetstream/NavLink.vue'

export default {
    name: "Hr",
    props: {
        session_hr_manager_id: Object,
        hr_manager_name: Object,
        team_members: Object
    },
    mounted() {
        console.log(this.team_members)
    },
    computed: {
        ...mapState(['sideBarOpen'])
    },
    components: {
        Banner,
        MasterLayout,
        JetNavLink
    },
    data() {
        return {
            sideBarOpen: true,
            showModal: false,
            addTeamMemberForm: this.$inertia.form({
                name: '',
                username: '',
                password: '',
                email: '',
                type: ''
            }),
            logoutForm: this.$inertia.form({
                hr_manager_id: this.session_hr_manager_id
            })
        }
    },

    methods: {
        toggleModal: function () {
            this.showModal = !this.showModal;
        },
        logout() {
            this.logoutForm.delete(this.route('hr.logout'))
        },
        addTeamMember() {
            this.addTeamMemberForm.post(this.route('team_members.store'), {
                onSuccess: () => {
                    this.showModal = false
                    this.addTeamMemberForm.reset('name', 'username', 'password', 'email', 'type')
                }
            });
        }
    }
}
</script>

<style scoped>

</style>
