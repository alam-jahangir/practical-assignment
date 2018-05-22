<template>
    <ol class="breadcrumb" v-if="breadcrumbs.length">
        <li v-if="!isHomeExist">
            <router-link to="/">Home</router-link>
        </li>
        <li v-for="(crumb, key) in breadcrumbs">
            <router-link :to="linkProp(crumb)">{{ crumb | crumbText }}</router-link>
        </li>
    </ol>
</template>

<script>
    export default{
        props: {
            breadcrumbs: {
                type: Array,
                required: true,
                default() {}
            }
        },

        data() {
            return {
                isHomeExist: true
            }
        },

        watch: {
            breadcrumbs() {
                if (this.breadcrumbs[0].path == '/')
                    this.isHomeExist = true;
                else if (this.breadcrumbs[0].path == '')
                    this.isHomeExist = true;
                else
                    this.isHomeExist = false;

                //console.log(this.isHomeExist);
            }
        },

        created() {

            if (this.breadcrumbs[0].path == '/')
                this.isHomeExist = true;
            else if (this.breadcrumbs[0].path == '')
                this.isHomeExist = true;
            else
                this.isHomeExist = false;

            //console.log(this.isHomeExist);
        },

        methods: {
            // Return the correct prop data
            linkProp: function linkProp(crumb) {
                // If it's a named route, we'll base the route
                // off of that instead
                if (crumb.name || crumb.handler && crumb.handler.name) {
                    return {
                        name: crumb.name || crumb.handler.name,
                        params: this.$route.params
                    };
                }

                return {
                    path: crumb.handler && crumb.handler.fullPath ? crumb.handler.fullPath : crumb.path,
                    params: this.$route.params
                };
            }
        },

        filters: {
            // Display the correct breadcrumb text
            // depending on the Vue version
            crumbText: function crumbText(crumb) {
                return parseFloat(Vue.version) < 2 ? crumb.handler.breadcrumb : crumb.meta.breadcrumb;
            }
        }
    };
</script>