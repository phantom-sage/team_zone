<template>
    <master-layout title="Report">
        <div id="home">
            <div class="flex flex-row mb-8">
                <form @submit.prevent="submit">
                    <div class="basis-4/12">
                        <label for="client-email" class="block text-sm font-medium text-gray-700">From Date</label>
                        <input type="date" v-model="form.from_date" name="from_date" id="client-email"
                               autocomplete="given-name"
                               class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                    </div>
                    <div class="basis-4/12">
                        <label for="client-email" class="block text-sm font-medium text-gray-700">To Date</label>
                        <input v-model="form.to_date" type="date" name="to_date" id="client-email"
                               autocomplete="given-name"
                               class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                    </div>
                    <div class="basis-4/12">
                        <label for="Projects" class="block text-sm font-medium text-gray-700">Project</label>
                        <select id="Projects" name="Projects" autocomplete="Projects-name"
                                class="mt-1 h-8 bg-white focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                            <option>All</option>
                            <option>Team Zone</option>
                            <option>ERP System</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-6 gap-4 px-5 py-4 border-b border-gray-100">
                        <button
                            class="col-start-1 col-end-3 w-40 bg-blue-500 hover:bg-blue-600 focus:outline-none rounded-lg px-6 py-2 text-white font-semibold shadow"
                            type="button" v-on:click="submit('extract')">
                            Extract
                        </button>
                        <button
                            class="col-end-7 col-span-2 w-40 bg-blue-500 hover:bg-blue-600 focus:outline-none rounded-lg px-6 py-2 text-white font-semibold shadow"
                            type="button" v-on:click="submit('send')">
                            Send
                        </button>
                    </div>
                </form>
            </div>

            <div class="p-3">
                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <!-- Table navbar -->
                        <thead class="text-sm leading-normal uppercase text-gray-600 bg-gray-200 rounded-sm">
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
                        <tbody class="font-medium divide-y divide-gray-100 text-gray-600 text-sm">
                        <!-- Row1 -->
                        <tr v-for="project in projects" :key="project.id"
                            class="border-b border-gray-200 hover:bg-gray-200">
                            <td class="p-2">
                                <div class="flex">
                                    <div class="text-gray-800 py-3 text-left whitespace-nowrap">{{ project.name }}</div>
                                </div>
                            </td>
                            <td class="p-2">
                                <div class="text-center">{{ project.owner.username }}</div>
                            </td>
                            <td class="p-2">
                                <div class="text-center">{{ project.manager?.name }}</div>
                            </td>
                            <td class="p-2">
                                <div class="text-center">
                                    <span class="bg-purple-200 text-purple-600 py-1 px-3 rounded-full text-xs" v-if="project.status =='Active'">
                                       Active
                                    </span>
                                    <span class="bg-green-200 text-purple-600 py-1 px-3 rounded-full text-xs" v-if="project.status =='completed'">
                                       Completed
                                    </span>
                                    <span class="bg-yellow-200 text-purple-600 py-1 px-3 rounded-full text-xs" v-if="project.status =='inprogress'">
                                       In-progress
                                    </span>
                                    <span class="bg-red-200 text-purple-600 py-1 px-3 rounded-full text-xs" v-if="project.status =='failed'">
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
        JetButton
    },
    data() {
        return {
            form: this.$inertia.form({
                from_date: '',
                to_date: '',
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
