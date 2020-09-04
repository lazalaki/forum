<template>
    <div>
        <div :id="'reply-' + id" class="card mb-3">
            <div class="card-header" :class="isBest ? 'bg-success' : 'bg-default'">
                <div class="level">
                    <h5 class="flex">    
                        <a :href="'/profiles' + reply.owner.name"
                            v-text="reply.owner.name">
                        </a>
                        said <span v-text="ago"></span>
                    </h5>

                    <div v-if="signedIn">
                        <favorite-component :reply="reply"></favorite-component>
                    </div>
                </div>
            </div>         
                
            <div class="card-body">
                <div v-if="editing">
                    <form @submit="update">
                        <div class="form-group">
                            <wysiwyg-component v-model="body"></wysiwyg-component>
                            <!-- <textarea class="form-control" v-model="body" required></textarea> -->
                        </div>
                        <button class="btn btn-sm btn-secondary">Update</button>
                        <button class="btn btn-sm btn-danger" @click="editing = false" type="button">Cancel</button>
                    </form>
                </div>
                <div v-else v-html="body"></div>
                
            </div>
                <div class="card-footer level" v-if="authorize('owns', reply) || authorize('owns', reply.thread)">
                    <div v-if="authorize('owns', reply)">
                        <button class="btn btn-secondary btn-sm mr-2" @click="editing = true">Edit</button>
                        <button class="btn btn-danger btn-sm mr-2" @click="destroy">Delete</button>
                    </div>

                    <button class="btn btn-outline-secondary btn-sm ml-auto" @click="markBestReply" v-if="authorize('owns', reply.thread)">Best Reply?</button>
                </div>
        </div>
    </div>
</template>

<script>
import FavoriteComponent from './FavoriteComponent.vue';
import moment from 'moment';

    export default {
        props: ['reply'],

        components: {
            FavoriteComponent
        },

        data() {
            return {
                editing: false,
                id: this.reply.id,
                body: this.reply.body,
                isBest: this.reply.isBest,
            }
        },

        computed: {
            ago() {
                return moment(this.reply.created_at).fromNow() + '...'
            },

        },


        created() {
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.id)
            })
        },



        methods: {
            update() {
                axios.patch('/replies/' + this.id, {
                    body: this.body
                })
                .catch(error => {
                    flash(error.response.data, 'danger')
                });

                this.editing = false

                flash('Updated!')
            },

            destroy() {
                axios.delete('/replies/' + this.id)

                this.$emit('deleted', this.id);

            },

            markBestReply() {
                axios.post('/replies/' + this.id + '/best')

                window.events.$emit('best-reply-selected', this.id)
            }
        }
    }
</script>

