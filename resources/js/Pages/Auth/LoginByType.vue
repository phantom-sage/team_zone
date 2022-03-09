<template>
    <master-layout title="Login as">
        <form @submit.prevent="submit" class="my-5" method="POST">
            <form @submit.prevent="" method="POST">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-4 gap-4 ">
                            <div class="col-span-6 sm:col-span-4">
                                <label for="email"
                                       class="block text-sm font-medium text-gray-700">Email-Address</label>
                                <input v-model="form.email" type="email" name="email" id="email"
                                       class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                <span class="text-red-600 font-weight-bold" v-if="form.errors.email">{{ form.errors.email }}</span>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="password"
                                       class="block text-sm font-medium text-gray-700">Password</label>
                                <input v-model="form.password" type="password" name="password" id="password"
                                       class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                <span class="text-red-600 font-weight-bold" v-if="form.errors.password">{{ form.errors.password }}</span>
                            </div>


                            <div class="col-span-6 sm:col-span-4">
                                <label for="type"
                                       class="block text-sm font-medium text-gray-700">Members</label>
                                <select v-model="form.type" id="type" name="type"
                                        class="mt-1 h-8 bg-white focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                    <option value="hr_manager">HR Manager</option>
                                    <option value="project_manager">Project Manager</option>
                                    <option value="team_member">Team Member</option>
                                </select>
                                <span class="text-red-600 font-weight-bold" v-if="form.errors.type">{{ form.errors.type }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--footer-->
                <div
                    class="flex items-center justify-end p-6 border-t border-solid border-blueGray-200 rounded-b">
                    <button
                        class="bg-blue-500 hover:bg-blue-600 focus:outline-none rounded-lg px-6 py-2 text-white font-semibold shadow uppercase text-sm outline-none  mr-1 mb-1 ease-linear transition-all duration-150"
                        type="submit" v-on:click="submit()">
                        Login
                    </button>
                </div>
            </form>
        </form>
    </master-layout>
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
