<template>
    <!-- <master-layout title="Login as"> -->
        <h1 class="mt-5 text-6xl font-bold text-center text-blue-400">TeamZone</h1>
        <form @submit.prevent="submit" class="px-5 my-10 mx-96" method="POST">
                <div class="overflow-hidden border border-gray-300 shadow-2xl rounded-xl">
                    <h1 class="mt-5 text-3xl font-bold text-center text-blue-400">LOGIN</h1>
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-4 gap-4 ">
                            <div class="col-span-6 sm:col-span-4">
                                <label for="email"
                                       class="block text-sm font-medium text-gray-700">Email-Address</label>
                                <input v-model="form.email" type="email" name="email" id="email"
                                       class="block w-full h-8 mt-1 border-2 border-gray-300 border-solid rounded-md shadow-sm focus:outline-none sm:text-sm">
                                <span class="text-red-600 font-weight-bold" v-if="form.errors.email">{{ form.errors.email }}</span>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="password"
                                       class="block text-sm font-medium text-gray-700">Password</label>
                                <input v-model="form.password" type="password" name="password" id="password"
                                       class="block w-full h-8 mt-1 border-2 border-gray-300 border-solid rounded-md shadow-sm focus:outline-none sm:text-sm">
                                <span class="text-red-600 font-weight-bold" v-if="form.errors.password">{{ form.errors.password }}</span>
                            </div>


                            <div class="col-span-6 sm:col-span-4">
                                <label for="type"
                                       class="block text-sm font-medium text-gray-700">Members</label>
                                <select v-model="form.type" id="type" name="type"
                                        class="block w-full h-8 mt-1 bg-white border-2 border-gray-300 border-solid rounded-md shadow-sm focus:outline-none sm:text-sm">
                                    <option value="hr_manager">HR Manager</option>
                                    <option value="project_manager">Project Manager</option>
                                    <option value="team_member">Team Member</option>
                                </select>
                                <span class="text-red-600 font-weight-bold" v-if="form.errors.type">{{ form.errors.type }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center p-6 border-t border-solid rounded-b border-blueGray-200">
                        <button

                            class="flex justify-between px-6 py-2 mb-1 mr-1 text-sm font-semibold text-white uppercase transition-all duration-150 ease-linear bg-blue-500 rounded-lg shadow outline-none hover:bg-blue-600 focus:outline-none"
                            type="submit" v-on:click="submit()">
                            Login
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </div>
                </div>

        </form>
    <!-- </master-layout> -->
</template>

<script>
import MasterLayout from "@/Layouts/MasterLayout"

export default {
    name: "LoginByType",
    components: {
        MasterLayout
    },
    data() {
        return {
            form: this.$inertia.form({
                email: '',
                password: '',
                type: ''
            })
        };
    },
    methods: {
        submit() {
            if (this.form.type === 'hr_manager') {
                this.form.post(this.route('login.as'));
            } else if (this.form.type === 'project_manager') {
                this.form.post(this.route('login.as'));
            } else if (this.form.type === 'team_member') {
                this.form.post(this.route('login.as'));
            }
        }
    }
}
</script>

<style scoped>

</style>
