<template>
    <div>
        <Head :title="title"/>
        <div class="flex justify-between">
            <div class="grid w-2/12">
                <SideBar/>
            </div>
            <div class="grid w-10/12">
                <div class="container mx-auto">
                    <slot></slot>
                </div>
            </div>
        </div>
<!--        <div>-->
<!--            <SideBar/>-->
<!--        </div>-->
<!--        &lt;!&ndash; Page Content &ndash;&gt;-->
<!--        <main class="ml-auto w-full">-->
<!--            <slot></slot>-->
<!--        </main>-->
    </div>
</template>

<script>
import {Head, Link} from '@inertiajs/inertia-vue3'
import SideBar from "@/components/SideBar"

export default {
    props: {
        title: String,
    },
    components: {
        Head,
        Link,
        SideBar
    },
    name: "MasterLayout"
}
</script>

<style scoped>

</style>
