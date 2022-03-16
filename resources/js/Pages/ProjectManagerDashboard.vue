<template>
    <master-layout title="Project Manager">
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
                        <jet-nav-link :href="route('project.manager.dashboard')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span class="text-gray-700">Dashboard</span>
                        </jet-nav-link>
                    </div>
                    <div
                        class="w-full flex items-center text-blue-400 h-10 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
                        <form @submit.prevent="logout">
                            <button type="submit" class="flex justify-between">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 d-inline" fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span class="text-gray-700">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </slot>
        <div id="home">
            <div class="my-5 mx-auto">
                <Banner/>
            </div>
            <!-- logout -->
            <div class="float-right my-4">
                <div class="grid">
                    <div class="basis-6/12">
                        <div class="sticky top-0 z-40">
                            <div class="w-full h-20 px-6 bg-gray-100 border-b flex items-center justify-between">

                                <!-- right navbar -->
                                <div class="flex items-center relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 hover:text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"  @click="dropDownOpen = !dropDownOpen">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>

                            </div>

                            <!-- Messages dropdown menu -->
                            <div class="bg-gray-100 border border-t-0 shadow-xl text-gray-700 rounded-b-lg bottom-10 right-0 mr-6" :class="dropDownOpen ? '' : 'hidden'">
                                <div class="text-xl font-semibold text-gray-500 uppercase pt-1.5 pb-2 px-4">Chats</div>
                                <ul
                                    ref="dropdown"
                                    @focusin="dropdownOpen = true"
                                    @focusout="dropdownOpen = false"
                                >
                                    <li v-for="msg in project_manager_messages" class="border-b border-gray-200 last:border-0">
                                            <span class="font-medium text-gray-800">{{ msg?.message }}</span>
                                    </li>
                                </ul>
                                <button class="bg-blue-500 hover:bg-blue-600 focus:outline-none w-full px-6 py-2 text-white font-semibold shadow" type="button" v-on:click="toggleMessageDialog()">
                                    Send Message
                                </button>
                            </div>
                            <!-- dropdown menu end -->
                            <!--Messages modal -->
                            <div>
                                <div v-if="messageDialog" class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex">
                                    <div class="relative w-auto my-6 mx-auto max-w-3xl">
                                        <!--content-->
                                        <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                                            <!--header-->
                                            <div class="flex items-start justify-between p-5 border-b border-solid border-blueGray-200 rounded-t">
                                                <h3 class="text-xl font-semibold">
                                                    Send Message
                                                </h3>
                                                <button class="p-1 ml-auto bg-transparent border-0 text-blue-600 opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none" v-on:click="toggleModal()">
                          <span class="bg-transparent text-blue-600 opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
                            ×
                          </span>
                                                </button>
                                            </div>
                                            <!--body-->
                                            <div class="mt-5 md:mt-0 md:col-span-2">
                                                <form @submit.prevent="sendMessage" method="POST">
                                                    <div class="shadow overflow-hidden sm:rounded-md">
                                                        <div class="px-4 py-5 bg-white sm:p-6">
                                                            <div class="grid grid-cols-4 gap-4 ">
                                                                <div class="col-span-6 sm:col-span-4">
                                                                    <label for="messageText" class="block text-sm font-medium text-gray-700">Message</label>
                                                                    <textarea v-model="sendMessageForm.message" type="text" name="message" id="messageText" autocomplete="given-name" class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md"></textarea>
                                                                </div>
                                                                <div class="col-span-6 sm:col-span-4">
                                                                    <label for="receiverType" class="block text-sm font-medium text-gray-700">Receiver type</label>
                                                                    <select id="receiverType" v-model="sendMessageForm.recipient_type" name="recipient_type" autocomplete="receier_name" class="mt-1 h-8 bg-white focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                                        <option value="User">User</option>
                                                                        <option value="TeamMember">Team Member</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-span-6 sm:col-span-4">
                                                                    <label for="receiverId" class="block text-sm font-medium text-gray-700">Receiver</label>
                                                                    <select id="receiverId" v-model="sendMessageForm.recipient_id" name="receiver_id" autocomplete="receier_name" class="mt-1 h-8 bg-white focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                                        <template v-if="sendMessageForm.recipient_type === 'User'">
                                                                        <option v-for="item in admins" :value="item.id" :key="item.id">{{ item.name }}</option>
                                                                        </template>
                                                                        <template v-if="sendMessageForm.recipient_type === 'TeamMember'">
                                                                        <option v-for="item in team_members" :value="item.id" :key="item.id">{{ item.name }}</option>
                                                                        </template>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--footer-->
                                                    <div class="flex items-center justify-end p-6 border-t border-solid border-blueGray-200 rounded-b">
                                                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 focus:outline-none rounded-lg px-6 py-2 text-white font-semibold shadow uppercase text-sm outline-none  mr-1 mb-1 ease-linear transition-all duration-150">
                                                            Send
                                                        </button>
                                                        <button class="bg-blue-500 hover:bg-blue-600 focus:outline-none rounded-lg px-6 py-2 text-white font-semibold shadow uppercase text-sm outline-none  mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="closeMessageDialog()">
                                                            Close
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="messageDialog" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <!-- message dialog -->
<!--            <div-->
<!--                class="absolute bg-gray-100 border border-t-0 shadow-xl text-gray-700 rounded-b-lg top-0 left-0 bottom-0 right-0 mx-auto"-->
<!--                :class="messageDialog ? '' : 'hidden'">-->
<!--                <div>-->
<!--                    <div v-if="messageDialog"-->
<!--                         class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex">-->
<!--                        <div class="relative w-auto my-6 mx-auto max-w-3xl">-->
<!--                            &lt;!&ndash;content&ndash;&gt;-->
<!--                            <div-->
<!--                                class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">-->
<!--                                &lt;!&ndash;header&ndash;&gt;-->
<!--                                <div-->
<!--                                    class="flex items-start justify-between p-5 border-b border-solid border-blueGray-200 rounded-t">-->
<!--                                    <h3 class="text-xl font-semibold">-->
<!--                                        Send Message-->
<!--                                    </h3>-->
<!--                                    <button-->
<!--                                        class="p-1 ml-auto bg-transparent border-0 text-blue-600 opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none"-->
<!--                                        v-on:click="toggleModal()">-->
<!--                          <span-->
<!--                              class="bg-transparent text-blue-600 opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">-->
<!--                            ×-->
<!--                          </span>-->
<!--                                    </button>-->
<!--                                </div>-->
<!--                                &lt;!&ndash;body&ndash;&gt;-->
<!--                                <div class="mt-5 md:mt-0 md:col-span-2">-->
<!--                                    <form action="#" method="POST">-->
<!--                                        <div class="shadow overflow-hidden sm:rounded-md">-->
<!--                                            <div class="px-4 py-5 bg-white sm:p-6">-->
<!--                                                <div class="grid grid-cols-4 gap-4 ">-->
<!--                                                    <div class="col-span-6 sm:col-span-4">-->
<!--                                                        <label for="message"-->
<!--                                                               class="block text-sm font-medium text-gray-700">Message</label>-->
<!--                                                        <textarea type="text" name="message" id="message"-->
<!--                                                                  autocomplete="given-name"-->
<!--                                                                  class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md"></textarea>-->
<!--                                                    </div>-->
<!--                                                    <div class="col-span-6 sm:col-span-4">-->
<!--                                                        <label for="receier"-->
<!--                                                               class="block text-sm font-medium text-gray-700">Message-->
<!--                                                            Receier</label>-->
<!--                                                        <select id="receier" name="receier_name"-->
<!--                                                                autocomplete="receier_name"-->
<!--                                                                class="mt-1 h-8 bg-white focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">-->
<!--                                                            <option>Mohammed Ali</option>-->
<!--                                                            <option>Ajabain</option>-->
<!--                                                            <option>Osman Alhaj</option>-->
<!--                                                        </select>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </form>-->
<!--                                </div>-->
<!--                                &lt;!&ndash;footer&ndash;&gt;-->
<!--                                <div-->
<!--                                    class="flex items-center justify-end p-6 border-t border-solid border-blueGray-200 rounded-b">-->
<!--                                    <button-->
<!--                                        class="bg-blue-500 hover:bg-blue-600 focus:outline-none rounded-lg px-6 py-2 text-white font-semibold shadow uppercase text-sm outline-none  mr-1 mb-1 ease-linear transition-all duration-150"-->
<!--                                        type="button" v-on:click="toggleModal()">-->
<!--                                        Send-->
<!--                                    </button>-->
<!--                                    <button-->
<!--                                        class="bg-blue-500 hover:bg-blue-600 focus:outline-none rounded-lg px-6 py-2 text-white font-semibold shadow uppercase text-sm outline-none  mr-1 mb-1 ease-linear transition-all duration-150"-->
<!--                                        type="button" v-on:click="closeMessageDialog()">-->
<!--                                        Close-->
<!--                                    </button>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div v-if="messageDialog" class="opacity-25 fixed inset-0 z-40 bg-black"></div>-->
<!--                </div>-->
<!--            </div>-->
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
                <p class="text-2xl font-semibold mb-2 lg:mb-0">Hello, {{ project_manager.name }}</p>
            </div>
            <!-- Project Information -->
            <div class="col-span-full xl:col-span-8 bg-white shadow-lg rounded-sm border border-gray-200 mb-8">
                <header class="flex justify-between px-5 py-4 border-b border-gray-100">
                    <h2 class="basis-3/4 mr-5 font-semibold text-gray-800 uppercase">Project Information</h2>
                </header>
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
                                    <div class="font-semibold text-center">CLIENT</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-center">PROJECT DEADLINE</div>
                                </th>
                            </tr>
                            </thead>
                            <!-- Table body -->
                            <tbody class="font-medium divide-y divide-gray-100 text-gray-600 text-sm">
                            <!-- Row1 -->
                            <tr class="border-b border-gray-200 hover:bg-gray-200">
                                <td class="p-2">
                                    <div class="flex">
                                        <div class="text-gray-800 py-3 text-left whitespace-nowrap">
                                            {{ project_manager?.project?.name }}
                                        </div>
                                    </div>
                                </td>
                                <td class="p-2">
                                    <div class="text-center">{{ client.username }}</div>
                                </td>
                                <td class="p-2">
                                    <div class="text-center">{{ project_manager?.project.deadline }}</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- project Members Table -->
            <div class="col-span-full xl:col-span-8 bg-white shadow-lg rounded-sm border border-gray-200 mb-8">
                <header class="flex justify-between px-5 py-4 border-b border-gray-100">
                    <h2 class="basis-3/4 mr-5 font-semibold text-gray-800 uppercase">Project Members</h2>
                    <button
                        class="basis-1/4 bg-blue-500 hover:bg-blue-600 focus:outline-none rounded-lg px-6 py-2 text-white font-semibold shadow"
                        type="button" v-on:click="toggleModal()">
                        Add New Member
                    </button>
                </header>
                <!-- Add member to project form -->
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
                                        Add Project Member
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
                                    <form @submit.prevent="" method="POST">
                                        <div class="shadow overflow-hidden sm:rounded-md">
                                            <div class="px-4 py-5 bg-white sm:p-6">
                                                <div class="grid grid-cols-4 gap-4 ">
                                                    <div class="col-span-6 sm:col-span-4">
                                                        <label for="pmanager"
                                                               class="block text-sm font-medium text-gray-700">Members</label>
                                                        <select v-model="addTeamMemberForm.team_member_id" id="pmanager"
                                                                name="team_member_id"
                                                                autocomplete="pmanager-name"
                                                                class="mt-1 h-8 bg-white focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                            <option
                                                                v-for="legitimate_team_member in legitimate_team_members"
                                                                :value="legitimate_team_member.id"
                                                                :key="legitimate_team_member.id">
                                                                {{ legitimate_team_member.name }}
                                                            </option>
                                                            <span class="text-red-600 font-weight-bold"
                                                                  v-if="addTeamMemberForm.errors.team_member_id">{{
                                                                    addTeamMemberForm.errors.team_member_id
                                                                }}</span>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--footer-->
                                        <div
                                            class="flex items-center justify-end p-6 border-t border-solid border-blueGray-200 rounded-b">
                                            <button
                                                class="bg-blue-500 hover:bg-blue-600 focus:outline-none rounded-lg px-6 py-2 text-white font-semibold shadow uppercase text-sm outline-none  mr-1 mb-1 ease-linear transition-all duration-150"
                                                type="submit" v-on:click="submitAddTeamMember()">
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
                    <div v-if="showModal1" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
                </div>
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
                                    <div class="font-semibold text-center">ACTIONS</div>
                                </th>
                            </tr>
                            </thead>
                            <!-- Table body -->
                            <tbody class="font-medium divide-y divide-gray-100 text-gray-600 text-sm">
                            <!-- Row1 -->
                            <tr class="border-b border-gray-200 hover:bg-gray-200" v-for="staff in project?.staff"
                                :key="staff.id">
                                <td class="p-2">
                                    <div class="flex">
                                        <div class="text-gray-800 py-3 text-left whitespace-nowrap">{{
                                                staff.name
                                            }}
                                        </div>
                                    </div>
                                </td>
                                <td class="p-2">
                                    <div class="text-center">{{ staff.email }}</div>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
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
            <!-- Projects Tasks header -->
            <div class="col-span-full xl:col-span-8 bg-white shadow-lg rounded-sm border border-gray-200 mb-8">
                <header class="flex justify-between px-5 py-4 border-b border-gray-100">
                    <h2 class="basis-3/4 mr-5 font-semibold text-gray-800 uppercase">Tasks</h2>
                    <button
                        class="basis-1/4 bg-blue-500 hover:bg-blue-600 focus:outline-none rounded-lg px-6 py-2 text-white font-semibold shadow"
                        v-on:click="toggleModal1()">
                        Add New Task
                    </button>
                </header>
                <!-- Add New Task modal -->
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
                                        Add New Task
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
                                                        <label for="taskname"
                                                               class="block text-sm font-medium text-gray-700">Task
                                                            Name</label>
                                                        <input v-model="addNewTaskForm.name" type="text" name="name"
                                                               id="taskname"
                                                               autocomplete="given-name"
                                                               class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                        <span class="text-red-600 font-weight-bold"
                                                              v-if="addNewTaskForm.errors.name">{{
                                                                addNewTaskForm.errors.name
                                                            }}</span>
                                                    </div>

                                                    <div class="col-span-6 sm:col-span-4">
                                                        <label for="taskduration"
                                                               class="block text-sm font-medium text-gray-700">Task
                                                            Duration</label>
                                                        <input v-model="addNewTaskForm.duration" type="date"
                                                               name="duration" id="taskduration"
                                                               autocomplete="given-name"
                                                               class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                        <span class="text-red-600 font-weight-bold"
                                                              v-if="addNewTaskForm.errors.duration">{{
                                                                addNewTaskForm.errors.duration
                                                            }}</span>
                                                    </div>

                                                    <div class="col-span-6 sm:col-span-4">
                                                        <label for="taskdisc"
                                                               class="block text-sm font-medium text-gray-700">Task
                                                            Discription</label>
                                                        <input v-model="addNewTaskForm.description" type="text"
                                                               name="description" id="taskdisc"
                                                               autocomplete="given-name"
                                                               class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                        <span class="text-red-600 font-weight-bold"
                                                              v-if="addNewTaskForm.errors.description">{{
                                                                addNewTaskForm.errors.description
                                                            }}</span>
                                                    </div>

                                                    <div class="col-span-6 sm:col-span-4">
                                                        <label for="taskStatus"
                                                               class="block text-sm font-medium text-gray-700">Task
                                                            Status</label>
                                                        <input v-model="addNewTaskForm.status" type="text" name="status"
                                                               id="taskStatus"
                                                               autocomplete="given-name"
                                                               class="mt-1 h-8 focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                        <span class="text-red-600 font-weight-bold"
                                                              v-if="addNewTaskForm.errors.status">{{
                                                                addNewTaskForm.errors.status
                                                            }}</span>
                                                    </div>

                                                    <div class="col-span-6 sm:col-span-4">
                                                        <label for="tmember"
                                                               class="block text-sm font-medium text-gray-700">Members</label>
                                                        <select v-model="addNewTaskForm.team_member_id" id="tmember"
                                                                name="team_member_id" autocomplete="pmanager-name"
                                                                class="mt-1 h-8 bg-white focus:outline-none block w-full shadow-sm sm:text-sm border-solid border-2 border-gray-300 rounded-md">
                                                            <option :key="legitimate_team_member_for_task_assignment.id"
                                                                    :value="legitimate_team_member_for_task_assignment.id"
                                                                    v-for="legitimate_team_member_for_task_assignment in legitimate_team_members_for_task_assignment">
                                                                {{ legitimate_team_member_for_task_assignment.name }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--footer-->
                                        <div
                                            class="flex items-center justify-end p-6 border-t border-solid border-blueGray-200 rounded-b">
                                            <button
                                                class="bg-blue-500 hover:bg-blue-600 focus:outline-none rounded-lg px-6 py-2 text-white font-semibold shadow uppercase text-sm outline-none  mr-1 mb-1 ease-linear transition-all duration-150"
                                                type="button" v-on:click="submitAddNewTask()">
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
                                    <div class="font-semibold text-left">NAME</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-center">DURATION</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-center">MEMBER</div>
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
                            <tr class="border-b border-gray-200 hover:bg-gray-200" v-for="task in project_tasks"
                                :key="task.id">
                                <td class="p-2">
                                    <div class="flex">
                                        <div class="text-gray-800 py-3 text-left whitespace-nowrap">{{
                                                task.name
                                            }}
                                        </div>
                                    </div>
                                </td>
                                <td class="p-2">
                                    <div class="text-center">{{ task.duration }}</div>
                                </td>
                                <td class="p-2">
                                    <div class="text-center">{{ task?.master?.name }}</div>
                                </td>
                                <td class="p-2">
                                    <div class="text-center">
                                        <span class="bg-purple-200 text-purple-600 py-1 px-3 rounded-full text-xs">{{
                                                task.status
                                            }}</span>
                                    </div>
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
        </div>
    </master-layout>
</template>

<script>
import MasterLayout from "@/Layouts/MasterLayout"
import Banner from "@/Jetstream/Banner"
import {mapState} from 'vuex'
import JetNavLink from '@/Jetstream/NavLink.vue'

export default {
    name: "ProjectManagerDashboard",
    components: {
        MasterLayout,
        Banner,
        JetNavLink
    },
    mounted() {
        console.log(this.project_manager_messages)
    },
    props: {
        project_manager: Object,
        client: Object,
        project: Object,
        project_tasks: Object,
        legitimate_team_members: Object,
        legitimate_team_members_for_task_assignment: Object,
        session_project_manager_id: Object,
        admins: Object,
        team_members: Object,
        project_manager_messages: Object
    },
    computed: {
        ...mapState(['sideBarOpen'])
    },
    data() {
        return {
            sideBarOpen: true,
            dropDownOpen: false,
            showModal: false,
            showModal1: false,
            addTeamMemberForm: this.$inertia.form({
                team_member_id: '',
                project_id: this.project.id,
            }),
            addNewTaskForm: this.$inertia.form({
                name: '',
                duration: '',
                status: '',
                description: '',
                project_id: this.project.id,
                team_member_id: ''
            }),
            logoutForm: this.$inertia.form({
                project_manager_id: this.session_project_manager_id
            }),
            messageDialog: false,
            sendMessageForm: this.$inertia.form({
                message: '',
                sender_id: this.project_manager.id,
                recipient_id: '',
                sender_type: 'TeamMember',
                recipient_type: ''
            })
        }
    },
    methods: {
        sendMessage() {
            this.sendMessageForm.post(this.route('messages.store'), {
                onSuccess: () => this.messageDialog = false
            })
        },
        openMessageDialog() {
            this.messageDialog = true
        },
        toggleModal: function () {
            this.showModal = !this.showModal;
        },
        toggleModal1: function () {
            this.showModal1 = !this.showModal1;
        },
        submitAddTeamMember() {
            this.addTeamMemberForm.post(this.route('add.staff.to.project'), {
                onSuccess: () => this.showModal = false
            });
        },
        submitAddNewTask() {
            this.addNewTaskForm.post(this.route('tasks.store'), {
                onSuccess: () => this.showModal1 = false
            });
        },
        logout() {
            this.logoutForm.delete(this.route('project.manager.logout'))
        },
        toggleMessageDialog(){
            this.messageDialog = !this.messageDialog;
        },
        closeMessageDialog() {
            this.messageDialog = false
        }
    }
}
</script>

<style scoped>

</style>
<!--$data = $request->safe(['message', 'sender_id', 'recipient_id', 'sender_type', 'recipient_type']);-->
