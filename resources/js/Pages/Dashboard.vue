<template>
    <master-layout title="Dashboard">
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
                <p class="text-2xl font-semibold mb-2 lg:mb-0">Hello, {{ logged_in_name }}</p>
                <button
                    class="basis-1/4 bg-blue-500 hover:bg-blue-600 focus:outline-none rounded-lg px-6 py-2 text-white font-semibold shadow"
                    type="button" v-on:click="toggleHrModel()">
                    Add HR Manager
                </button>
            </div>
            <!-- Add HR Manager modal -->
            <div>
                <div v-if="hrShowModel"
                     class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex">
                    <div class="relative w-auto my-6 mx-auto max-w-3xl">
                        <!--content-->
                        <div
                            class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                            <!--header-->
                            <div
                                class="flex items-start justify-between p-5 border-b border-solid border-blueGray-200 rounded-t">
                                <h3 class="text-xl font-semibold">
                                    Add HR Manager
                                </h3>
                                <button
                                    class="p-1 ml-auto bg-transparent border-0 text-blue-600 opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none"
                                    v-on:click="toggleHrModel()">
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
                                                    <label for="hrname" class="block text-sm font-medium text-gray-700">User
                                                        Name</label>
                                                    <input type="text" v-model="hrForm.name" name="name" id="hrname"
                                                           autocomplete="given-name"
                                                           class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                    <span class="text-red-600 font-weight-bold" v-if="hrForm.errors.name">{{ hrForm.errors.name }}</span>
                                                </div>

                                                <div class="col-span-6 sm:col-span-4">
                                                    <label for="hrUsername"
                                                           class="block text-sm font-medium text-gray-700">E-mail</label>
                                                    <input type="text" v-model="hrForm.username" name="username" id="hrUsername"
                                                           autocomplete="given-name"
                                                           class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                    <span class="text-red-600 font-weight-bold" v-if="hrForm.errors.username">{{ hrForm.errors.username }}</span>
                                                </div>

                                                <div class="col-span-6 sm:col-span-4">
                                                    <label for="hrEmail"
                                                           class="block text-sm font-medium text-gray-700">Password</label>
                                                    <input type="email" v-model="hrForm.email" name="email" id="hrEmail"
                                                           autocomplete="given-name"
                                                           class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                    <span class="text-red-600 font-weight-bold" v-if="hrForm.errors.email">{{ hrForm.errors.email }}</span>
                                                </div>

                                                <div class="col-span-6 sm:col-span-4">
                                                    <label for="hrpassword"
                                                           class="block text-sm font-medium text-gray-700">Confirm
                                                        Password </label>
                                                    <input type="password" v-model="hrForm.password" name="password" id="hrpassword"
                                                           autocomplete="given-name"
                                                           class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                    <span class="text-red-600 font-weight-bold" v-if="hrForm.errors.password">{{ hrForm.errors.password }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="flex items-center justify-end p-6 border-t border-solid border-blueGray-200 rounded-b">
                                        <button
                                            class="bg-blue-500 hover:bg-blue-600 focus:outline-none rounded-lg px-6 py-2 text-white font-semibold shadow uppercase text-sm outline-none  mr-1 mb-1 ease-linear transition-all duration-150"
                                            type="submit" v-on:click="submit('hr')">
                                            Add
                                        </button>
                                        <button
                                            class="bg-blue-500 hover:bg-blue-600 focus:outline-none rounded-lg px-6 py-2 text-white font-semibold shadow uppercase text-sm outline-none  mr-1 mb-1 ease-linear transition-all duration-150"
                                            type="button" v-on:click="toggleModal1()">
                                            Close
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!--footer-->

                        </div>
                    </div>
                </div>
                <div v-if="hrShowModel" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
            </div>
            <!-- Shapes -->
            <div class="flex flex-wrap -mx-3 mb-20">

                <div class="w-1/2 xl:w-1/4 px-3">
                    <div class="w-full bg-white border text-blue-400 rounded-lg flex items-center p-6 mb-6 xl:mb-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mr-4 lg:block" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                        </svg>

                        <div class="text-gray-700">
                            <p class="font-semibold text-3xl">{{ projects.length }}</p>
                            <p>Projects</p>
                        </div>

                    </div>
                </div>

                <div class="w-1/2 xl:w-1/4 px-3">
                    <div class="w-full bg-white border text-blue-400 rounded-lg flex items-center p-6 mb-6 xl:mb-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 lg:block" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>

                        <div class="text-gray-700">
                            <p class="font-semibold text-3xl">{{ tasks_count }}</p>
                            <p>Tasks</p>
                        </div>
                    </div>
                </div>

                <div class="w-1/2 xl:w-1/4 px-3">
                    <div class="w-full bg-white border text-blue-400 rounded-lg flex items-center p-6">
                        <svg class="w-16 h-16 fill-current mr-4 hidden lg:block" viewBox="0 0 20 20">
                            <path
                                d="M14.999,8.543c0,0.229-0.188,0.417-0.416,0.417H5.417C5.187,8.959,5,8.772,5,8.543s0.188-0.417,0.417-0.417h9.167C14.812,8.126,14.999,8.314,14.999,8.543 M12.037,10.213H5.417C5.187,10.213,5,10.4,5,10.63c0,0.229,0.188,0.416,0.417,0.416h6.621c0.229,0,0.416-0.188,0.416-0.416C12.453,10.4,12.266,10.213,12.037,10.213 M14.583,6.046H5.417C5.187,6.046,5,6.233,5,6.463c0,0.229,0.188,0.417,0.417,0.417h9.167c0.229,0,0.416-0.188,0.416-0.417C14.999,6.233,14.812,6.046,14.583,6.046 M17.916,3.542v10c0,0.229-0.188,0.417-0.417,0.417H9.373l-2.829,2.796c-0.117,0.116-0.71,0.297-0.71-0.296v-2.5H2.5c-0.229,0-0.417-0.188-0.417-0.417v-10c0-0.229,0.188-0.417,0.417-0.417h15C17.729,3.126,17.916,3.313,17.916,3.542 M17.083,3.959H2.917v9.167H6.25c0.229,0,0.417,0.187,0.417,0.416v1.919l2.242-2.215c0.079-0.077,0.184-0.12,0.294-0.12h7.881V3.959z"></path>
                        </svg>

                        <div class="text-gray-700">
                            <p class="font-semibold text-3xl">{{ enquiries_count }}</p>
                            <p>New Enquiries</p>
                        </div>
                    </div>
                </div>

                <div class="w-1/2 xl:w-1/4 px-3">
                    <div class="w-full bg-white border text-blue-400 rounded-lg flex items-center p-6">
                        <svg class="w-16 h-16 fill-current mr-4 hidden lg:block" viewBox="0 0 20 20">
                            <path
                                d="M17.431,2.156h-3.715c-0.228,0-0.413,0.186-0.413,0.413v6.973h-2.89V6.687c0-0.229-0.186-0.413-0.413-0.413H6.285c-0.228,0-0.413,0.184-0.413,0.413v6.388H2.569c-0.227,0-0.413,0.187-0.413,0.413v3.942c0,0.228,0.186,0.413,0.413,0.413h14.862c0.228,0,0.413-0.186,0.413-0.413V2.569C17.844,2.342,17.658,2.156,17.431,2.156 M5.872,17.019h-2.89v-3.117h2.89V17.019zM9.587,17.019h-2.89V7.1h2.89V17.019z M13.303,17.019h-2.89v-6.651h2.89V17.019z M17.019,17.019h-2.891V2.982h2.891V17.019z"></path>
                        </svg>

                        <div class="text-gray-700">
                            <p class="font-semibold text-3xl">1,653</p>
                            <p>Product Views</p>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Projects Table header -->
            <div class="col-span-full xl:col-span-8 bg-white shadow-lg rounded-sm border border-gray-200 mb-8">
                <header class="flex justify-between px-5 py-4 border-b border-gray-100">
                    <h2 class="basis-3/4 mr-5 font-semibold text-gray-800 uppercase">Projects</h2>
                    <button
                        class="basis-1/4 bg-blue-500 hover:bg-blue-600 focus:outline-none rounded-lg px-6 py-2 text-white font-semibold shadow"
                        type="button" v-on:click="toggleModal1()">
                        Add New Project
                    </button>
                </header>
                <!-- Add New Project modal -->
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
                                        Add New Project
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
                                                        <label for="project-name"
                                                               class="block text-sm font-medium text-gray-700">Project
                                                            Name</label>
                                                        <input type="text" name="name" id="project-name" v-model="projectForm.name"
                                                               autocomplete="given-name"
                                                               class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                        <span class="text-red-600 font-weight-bold" v-if="projectForm.errors.name">{{ projectForm.errors.name }}</span>
                                                    </div>

                                                    <div class="col-span-6 sm:col-span-4">
                                                        <label for="client-name"
                                                               class="block text-sm font-medium text-gray-700">Client
                                                            Name</label>
                                                        <input type="text" name="client_username" id="client_username" v-model="projectForm.client_username"
                                                               autocomplete="given-name"
                                                               class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                        <span class="text-red-600 font-weight-bold" v-if="projectForm.errors.client_username">{{ projectForm.errors.client_username }}</span>
                                                    </div>

                                                    <div class="col-span-6 sm:col-span-4">
                                                        <label for="client-name"
                                                               class="block text-sm font-medium text-gray-700">Status</label>
                                                        <input type="text" name="status" id="client-name" v-model="projectForm.status"
                                                               autocomplete="given-name"
                                                               class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                        <span class="text-red-600 font-weight-bold" v-if="projectForm.errors.status">{{ projectForm.errors.status }}</span>
                                                    </div>

                                                    <div class="col-span-6 sm:col-span-4">
                                                        <label for="client-email"
                                                               class="block text-sm font-medium text-gray-700">Client
                                                            E-mail</label>
                                                        <input type="email" name="client_email" id="client_email" v-model="projectForm.client_email"
                                                               autocomplete="given-name"
                                                               class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                        <span class="text-red-600 font-weight-bold" v-if="projectForm.errors.client_email">{{ projectForm.errors.client_email }}</span>
                                                    </div>

                                                    <div class="col-span-6 sm:col-span-4">
                                                        <label for="pmanager"
                                                               class="block text-sm font-medium text-gray-700">Project
                                                            Manager</label>
                                                        <select id="pmanager" name="project_manager_id" v-model="projectForm.project_manager_id"
                                                                autocomplete="pmanager-name"
                                                                class="mt-1 h-8 bg-white focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                            <option :value="projectManager.id" v-for="projectManager in projectManagers" :key="projectManager.id">
                                                                {{ projectManager.name }}
                                                            </option>
                                                        </select>
                                                        <span class="text-red-600 font-weight-bold" v-if="projectForm.errors.project_manager_id">{{ projectForm.errors.project_manager_id }}</span>
                                                    </div>
                                                    <div class="col-span-6 sm:col-span-4">
                                                        <label for="client-email"
                                                               class="block text-sm font-medium text-gray-700">Project
                                                            Deadline</label>
                                                        <input type="date" name="deadline" id="client-email" v-model="projectForm.deadline"
                                                               autocomplete="given-name"
                                                               class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                        <span class="text-red-600 font-weight-bold" v-if="projectForm.errors.deadline">{{ projectForm.errors.deadline }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="flex items-center justify-end p-6 border-t border-solid border-blueGray-200 rounded-b">
                                            <button
                                                class="bg-blue-500 hover:bg-blue-600 focus:outline-none rounded-lg px-6 py-2 text-white font-semibold shadow uppercase text-sm outline-none  mr-1 mb-1 ease-linear transition-all duration-150"
                                                type="submit" v-on:click="submit('pro')">
                                                Add
                                            </button>
                                            <button
                                                class="bg-blue-500 hover:bg-blue-600 focus:outline-none rounded-lg px-6 py-2 text-white font-semibold shadow uppercase text-sm outline-none  mr-1 mb-1 ease-linear transition-all duration-150"
                                                type="button" v-on:click="toggleModal1()">
                                                Close
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <!--footer-->

                            </div>
                        </div>
                    </div>
                    <div v-if="showModal1" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
                </div>

                <!-- Table -->
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
                                <th class="p-2">
                                    <div class="font-semibold text-center">ACTIONS</div>
                                </th>
                            </tr>
                            </thead>
                            <!-- Table body -->
                            <tbody class="font-medium divide-y divide-gray-100 text-gray-600 text-sm">
                            <tr v-for="project in projects" :key="project.id" class="border-b border-gray-200 hover:bg-gray-200">
                                <td class="p-2">
                                    <div class="flex">
                                        <div class="text-gray-800 py-3 text-left whitespace-nowrap">{{ project.name }}</div>
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
                                        <span class="bg-purple-200 text-purple-600 py-1 px-3 rounded-full text-xs">{{ project.status }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        <div
                                            class="w-4 mr-2 transform hover:text-green-500 hover:scale-110 cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </div>
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


            <!-- Clients Table -->
            <div class="col-span-full xl:col-span-8 bg-white shadow-lg rounded-sm border border-gray-200 mb-5">
                <header class="flex justify-between px-5 py-4 border-b border-gray-100">
                    <h2 class="basis-3/4 mr-5 font-semibold text-gray-800 uppercase">Clients</h2>
                </header>

                <div class="p-3">
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full">
                            <!-- Table navbar -->
                            <thead class="text-sm leading-normal uppercase text-gray-600 bg-gray-200 rounded-sm">
                            <tr>
                                <th class="p-2">
                                    <div class="font-semibold text-left">CLIENT</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-center">PROJECT</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-center">PROJECT MANAGER</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-center">PROJECT DEADLINE</div>
                                </th>
                            </tr>
                            </thead>
                            <!-- Table body -->
                            <tbody class="font-medium divide-y divide-gray-100 text-gray-600 text-sm">
                            <tr class="border-b border-gray-200 hover:bg-gray-200" v-for="project in projects" :key="project.id">
                                <td class="p-2">
                                    <div class="flex">
                                        <div class="text-gray-800 py-3 text-left whitespace-nowrap">{{ project?.owner?.username }}</div>
                                    </div>
                                </td>
                                <td class="p-2">
                                    <div class="text-center">{{ project.name }}</div>
                                </td>
                                <td class="p-2">
                                    <div class="text-center">{{ project?.manager?.name }}</div>
                                </td>
                                <td class="p-2">
                                    <div class="text-center">{{ project.deadline }}</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End of Clients Table -->
        </div>
    </master-layout>
</template>

<script>
import {defineComponent} from 'vue'
import {Head} from '@inertiajs/inertia-vue3'
import Welcome from '@/Jetstream/Welcome.vue'
import MasterLayout from "@/Layouts/MasterLayout"

export default defineComponent({
    props: {
        projectManagers: Object,
        projects: Object,
        logged_in_name: Object,
        tasks_count: Object,
        enquiries_count: Object
    },
    mounted() {
    },
    components: {
        MasterLayout,
        Welcome,
        Head
    },
    data() {
        return {
            //  showModal: false,
            showModal1: false,
            hrShowModel: false,
            hrForm: this.$inertia.form({
                username: '',
                name: '',
                email: '',
                password: '',
            }),
            projectForm: this.$inertia.form({
                name: '',
                client_username: '',
                client_email: '',
                project_manager_id: '',
                deadline: '',
                status:'',
            })
        }
    },
    methods: {
        toggleModal1: function () {
            this.showModal1 = !this.showModal1;
        },
        mounted() {
            new Chart(document.getElementById('buyers-chart'), this.buyersData)
            new Chart(document.getElementById('reviews-chart'), this.reviewsData)
        },
        submit(msg) {
            if (msg === 'hr') {
                this.hrForm.post(this.route('hrs.store'), {
                    onFinish: () => this.hrForm.reset('password', 'password_confirmation'),
                    onSuccess: () => this.hrShowModel = false
                });

            }else if(msg === 'pro'){
                console.log(this.projectForm)
                this.projectForm.post(this.route('projects.store'), {
                    onFinish: () => this.projectForm.reset('username', 'name'),
                    onSuccess: () => this.showModal1 = false
                });
            }
        }
    }
})
</script>
