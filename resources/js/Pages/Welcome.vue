<template>
    <Head title="Welcome" />

    <div class="relative flex justify-center min-h-screen bg-gray-100 items-top dark:bg-gray-900 sm:items-center sm:pt-0">
        <div v-if="canLogin" class="fixed top-0 right-0 hidden px-6 py-8 mb-5 sm:block">
            <Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm text-gray-700 underline">
                Dashboard
            </Link>

            <template v-else>

                <Link :href="route('login.as')" class="px-6 py-2 ml-4 mr-4 text-lg text-white transition ease-in-out delay-150 bg-blue-500 rounded-2xl hover:bg-blue-600 focus:outline-none hover:drop-shadow-xl">
                    Login as
                </Link>

                <Link :href="route('login')" class="px-6 py-2 ml-4 mr-4 text-lg text-white transition ease-in-out delay-150 bg-blue-500 rounded-2xl hover:bg-blue-600 focus:outline-none hover:drop-shadow-xl">
                    Admin login
                </Link>

                <Link v-if="canRegister" :href="route('register')" class="px-6 py-2 ml-4 mr-4 text-lg text-white transition ease-in-out delay-150 bg-blue-500 rounded-2xl hover:bg-blue-600 focus:outline-none hover:drop-shadow-xl">
                    Register
                </Link>
            </template>
        </div>
        <div class="container mx-auto mt-8">
            <div id="home">
                <!-- Header Section -->
                <div class="flex items-center justify-between mx-16 my-16">
                    <div class="w-3/5 space-y-6">
                        <h1 class="text-6xl font-bold text-blue-400">TeamZone</h1>
                        <h2 class="font-mono text-2xl tracking-normal text-gray-600 whitespace-normal">comprehensive solution that combines all the features one might need in
                            project management software Projects,Tasks,Contact Management,Team Collaboration,and Reporting.</h2>

                    </div>


                    <div class="w-2/5 px-28">
                        <!--                    <img v-bind:src="image.Url" width="50px" height="80px" alt="">-->
                        <img class="h-80 w-96" src="images/header.png" alt="">
                    </div>
                </div>

                <!-- Servies Section -->
                <div class="flex items-center justify-between px-10 my-16 mt-10 mb-8">
                    <div class="flex flex-col items-center w-3/12 space-x-2 space-y-2">
                        <img src="images/strategy-1.png" alt="">
                        <h2 class="text-xl font-bold">Open Source</h2>
                        <p class="text-center">open-source management and monitoring software platform,
                            to help smaller companies and startups to be able to control their projects and its involved teams</p>
                    </div>

                    <div class="flex flex-col items-center w-3/12 space-x-2 space-y-2">
                        <img src="images/strategy-2.png" alt="">
                        <h2 class="text-xl font-bold">Communication</h2>
                        <p class="text-center">Ease the communication between the project team members and sharing the documents by providing unicast chat communication between company's staff</p>
                    </div>

                    <div class="flex flex-col items-center w-3/12 space-x-2 space-y-2">
                        <img src="images/strategy-3.png" alt="">
                        <h2 class="text-xl font-bold">Monitoring</h2>
                        <p class="text-center">Give the client the ability to monitor the progress of its related projects</p>
                    </div>

                    <div class="flex flex-col items-center w-3/12 space-x-2 space-y-2">
                        <img src="images/strategy-4.png" alt="">
                        <h2 class="text-xl font-bold">Management Process</h2>
                        <p class="text-center">Facilitate the process of team and task management for the project manager, by applying tasks to team members,
                            and have the ability to monitor their progress. </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<style scoped>
    .bg-gray-100 {
        background-color: #f7fafc;
        background-color: rgba(247, 250, 252, var(--tw-bg-opacity));
    }

    .border-gray-200 {
        border-color: #edf2f7;
        border-color: rgba(237, 242, 247, var(--tw-border-opacity));
    }

    .text-gray-400 {
        color: #cbd5e0;
        color: rgba(203, 213, 224, var(--tw-text-opacity));
    }

    .text-gray-500 {
        color: #a0aec0;
        color: rgba(160, 174, 192, var(--tw-text-opacity));
    }

    .text-gray-600 {
        color: #718096;
        color: rgba(113, 128, 150, var(--tw-text-opacity));
    }

    .text-gray-700 {
        color: #4a5568;
        color: rgba(74, 85, 104, var(--tw-text-opacity));
    }

    .text-gray-900 {
        color: #1a202c;
        color: rgba(26, 32, 44, var(--tw-text-opacity));
    }

    @media (prefers-color-scheme: dark) {
        .dark\:bg-gray-800 {
            background-color: #2d3748;
            background-color: rgba(45, 55, 72, var(--tw-bg-opacity));
        }

        .dark\:bg-gray-900 {
            background-color: #1a202c;
            background-color: rgba(26, 32, 44, var(--tw-bg-opacity));
        }

        .dark\:border-gray-700 {
            border-color: #4a5568;
            border-color: rgba(74, 85, 104, var(--tw-border-opacity));
        }

        .dark\:text-white {
            color: #fff;
            color: rgba(255, 255, 255, var(--tw-text-opacity));
        }

        .dark\:text-gray-400 {
            color: #cbd5e0;
            color: rgba(203, 213, 224, var(--tw-text-opacity));
        }
    }
</style>

<script>
    import { defineComponent } from 'vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Head,
            Link,
        },

        props: {
            canLogin: Boolean,
            canRegister: Boolean,
            laravelVersion: String,
            phpVersion: String,
        }
    })
</script>
