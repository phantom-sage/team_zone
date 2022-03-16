<template>
    <master-layout title="Report">
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
                        class="w-full flex items-center text-blue-400 h-10 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer"
                    >
                        <jet-nav-link :href="route('dashboard')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span class="text-gray-700">Dashboard</span>
                        </jet-nav-link>
                    </div>
                    <div class="w-full flex items-center text-blue-400 h-10 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
                        <jet-nav-link :href="route('admin.report.page')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="text-gray-700">Reports</span>
                        </jet-nav-link>
                    </div>
                </div>
            </div>
        </slot>
        <div id="home" class="p-8">
            <Banner />
            <!-- breadcrumb -->
            <nav class="mb-6 text-sm font-semibold" aria-label="Breadcrumb">
                <ol class="inline-flex p-0 list-none">
                    <li class="flex items-center text-blue-500">
                        <a href="#" class="text-gray-700">Dashboard</a>
                        <svg class="w-3 h-3 mx-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                            <path
                                d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/>
                        </svg>
                    </li>
                    <li class="flex items-center">
                        <a href="#" class="text-gray-600">Reports</a>
                    </li>
                </ol>
            </nav>
            <!-- breadcrumb end -->
            <div class="flex flex-row mb-8 ml-72">
                <form @submit.prevent="submit">
                    <div class="basis-4/12 my-5">
                        <label for="client-email" class="block text-sm font-medium text-gray-700">From Date</label>
                        <input type="date" v-model="form.from_date" name="from_date" id="client-email"
                               autocomplete="given-name"
                               class="block w-full h-8 mt-1 border-2 border-gray-300 border-solid rounded-md shadow-sm focus:outline-none sm:text-sm">
                    </div>
                    <div class="basis-4/12">
                        <label for="client-email" class="block text-sm font-medium text-gray-700">To Date</label>
                        <input v-model="form.to_date" type="date" name="to_date" id="client-email"
                               autocomplete="given-name"
                               class="block w-full h-8 mt-1 border-2 border-gray-300 border-solid rounded-md shadow-sm focus:outline-none sm:text-sm">
                    </div>
                    <div class="basis-4/12 my-5">
                        <label for="Projects" class="block text-sm font-medium text-gray-700">Project</label>
                        <select id="Projects" name="Projects" autocomplete="Projects-name" v-model="form.project"
                                class="block w-full h-8 mt-1 bg-white border-2 border-gray-300 border-solid rounded-md shadow-sm focus:outline-none sm:text-sm">
                            <option value="all">All</option>
                            <option :value="project.id" v-for="project in projects" :key="project.id">{{ project.name }}</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-6 gap-4 px-5 py-4 border-b border-gray-100">
                        <button
                            class="w-40 col-start-1 col-end-3 px-6 py-2 font-semibold text-white bg-blue-500 rounded-lg shadow hover:bg-blue-600 focus:outline-none"
                            type="button" v-on:click="submit('extract')">
                            Extract
                        </button>
                        <button
                            class="w-40 col-span-2 col-end-7 px-6 py-2 font-semibold text-white bg-blue-500 rounded-lg shadow hover:bg-blue-600 focus:outline-none"
                            type="button" v-on:click="submit('send')">
                            Send
                        </button>
                    </div>
                </form>
            </div>

            <div class="p-3">
                <div class="overflow-x-auto">
                    <table class="w-full table-auto">
                        <!-- Table navbar -->
                        <thead class="text-sm leading-normal text-gray-600 uppercase bg-gray-200 rounded-sm">
                        <tr>
                            <th class="p-2">
                                <div class="font-semibold text-left">PROJECT</div>
                            </th>
                            <th class="p-2">
                                <div class="font-semibold text-center">CLIENT</div>
                            </th>
                            <th class="p-2">
                                <div class="font-semibold text-center">PROJECT MANAGER</div>
                            </th>
                            <th class="p-2">
                                <div class="font-semibold text-center">STATUS</div>
                            </th>
                        </tr>
                        </thead>
                        <!-- Table body -->
                        <tbody class="text-sm font-medium text-gray-600 divide-y divide-gray-100">
                        <!-- Row1 -->
                        <tr v-for="project in projects" :key="project.id"
                            class="border-b border-gray-200 hover:bg-gray-200">
                            <td class="p-2">
                                <div class="flex">
                                    <div class="py-3 text-left text-gray-800 whitespace-nowrap">{{ project.name }}</div>
                                </div>
                            </td>
                            <td class="p-2">
                                <div class="text-center">{{ project?.owner?.username }}</div>
                            </td>
                            <td class="p-2">
                                <div class="text-center">{{ project?.manager?.name }}</div>
                            </td>
                            <td class="p-2">
                                <div class="text-center">
                                    <span class="px-3 py-1 text-xs text-purple-600 bg-purple-200 rounded-full" v-if="project.status =='Active'">
                                       Active
                                    </span>
                                    <span class="px-3 py-1 text-xs text-purple-600 bg-purple-200 rounded-full" v-if="project.status =='started'">
                                       Started
                                    </span>
                                    <span class="px-3 py-1 text-xs text-purple-600 bg-green-200 rounded-full" v-if="project.status =='completed'">
                                       Completed
                                    </span>
                                    <span class="px-3 py-1 text-xs text-purple-600 bg-yellow-200 rounded-full" v-if="project.status =='inprogress'">
                                       In-progress
                                    </span>
                                    <span class="px-3 py-1 text-xs text-purple-600 bg-red-200 rounded-full" v-if="project.status =='failed'">
                                       Failed
                                    </span>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </master-layout>
</template>

<script>
import MasterLayout from "@/Layouts/MasterLayout";
import JetButton from '@/Jetstream/Button.vue'
import {mapState} from 'vuex'
import JetNavLink from '@/Jetstream/NavLink.vue'
import Banner from "@/Jetstream/Banner"

export default {
    name: "Report",
    props: {
        projects: Object
    },
    mounted() {
        console.log(this.projects)
    },
    components: {
        MasterLayout,
        JetButton,
        JetNavLink,
        Banner
    },
    computed: {
        ...mapState(['sideBarOpen'])
    },
    data() {
        return {
            sideBarOpen: true,
            form: this.$inertia.form({
                from_date: '',
                to_date: '',
                project: '',
            })
        }
    },
    methods: {
        submit(msg) {
            if (msg === 'extract') {
                this.form.post(this.route('reports.export.pdf'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            } else if (msg === 'send') {
                this.form.post(this.route('reports.send.email'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    }
}
</script>

<style scoped>

</style>
