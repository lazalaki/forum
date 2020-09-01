<template>
    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply-component :reply="reply" @deleted="remove(index)"></reply-component>
        </div>

        <paginator-component :dataSet="dataSet" @changed="fetch"></paginator-component>

        <p v-if="$parent.locked">
            Thread has been locked. No more replies are allowd.
        </p>

        <new-reply-component @created="add" v-else></new-reply-component>
    </div>
</template>

<script>
import ReplyComponent from './ReplyComponent'
import NewReplyComponent from './NewReplyComponent'
import collection from '../mixins/collection'

    export default {

        mixins: [collection],

        components: {
            ReplyComponent,
            NewReplyComponent,
        },

        data() {
            return {
                dataSet: false,
            }
        },

        created() {
            this.fetch()
        },

        methods: {
            fetch(page) {
                axios.get(this.url(page))
                    .then(this.refresh);
            },

            url(page) {
                if(! page) {
                    let query = location.search.match(/page=(\d+)/)

                    page = query ? query[1] : 1
                }
                return `${location.pathname}/replies?page=${page}` 
            },


            refresh({data}) {
                this.dataSet = data;
                this.items = data.data;

                window.scrollTo(0, 0);
            },

        }
    }
</script>
